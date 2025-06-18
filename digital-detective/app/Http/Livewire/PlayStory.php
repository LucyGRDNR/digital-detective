<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Story;
use App\Models\Chapter;
use App\Models\Option;
use App\Models\Question;
use App\Models\UserStoryProgress;
use App\Models\UserStoryLog;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlayStory extends Component
{
    public $story;
    public $currentChapter;
    public $question;
    public $inputAnswer = '';
    public $selectedOptionId = null;
    public $feedbackMessage = '';
    public $isCorrect = false;
    public $isGameEnd = false;
    public $showFeedback = false;
    public $hintWasShown = false;
    public $progress;

    /**
     * Initializes the component with a given story.
     * Loads the first chapter of the story or resumes from saved progress.
     * @param Story $story The story model instance.
     * @param bool $start_over Optional: True if the user explicitly chose to start over.
     * @return void
     */
    public function mount(Story $story, $start_over = false)
    {
        $this->story = $story;
        $user = Auth::user();

        // Find or create the user's progress record for this story
        $this->progress = UserStoryProgress::firstOrNew([
            'user_id' => $user->id,
            'story_id' => $story->id,
        ]);

        // Determine if this is a fresh start (either 'start_over' or brand new progress)
        $isFreshStart = $start_over || !$this->progress->exists;

        // Logic for "Start New Story" or "Start Over":
        if ($start_over) {
            UserStoryLog::where('user_id', $user->id)
                        ->where('story_id', $story->id)
                        ->delete();

            $this->progress->current_chapter_id = null; // Reset to null or first chapter ID
            $this->progress->is_end = false;
            $this->progress->save();
        } elseif (!$this->progress->exists) {
            $this->progress->is_end = false;
            $this->progress->save();
        }

        if ($isFreshStart) {
            UserStoryLog::create([
                'user_id' => $user->id,
                'story_id' => $this->story->id,
                'event_type' => 'story_started',
                'event_description' => 'User started a new playthrough of the story.',
            ]);
        } else {
            if ($this->progress->current_chapter_id !== null && !$this->progress->is_end) {
                UserStoryLog::create([
                    'user_id' => $user->id,
                    'story_id' => $this->story->id,
                    'chapter_id' => $this->progress->current_chapter_id,
                    'event_type' => 'story_resumed',
                    'event_description' => 'User resumed the story.',
                ]);
            }
        }


        // Determine the chapter to load
        if (
            $this->progress->current_chapter_id === null ||
            $this->progress->is_end === true // If the previous session was marked as ended
        ) {
            $firstChapter = Chapter::where('story_id', $this->story->id)->orderBy('id')->first();
            if (!$firstChapter) {
                session()->flash('error', __('play.no_chapters_found_in_story'));
                return redirect()->route('home');
            }
            $this->loadChapter($firstChapter->id);

        } else {
            // Resume from existing progress
            $this->loadChapter($this->progress->current_chapter_id);
        }
        
        // Initialize the Livewire component's $isGameEnd based on the loaded chapter
        $this->isGameEnd = (bool)($this->currentChapter && $this->currentChapter->is_end);
    }

    /**
     * Loads a specific chapter by its ID and updates user progress.
     * @param int $chapterId The ID of the chapter to load.
     * @return void
     */
    public function loadChapter($chapterId)
    {
        $this->reset([
            'inputAnswer',
            'selectedOptionId',
            'feedbackMessage',
            'isCorrect',
            'showFeedback',
            'hintWasShown'
        ]);

        $this->currentChapter = Chapter::with('question.options')->find($chapterId);

        if (!$this->currentChapter || $this->currentChapter->story_id !== $this->story->id) {
            $this->feedbackMessage = __('play.invalid_chapter_access');
            $this->showFeedback = true;
            $this->isGameEnd = true;
            $this->progress->is_end = true;
            $this->progress->save();

            UserStoryLog::create([
                'user_id' => Auth::id(),
                'story_id' => $this->story->id,
                'chapter_id' => $chapterId,
                'event_type' => 'error_invalid_chapter_access',
                'event_description' => 'Attempted to access invalid chapter or chapter not in story. Story ended.',
            ]);
            return;
        }

        $this->question = $this->currentChapter->question;
        
        // Update the current chapter in the database progress record
        $this->progress->current_chapter_id = $this->currentChapter->id;
        // Reset is_end to false if we are moving to a new chapter that is not an end chapter
        if (!$this->currentChapter->is_end) {
            $this->progress->is_end = false;
        }
        $this->progress->save();

        // Update Livewire component's state
        $this->isGameEnd = (bool)($this->currentChapter->is_end);

        // If this chapter is an end chapter, mark 'completed' in DB and 'is_end'
        if ($this->isGameEnd) {
            $this->progress->is_end = true;
            if (!$this->progress->completed) {
                $this->progress->completed = true;
            }
            $this->progress->save();

            // Log story completion
            UserStoryLog::create([
                'user_id' => Auth::id(),
                'story_id' => $this->story->id,
                'chapter_id' => $this->currentChapter->id,
                'event_type' => 'story_completed',
                'event_description' => 'User reached the end of the story.',
            ]);
        } else {
            // Log chapter visit
            UserStoryLog::create([
                'user_id' => Auth::id(),
                'story_id' => $this->story->id,
                'chapter_id' => $this->currentChapter->id,
                'event_type' => 'chapter_visit',
                'event_description' => 'User visited chapter: ' . $this->currentChapter->title,
            ]);
        }
    }

    /**
     * Processes the user's submitted answer for the current question.
     * Validates the input, determines correctness, sets feedback messages,
     * and manages chapter progression or game end.
     * @return void
     */
    public function submitAnswer()
    {
        if (!$this->question) {
            $this->feedbackMessage = __('play.no_question_to_answer');
            $this->showFeedback = true;
            $this->isCorrect = false;
            return;
        }

        $nextChapterId = null;
        $isAnswerCorrect = false;
        $chosenOption = null;
        $userInput = null;

        try {
            if (in_array($this->question->type, [Question::TYPE_TEXT, Question::TYPE_NUMBER])) {
                $this->validate([
                    'inputAnswer' => $this->question->type === Question::TYPE_NUMBER ? 'required|numeric' : 'required|string',
                ], [
                    'inputAnswer.required' => __('play.validation_answer_required'),
                    'inputAnswer.numeric' => __('play.validation_number_invalid'),
                ]);

                $userInput = trim($this->inputAnswer);
                $correctOption = $this->question->options->firstWhere('is_correct', true);
                $correctAnswerText = $correctOption ? trim($correctOption->text) : '';

                if ($this->question->type === Question::TYPE_NUMBER) {
                    $isAnswerCorrect = ((float)$userInput === (float)$correctAnswerText);
                    $this->feedbackMessage = $isAnswerCorrect
                        ? ($correctOption->feedback_correct ?: __('play.correct_answer'))
                        : (($userInput < $correctAnswerText ? __('play.too_low') : __('play.too_high')) . "\n" . ($correctOption->feedback_incorrect ?: __('play.incorrect_answer')));
                } else { // Text type
                    $isAnswerCorrect = mb_strtolower($userInput) === mb_strtolower($correctAnswerText);
                    $this->feedbackMessage = $isAnswerCorrect
                        ? ($correctOption->feedback_correct ?: __('play.correct_answer'))
                        : ($correctOption->feedback_incorrect ?: __('play.incorrect_answer'));
                }

                $nextChapterId = $isAnswerCorrect
                    ? ($correctOption->next_chapter_id ?: $this->currentChapter->next_chapter_id)
                    : ($correctOption->next_chapter_id_incorrect ?: $this->currentChapter->next_chapter_id_incorrect);

            } elseif ($this->question->type === Question::TYPE_MULTIPLE_CHOICE) {
                $this->validate(['selectedOptionId' => 'required|exists:options,id'], [
                    'selectedOptionId.required' => __('play.validation_option_required'),
                ]);

                $chosenOption = Option::find($this->selectedOptionId);
                $userInput = $chosenOption->text; // Store the text of the chosen option

                if ($chosenOption && $chosenOption->question_id === $this->question->id) {
                    $isQuizMode = $this->question->options->contains(fn ($opt) => (bool)$opt->is_correct);

                    if ($isQuizMode) {
                        $isAnswerCorrect = (bool)$chosenOption->is_correct;
                        $this->feedbackMessage = $isAnswerCorrect
                            ? ($chosenOption->feedback_correct ?: __('play.correct_answer'))
                            : ($chosenOption->feedback_incorrect ?: __('play.incorrect_answer'));

                        $nextChapterId = $isAnswerCorrect
                            ? ($chosenOption->next_chapter_id ?: $this->currentChapter->next_chapter_id)
                            : ($chosenOption->next_chapter_id_incorrect ?: $this->currentChapter->next_chapter_id_incorrect);
                    } else {
                        // Branching narrative: any option chosen is considered 'correct' for progression
                        $isAnswerCorrect = true; // Always true for progression in branching narratives
                        $this->feedbackMessage = $chosenOption->feedback_correct ?: '';
                        $nextChapterId = $chosenOption->next_chapter_id ?: $this->currentChapter->next_chapter_id;
                    }
                } else {
                    throw ValidationException::withMessages(['selectedOptionId' => __('play.invalid_option_chosen')]);
                }
            }

            $this->isCorrect = $isAnswerCorrect;
            $this->showFeedback = true;

            // Log the question answer before determining next step
            UserStoryLog::create([
                'user_id' => Auth::id(),
                'story_id' => $this->story->id,
                'chapter_id' => $this->currentChapter->id,
                'question_id' => $this->question->id,
                'option_id' => $chosenOption ? $chosenOption->id : null,
                'user_input' => $userInput,
                'is_correct_answer' => $isAnswerCorrect,
                'event_type' => 'Youtubeed',
                'event_description' => 'User answered question: "' . $this->question->text . '" - ' . ($isAnswerCorrect ? 'Correct' : 'Incorrect'),
            ]);


            // Determine the next step based on answer correctness and chapter links
            if ($this->currentChapter->is_end) {
                $this->isGameEnd = true;
                $this->progress->is_end = true;
                if (!$this->progress->completed) {
                    $this->progress->completed = true;
                }
                $this->progress->save();
                $this->feedbackMessage = $this->feedbackMessage ?: __('play.story_finished_congratulations');
            } elseif ($nextChapterId) {
                $this->loadChapter($nextChapterId);
            } else {
                $this->isGameEnd = true;
                $this->progress->is_end = true;
                $this->progress->save();
                $this->feedbackMessage = $this->feedbackMessage ?: __('play.unexpected_story_end');

                // Log unexpected end after answer
                UserStoryLog::create([
                    'user_id' => Auth::id(),
                    'story_id' => $this->story->id,
                    'chapter_id' => $this->currentChapter->id,
                    'event_type' => 'unexpected_end',
                    'event_description' => 'Story ended unexpectedly after answering question.',
                ]);
            }

        } catch (ValidationException $e) {
            $this->feedbackMessage = $e->validator->errors()->first();
            $this->showFeedback = true;
            $this->isCorrect = false;

            // Log validation error for answer
            UserStoryLog::create([
                'user_id' => Auth::id(),
                'story_id' => $this->story->id,
                'chapter_id' => $this->currentChapter->id,
                'question_id' => $this->question->id,
                'user_input' => $userInput,
                'is_correct_answer' => null,
                'event_type' => 'answer_validation_error',
                'event_description' => 'Validation error on answer: ' . $this->feedbackMessage,
            ]);

        } finally {
            $this->inputAnswer = '';
            $this->selectedOptionId = null;
        }
    }

    /**
     * This method is for chapters that don't have questions, just text to read and then continue.
     * @return void
     */
    public function continueGame()
    {

        if ($this->isGameEnd) {
            UserStoryLog::create([
                'user_id' => Auth::id(),
                'story_id' => $this->story->id,
                'chapter_id' => $this->currentChapter->id,
                'event_type' => 'story_exit_from_end_chapter',
                'event_description' => 'User exited story after reaching an end chapter.',
            ]);
            return redirect()->route('stories.show', $this->story->id);
        }

        // If there's a next chapter linked, load it
        if ($this->currentChapter && $this->currentChapter->next_chapter_id) {
            $this->loadChapter($this->currentChapter->next_chapter_id);
        } elseif ($this->currentChapter && $this->currentChapter->is_end) {
            // If it's an end chapter, mark the current session as ended in DB
            $this->isGameEnd = true;
            $this->progress->is_end = true;
            if (!$this->progress->completed) {
                $this->progress->completed = true;
            }
            $this->progress->save();
            $this->feedbackMessage = __('play.end_story_congratulations');
            $this->showFeedback = true;

            // Log story completion
            UserStoryLog::create([
                'user_id' => Auth::id(),
                'story_id' => $this->story->id,
                'chapter_id' => $this->currentChapter->id,
                'event_type' => 'story_completed',
                'event_description' => 'User completed story via continue on end chapter.',
            ]);

        } else {
            // Unexpected end of story path (no next chapter and not an end chapter)
            $this->isGameEnd = true;
            $this->progress->is_end = true;
            $this->progress->save();
            $this->feedbackMessage = __('play.unexpected_story_end');
            $this->showFeedback = true;

            // Log unexpected end
            UserStoryLog::create([
                'user_id' => Auth::id(),
                'story_id' => $this->story->id,
                'chapter_id' => $this->currentChapter->id,
                'event_type' => 'unexpected_end',
                'event_description' => 'Story ended unexpectedly via continue button.',
            ]);
        }
    }

    /**
     * Clears the displayed feedback message and hides the feedback area.
     * If the game has ended, redirects.
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|void
     */
    public function clearFeedbackAndContinue()
    {
        if ($this->isGameEnd) {
            return redirect()->route('stories.show', $this->story->id);
        }

        $this->showFeedback = false;
        $this->feedbackMessage = '';
        $this->isCorrect = false;
        $this->hintWasShown = false;
    }

    /**
     * Sets the `hintWasShown` property to true, making the hint visible in the UI
     * @return void
     */
    public function showHint()
    {
        $this->hintWasShown = true;
    }

    /**
     * Sets the `hintWasShown` property to false, hiding the hint in the UI
     * @return void
     */
    public function hideHint()
    {
        $this->hintWasShown = false;
    }

    /**
     * Renders the Livewire component view.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.play-story');
    }
}
<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Story;
use App\Models\Chapter;
use App\Models\Option;
use App\Models\Question;
use App\Models\UserStoryProgress;
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
    public $userXp;
    public $userLevel;

    const XP_PER_QUESTION = 5;
    const XP_PER_LEVEL_THRESHOLD = 75;

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

        $this->userXp = $user->xp;
        $this->userLevel = $user->level;

        $this->progress = UserStoryProgress::firstOrNew([
            'user_id' => $user->id,
            'story_id' => $story->id,
        ]);

        $isFreshStart = $start_over || !$this->progress->exists;
        if ($start_over) {
            $this->progress->current_chapter_id = null;
            $this->progress->is_end = false;
            $this->progress->save();
        } elseif (!$this->progress->exists) {
            $this->progress->is_end = false;
            $this->progress->save();
        }

        if (
            $this->progress->current_chapter_id === null ||
            $this->progress->is_end === true
        ) {
            $firstChapter = Chapter::where('story_id', $this->story->id)->orderBy('id')->first();
            if (!$firstChapter) {
                session()->flash('error', __('play.no_chapters_found_in_story'));
                return redirect()->route('home');
            }
            $this->loadChapter($firstChapter->id);

        } else {
            $this->loadChapter($this->progress->current_chapter_id);
        }
        
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
        $this->question = $this->currentChapter->question;

        if ($this->currentChapter->is_end) {
            $this->isGameEnd = true;
        }

        $this->question = $this->currentChapter->question;
        
        $this->progress->current_chapter_id = $this->currentChapter->id;

        if (!$this->currentChapter->is_end) {
            $this->progress->is_end = false;
        }
        $this->progress->save();


        $this->isGameEnd = (bool)($this->currentChapter->is_end);

        if ($this->isGameEnd) {
            $this->progress->is_end = true;
            if (!$this->progress->completed) {
                $this->progress->completed = true;
                $this->awardXpAndCheckLevelUp();
            }
            $this->progress->save();
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
        $this->showFeedback = true; 

       try {
            if (in_array($this->question->type, [1, 2])) {
                $this->validate([
                    'inputAnswer' => $this->question->type === 2 ? 'required|numeric' : 'required|string',
                ], [
                    'inputAnswer.required' => __('play.validation_answer_required'),
                    'inputAnswer.numeric' => __('play.validation_number_invalid'),
                ]);

                $userAnswer = trim($this->inputAnswer);
                $correctAnswer = trim($this->question->input_answer);

                if ($this->question->type === 2) {
                    $this->isCorrect = ((float)$userAnswer === (float)$correctAnswer);
                    $this->feedbackMessage = $this->isCorrect
                        ? ''
                        : (($userAnswer < $correctAnswer ? __('play.too_low') : __('play.too_high')) . "\n" . ($this->question->wrong_feedback ?? '')); // Only display wrong_feedback if it exists
                } else {
                    $this->isCorrect = mb_strtolower($userAnswer) === mb_strtolower($correctAnswer);
                    $this->feedbackMessage = $this->isCorrect
                        ?  ''
                        : ($this->question->wrong_feedback ?? '');
                }

                if ($this->isCorrect) {
                    if ($this->currentChapter->is_end) {
                        $this->isGameEnd = true;
                        $this->showFeedback = true;
                        $this->feedbackMessage = __('play.end_story_congratulations');
                    } elseif ($this->currentChapter->next_chapter_id) {
                        $this->showFeedback = false;
                        $this->loadChapter($this->currentChapter->next_chapter_id);
                    } else {
                        $this->isGameEnd = true;
                        $this->showFeedback = true;
                        $this->feedbackMessage = __('play.unexpected_end_correct_answer');
                    }
                }
            } elseif ($this->question->type === 3) {
                $this->validate(['selectedOptionId' => 'required|exists:options,id'], [
                    'selectedOptionId.required' => __('play.validation_option_required'),
                ]);

                $option = Option::find($this->selectedOptionId);
                $isQuizMode = $this->question->options->contains(fn ($opt) => (bool)$opt->is_correct);
                
                if ($isQuizMode) {
                    $this->isCorrect = (bool)$option->is_correct;
                    $this->feedbackMessage = $this->isCorrect ? __('play.correct') : ($this->question->wrong_feedback ?? __('play.try_again'));

                    if ($this->isCorrect) {
                        if ($this->currentChapter->is_end) {
                            $this->isGameEnd = true;
                            $this->showFeedback = true;
                            $this->feedbackMessage = __('play.end_story_congratulations');
                        } elseif ($option->next_chapter_id) {
                            $this->showFeedback = false;
                            $this->loadChapter($option->next_chapter_id);
                        } else {
                            $this->isGameEnd = true;
                            $this->showFeedback = true;
                            $this->feedbackMessage = __('play.unexpected_end_correct_answer');
                        }
                    }
                } else {
                    $this->isCorrect = true;
                    $this->feedbackMessage = '';
                    $this->showFeedback = false;

                    if ($this->currentChapter->is_end) {
                        $this->isGameEnd = true;
                        $this->showFeedback = true;
                        $this->feedbackMessage = __('play.end_story_congratulations');
                    } elseif ($option->next_chapter_id) {
                        $this->loadChapter($option->next_chapter_id);
                    } else {
                        $this->isGameEnd = true;
                        $this->showFeedback = true;
                        $this->feedbackMessage = __('play.unexpected_end_choice');
                    }
                }
            }

        } catch (ValidationException $e) {
            $this->feedbackMessage = $e->validator->errors()->first();
            $this->showFeedback = true;
            $this->isCorrect = false;
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
            return redirect()->route('stories.show', $this->story->id);
        }

        if ($this->currentChapter && $this->currentChapter->next_chapter_id) {
            $this->loadChapter($this->currentChapter->next_chapter_id);
        } elseif ($this->currentChapter && $this->currentChapter->is_end) {
            $this->isGameEnd = true;
            $this->feedbackMessage = __('play.end_story_congratulations');
            $this->showFeedback = true;
        } else {
            $this->isGameEnd = true;
            $this->feedbackMessage = __('play.unexpected_end_general');
            $this->showFeedback = true;
        }
    }

    /**
     * Awards XP to the user if the story is completed for the first time
     * and checks for level-ups.
     *
     * @return void
     */
    public function awardXpAndCheckLevelUp()
    {
        $user = Auth::user(); 

        $numQuestions = 0;

        foreach ($this->story->chapters as $chapter) {
            if ($chapter->question) { 
                $numQuestions++;
            }
        }

        $xpGained = $numQuestions * self::XP_PER_QUESTION;


        DB::transaction(function () use ($user, $xpGained) {
            $initialUserXp = $user->xp;
            $initialUserLevel = $user->level;

            $user->xp += $xpGained;

            $newUserLevel = floor($user->xp / self::XP_PER_LEVEL_THRESHOLD) + 1;

            $user->level = $newUserLevel;
            $user->save();

            $this->userXp = $user->xp;
            $this->userLevel = $user->level;


        });   
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
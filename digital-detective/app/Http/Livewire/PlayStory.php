<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Chapter;
use App\Models\Option;

class PlayStory extends Component
{
    public $currentChapterId;
    public $chapterContent;
    public $question;
    public $questionType;
    public $answerInput = '';
    public $storyEnded = false;
    public $showNextButton = false;

    public function mount($firstChapterId)
    {
        $this->loadChapter($firstChapterId);
    }

    public function loadChapter($id)
    {
        $chapter = Chapter::with('questions.options')->findOrFail($id);

        $this->currentChapterId = $id;
        $this->chapterContent = $chapter->content;

        $this->question = $chapter->questions->first();

        if ($this->question) {
            $this->questionType = $this->question->question_type;
            $this->showNextButton = false;
            $this->storyEnded = false;
        } else {
            $this->questionType = null;
            if ($chapter->next_chapter_id) {
                $this->showNextButton = true;
                $this->storyEnded = false;
            } else {
                $this->showNextButton = false;
                $this->storyEnded = true;
            }
        }

        $this->answerInput = '';
    }

    public function submitAnswer($optionId = null)
    {
        $chapter = Chapter::find($this->currentChapterId);

        if (!$this->question) {
            return;
        }

        if ($this->questionType == 1) {
            $selectedOption = $this->question->options->where('id', $optionId)->first();

            if (!$selectedOption) {
                return;
            }

            if ($selectedOption->is_wrong && $selectedOption->wrong_chapter_id) {
                $this->loadChapter($selectedOption->wrong_chapter_id);
            } elseif (!$selectedOption->is_wrong && $selectedOption->next_chapter_id) {
                $this->loadChapter($selectedOption->next_chapter_id);
            } elseif ($chapter->next_chapter_id) {
                $this->loadChapter($chapter->next_chapter_id);
            } else {
                $this->question = null;
                $this->showNextButton = false;
                $this->storyEnded = true;
            }
        } else {
            $userAnswer = trim(strtolower($this->answerInput));
            $correctOption = $this->question->options->where('is_wrong', false)->first();

            if (!$correctOption) {
                $this->storyEnded = true;
                $this->question = null;
                $this->showNextButton = false;
                return;
            }

            $correctAnswer = trim(strtolower($correctOption->text));

            if ($userAnswer === $correctAnswer) {
                if ($chapter->next_chapter_id) {
                    $this->loadChapter($chapter->next_chapter_id);
                } else {
                    $this->storyEnded = true;
                    $this->showNextButton = false;
                    $this->question = null;
                }
            } else {
                if ($correctOption->wrong_chapter_id) {
                    $this->loadChapter($correctOption->wrong_chapter_id);
                } else {
                    $this->storyEnded = true;
                    $this->showNextButton = false;
                    $this->question = null;
                }
            }
        }
    }

    public function nextChapter()
    {
        $chapter = Chapter::find($this->currentChapterId);
        if ($chapter && $chapter->next_chapter_id) {
            $this->loadChapter($chapter->next_chapter_id);
        } else {
            $this->storyEnded = true;
            $this->showNextButton = false;
            $this->question = null;
        }
    }

    public function render()
    {
        return view('livewire.play-story');
    }
}

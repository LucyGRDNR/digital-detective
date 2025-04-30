<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Option;

class GameController extends Controller
{
    public function play($storyId)
    {
        $firstChapter = Chapter::where('story_id', $storyId)->orderBy('id')->first();

        return view('play', [
            'story_id' => $storyId,
            'first_chapter_id' => $firstChapter->id,
        ]);
    }

    public function loadChapter($chapterId)
    {
        $chapter = Chapter::find($chapterId);

        $question = Question::where('chapter_id', $chapterId)->first();
        $questionData = null;

        if ($question) {
            $options = Option::where('question_id', $question->id)->get();
            $questionData = [
                'question_type' => $question->question_type,
                'question_text' => $question->content,
                'options' => $options,
            ];
        }

        return response()->json([
            'id' => $chapter->id,
            'content' => $chapter->content,
            'next_chapter_id' => $chapter->next_chapter_id,
            'question' => $questionData,
        ]);
    }

    public function submitAnswer(Request $request, $chapterId)
{
    $chapter = Chapter::find($chapterId);
    $answer = $request->input('answer');

    $question = Question::where('chapter_id', $chapterId)->first();
    if (!$question) {
        return response()->json(['next_chapter_id' => $chapter->next_chapter_id]);
    }

    if ($question->question_type == 1) {
        $selectedOption = Option::find($answer);
    
        if ($selectedOption) {
            if ($selectedOption->is_wrong) {
                return response()->json([
                    'next_chapter_id' => $selectedOption->wrong_chapter_id,
                ]);
            } else {
                return response()->json([
                    'next_chapter_id' => $selectedOption->next_chapter_id,
                ]);
            }
        } else {
            return response()->json(['error' => 'Selected option not found.'], 404);
        }
    } else {
        $correctOption = Option::where('question_id', $question->id)->where('is_wrong', false)->first();
    
        if ($correctOption) {
            if (strtolower(trim($answer)) === strtolower(trim($correctOption->text))) {
                return response()->json([
                    'next_chapter_id' => $chapter->next_chapter_id,
                ]);
            } else {
                return response()->json([
                    'next_chapter_id' => $correctOption->wrong_chapter_id,
                ]);
            }
        } else {
            return response()->json(['error' => 'Correct option not found for the question.'], 404);
        }
    }

    return response()->json(['error' => 'Invalid answer type'], 400);
}

}

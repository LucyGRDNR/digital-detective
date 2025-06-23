<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StoryController extends Controller
{
    /**
     * Display a listing of the story resources.
     * This method serves as the main index page to list all available stories.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $stories = Story::all();
        return view('welcome', compact('stories'));
    }

    /**
     * Show the form for creating a new story.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created story and its associated chapters, questions, and options in storage.
     * @param  \Illuminate\Http\Request  $request The incoming HTTP request.
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'place' => 'nullable|string|max:80',
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'place_GPS' => 'nullable|string|max:255',
            'distance' => 'required|integer|min:0',
            'time' => 'required|integer|min:0',
            'chapters_data' => 'required|string', 
            'chapter_images' => 'nullable|array', 
            'chapter_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ]);

        $chaptersData = json_decode($validatedData['chapters_data'], true);

        foreach ($chaptersData as $index => $chapter) {
            $chapterValidator = Validator::make($chapter, [
                'id' => 'required|string', 
                'title' => 'required|string|max:255',
                'content' => 'nullable|string',
                'is_end' => 'required|boolean',
                'next_chapter' => 'nullable|string', 
                'question' => 'nullable|array',
            ]);

            if ($chapterValidator->fails()) {
                return response()->json(['message' => "Kapitola " . ($index + 1) . ": " . $chapterValidator->errors()->first()], 400);
            }

            if (isset($chapter['question']) && is_array($chapter['question']) && !$chapter['is_end']) {
                $question = $chapter['question'];
                $questionValidator = Validator::make($question, [
                    'text' => 'required|string',
                    'type' => 'required|integer|in:1,2,3', 
                    'wrong_feedback' => 'nullable|string', 
                    'hint' => 'nullable|string',
                    'input_answer' => 'nullable|string', 
                    'options' => 'nullable|array', 
                ]);

                if ($questionValidator->fails()) {
                    return response()->json(['message' => "Kapitola " . ($index + 1) . ": " . $questionValidator->errors()->first()], 400);
                }

                if ($question['type'] == 1 || $question['type'] == 2) { 
                    if (empty($question['input_answer'])) {
                        return response()->json(['message' => "Kapitola " . ($index + 1) . ": U otázky s textovým nebo číselným vstupem je vyžadována správná odpověď."], 400);
                    }
                    if ($question['type'] == 2) {
                        if (!is_numeric($question['input_answer'])) {
                            return response()->json(['message' => "Kapitola " . ($index + 1) . ": Správná odpověď musí být číslo u typu 'Číselný vstup'."], 400);
                        }
                    }
                    if (empty($question['wrong_feedback'])) {
                        return response()->json(['message' => "Kapitola " . ($index + 1) . ": Je třeba zadat zpětnou vazbu pro špatnou odpověď."], 400);
                    }
                } elseif ($question['type'] == 3) { 
                    if (empty($question['options'])) {
                        return response()->json(['message' => "Kapitola " . ($index + 1) . ": Otázka s výběrem odpovědi musí mít alespoň jednu možnost."], 400);
                    }

                    $hasCorrectOption = false; 
                    foreach ($question['options'] as $optIndex => $option) {
                        $optionValidator = Validator::make($option, [
                            'text' => 'required|string',
                            'is_correct' => 'required|boolean', 
                            'next_chapter_id' => 'required|string', 
                        ]);

                        if ($optionValidator->fails()) {
                            return response()->json(['message' => "Kapitola " . ($index + 1) . ", Možnost " . ($optIndex + 1) . ": " . $optionValidator->errors()->first()], 400);
                        }

                        if ($option['is_correct']) {
                            $hasCorrectOption = true;
                        }
                    }

                    if ($hasCorrectOption && empty($question['wrong_feedback'])) {
                        return response()->json(['message' => "Kapitola " . ($index + 1) . ": U otázky s výběrem odpovědi je vyžadována zpětná vazba pro špatnou odpověď."], 400);
                    }
                }
            }
        }

        return DB::transaction(function () use ($request, $chaptersData, $validatedData) {
            $imagePath = null;
            if ($request->hasFile('image_file')) {
                $imagePath = $request->file('image_file')->store('images', 'public');
            }

            $story = Story::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'] ?? null,
                'image_path' => $imagePath,
                'place' => $validatedData['place'] ?? null,
                'place_GPS' => $validatedData['place_GPS'] ?? null,
                'distance' => $validatedData['distance'],
                'time' => $validatedData['time'],
            ]);

            $tempIdToDbIdMap = [];
            foreach ($chaptersData as $chapterTempData) {
                $tempIdToDbIdMap[$chapterTempData['id']] = null; 
            }

            $chapterImages = $request->file('chapter_images'); 

            foreach ($chaptersData as $chapterTempData) {
                $chapterImagePath = null;
                $chapterTempId = $chapterTempData['id'];

                if ($chapterImages && array_key_exists($chapterTempId, $chapterImages)) {
                    $chapterImageFile = $chapterImages[$chapterTempId];
                    if ($chapterImageFile instanceof \Illuminate\Http\UploadedFile && $chapterImageFile->isValid()) {
                        try {
                            $chapterImagePath = $chapterImageFile->store('chapter_images', 'public');
                        } catch (\Exception $e) {
                            Log::error('Error storing chapter image for ID ' . $chapterTempId . ':', ['error' => $e->getMessage()]);
                        }
                    }
                }

                $chapter = new Chapter([
                    'title' => $chapterTempData['title'],
                    'content' => $chapterTempData['content'] ?? null,
                    'image_path' => $chapterImagePath,
                    'is_end' => $chapterTempData['is_end'],
                    'next_chapter_id' => null, 
                ]);
                $story->chapters()->save($chapter);
                $tempIdToDbIdMap[$chapterTempData['id']] = $chapter->id;
            }

            foreach ($chaptersData as $chapterTempData) {
                $chapter = Chapter::find($tempIdToDbIdMap[$chapterTempData['id']]);

                if (!$chapterTempData['is_end'] && !(isset($chapterTempData['question']) && $chapterTempData['question']['type'] == 3)) {
                    if (isset($chapterTempData['next_chapter']) && isset($tempIdToDbIdMap[$chapterTempData['next_chapter']])) {
                        $chapter->next_chapter_id = $tempIdToDbIdMap[$chapterTempData['next_chapter']];
                    } else {
                        Log::warning("Next chapter ID not found in map for chapter {$chapterTempData['id']}. This might indicate a frontend validation bypass or data issue.");
                        $chapter->next_chapter_id = null;
                    }
                } else {
                    $chapter->next_chapter_id = null;
                }
                $chapter->save();

                if (isset($chapterTempData['question']) && $chapterTempData['question'] && !$chapterTempData['is_end']) {
                    $qData = $chapterTempData['question'];
                    $question = new Question([
                        'text' => $qData['text'],
                        'type' => $qData['type'],
                        'wrong_feedback' => $qData['wrong_feedback'] ?? null,
                        'hint' => $qData['hint'] ?? null,
                        'input_answer' => ($qData['type'] == 1 || $qData['type'] == 2) ? ($qData['input_answer'] ?? null) : null,
                    ]);
                    $chapter->question()->save($question);

                    if ($qData['type'] == 3 && !empty($qData['options'])) {
                        foreach ($qData['options'] as $optData) {
                            $option = new Option([
                                'text' => $optData['text'],
                                'is_correct' => $optData['is_correct'],
                                'next_chapter_id' => isset($optData['next_chapter_id']) && isset($tempIdToDbIdMap[$optData['next_chapter_id']])
                                    ? $tempIdToDbIdMap[$optData['next_chapter_id']]
                                    : null,
                            ]);
                            $question->options()->save($option);
                        }
                    }
                }
            }
            return redirect('/')->with('success', 'Příběh byl úspěšně uložen!');
        });
    }

    /**
     * Display the specified story.
     * @param  \App\Models\Story  $story The story model instance to display.
     * @return \Illuminate\View\View
     */
    public function show(Story $story)
    {
        $story->load('chapters.question.options');
        return view('show', ['story' => $story]);
    }

    /**
     * Show the form for editing the specified story.
     * @param  \App\Models\Story  $story The story model instance to edit.
     * @return \Illuminate\View\View
     */
    public function edit(Story $story)
    {
        $story->load([
            'chapters' => function ($query) {
                $query->orderBy('created_at', 'asc');
            },
            'chapters.question',
            'chapters.question.options' => function ($query) {
                $query->orderBy('id', 'asc');
            }
        ]);

        return view('edit', compact('story'));
    }

    /**
     * Update the specified story and its associated chapters, questions, and options in storage.
     * @param  \Illuminate\Http\Request  $request The incoming HTTP request.
     * @param  \App\Models\Story  $story The story model instance to update.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Story $story)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'place' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'place_GPS' => 'nullable|string|max:255',
            'distance' => 'required|integer|min:0',
            'time' => 'required|integer|min:0',
            'chapters_data' => 'required|string',
            'chapter_images_to_delete' => 'nullable|string',
            'chapter_images' => 'nullable|array',
            'chapter_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'delete_story_image' => 'nullable|boolean',
        ]);

        $chaptersData = json_decode($validatedData['chapters_data'], true);
        $deletedChapterImagePaths = json_decode($validatedData['chapter_images_to_delete'] ?? '[]', true);

        foreach ($chaptersData as $index => $chapter) {
            $chapterValidator = Validator::make($chapter, [
                'id' => 'required|string', 
                'title' => 'required|string|max:255',
                'content' => 'nullable|string',
                'is_end' => 'required|boolean',
                'next_chapter_id' => 'nullable|string', 
                'question' => 'nullable|array',
            ]);
            if ($chapterValidator->fails()) {
                return response()->json(['message' => "Kapitola " . ($index + 1) . ": " . $chapterValidator->errors()->first()], 400);
            }

            if (isset($chapter['question']) && is_array($chapter['question']) && !$chapter['is_end']) {
                $question = $chapter['question'];
                $questionValidator = Validator::make($question, [
                    'text' => 'required|string',
                    'type' => 'required|integer|in:1,2,3',
                    'wrong_feedback' => 'nullable|string',
                    'hint' => 'nullable|string',
                    'input_answer' => 'nullable|string',
                    'options' => 'nullable|array',
                ]);
                if ($questionValidator->fails()) {
                    return response()->json(['message' => "Kapitola " . ($index + 1) . ": " . $questionValidator->errors()->first()], 400);
                }

                if ($question['type'] == 1 || $question['type'] == 2) {
                    if (empty($question['input_answer'])) {
                        return response()->json(['message' => "Kapitola " . ($index + 1) . ": Správná odpověď je povinná pro otázku typu vstup."], 400);
                    }
                    if ($question['type'] == 2) {
                        if (!is_numeric($question['input_answer'])) {
                            return response()->json(['message' => "Kapitola " . ($index + 1) . ": Správná odpověď musí být číslo pro typ 'Číselný vstup'."], 400);
                        }
                    }
                    if (empty($question['wrong_feedback'])) {
                        return response()->json(['message' => "Kapitola " . ($index + 1) . ": Zpětná vazba pro nesprávnou odpověď je povinná."], 400);
                    }
                } elseif ($question['type'] == 3) {
                    if (empty($question['options'])) {
                        return response()->json(['message' => "Kapitola " . ($index + 1) . ": Otázka s výběrem odpovědi musí mít alespoň jednu možnost."], 400);
                    }
                    $hasCorrectOption = false;
                    foreach ($question['options'] as $optIndex => $option) {
                        $optionValidator = Validator::make($option, [
                            'text' => 'required|string',
                            'is_correct' => 'required|boolean',
                            'next_chapter_id' => 'required|string', 
                        ]);
                        if ($optionValidator->fails()) {
                            return response()->json(['message' => "Kapitola " . ($index + 1) . ", Možnost " . ($optIndex + 1) . ": " . $optionValidator->errors()->first()], 400);
                        }

                        if ($option['is_correct']) {
                            $hasCorrectOption = true;
                        }
                    }
                    if ($hasCorrectOption && empty($question['wrong_feedback'])) {
                        return response()->json(['message' => "Kapitola " . ($index + 1) . ": U otázky s výběrem odpovědi je vyžadována zpětná vazba pro špatnou odpověď."], 400);
                    }
                }
            }
        }

        return DB::transaction(function () use ($request, $story, $chaptersData, $validatedData, $deletedChapterImagePaths) {
            $storyUpdateData = [
                'name' => $validatedData['name'],
                'description' => $validatedData['description'] ?? null,
                'place' => $validatedData['place'] ?? null,
                'place_GPS' => $validatedData['place_GPS'] ?? null,
                'distance' => $validatedData['distance'],
                'time' => $validatedData['time'],
            ];

            if (isset($validatedData['delete_story_image']) && $validatedData['delete_story_image']) {
                if ($story->image_path && Storage::disk('public')->exists($story->image_path)) {
                    Storage::disk('public')->delete($story->image_path);
                }
                $storyUpdateData['image_path'] = null; 
            }

            if ($request->hasFile('image_file')) {
                if ($story->image_path && Storage::disk('public')->exists($story->image_path)) {
                    Storage::disk('public')->delete($story->image_path);
                }
                $storyUpdateData['image_path'] = $request->file('image_file')->store('images', 'public');
            }

            $story->update($storyUpdateData);

            $existingChapterDbIds = $story->chapters->pluck('id')->toArray(); 
            $chaptersToKeepDbIds = []; 
            $tempIdToDbIdMap = []; 

            foreach ($chaptersData as $chapterTempData) {
                if (is_numeric($chapterTempData['id'])) { 
                    $tempIdToDbIdMap[$chapterTempData['id']] = (int)$chapterTempData['id'];
                    $chaptersToKeepDbIds[] = (int)$chapterTempData['id'];
                } else { 
                    $tempIdToDbIdMap[$chapterTempData['id']] = null;
                }
            }

            $chaptersToDelete = array_diff($existingChapterDbIds, $chaptersToKeepDbIds);
            if (!empty($chaptersToDelete)) {
                foreach ($chaptersToDelete as $chapterIdToDelete) {
                    $chapterToDelete = Chapter::find($chapterIdToDelete);
                    if ($chapterToDelete) {
                        if ($chapterToDelete->image_path && Storage::disk('public')->exists($chapterToDelete->image_path)) {
                            Storage::disk('public')->delete($chapterToDelete->image_path);
                        }
                        $chapterToDelete->question()->delete();
                        $chapterToDelete->delete(); 
                    }
                }
            }

            if (!empty($deletedChapterImagePaths)) {
                foreach ($deletedChapterImagePaths as $imagePathToDelete) {
                    if (Storage::disk('public')->exists($imagePathToDelete)) {
                        Storage::disk('public')->delete($imagePathToDelete);
                    }
                }
            }

            $chapterImages = $request->file('chapter_images');

            foreach ($chaptersData as $chapterTempData) {
                $chapterModel = null;
                $isNewChapter = !is_numeric($chapterTempData['id']); 

                if (!$isNewChapter) {
                    $chapterModel = Chapter::find((int)$chapterTempData['id']);
                }

                $chapterData = [
                    'title' => $chapterTempData['title'],
                    'content' => $chapterTempData['content'] ?? null,
                    'is_end' => $chapterTempData['is_end'],
                    'next_chapter_id' => null,
                ];

                $chapterTempId = $chapterTempData['id'];
                if ($chapterImages && array_key_exists($chapterTempId, $chapterImages)) {
                    $newChapterImageFile = $chapterImages[$chapterTempId];
                    if ($newChapterImageFile instanceof \Illuminate\Http\UploadedFile && $newChapterImageFile->isValid()) {
                        if ($chapterModel && $chapterModel->image_path && Storage::disk('public')->exists($chapterModel->image_path)) {
                            Storage::disk('public')->delete($chapterModel->image_path);
                        }
                        $chapterData['image_path'] = $newChapterImageFile->store('chapter_images', 'public');
                    }
                } else if ($chapterModel && $chapterModel->image_path && (!isset($validatedData['chapter_images_to_delete']) || !in_array($chapterModel->image_path, $deletedChapterImagePaths))) {
                    $chapterData['image_path'] = $chapterModel->image_path;
                } else {
                    $chapterData['image_path'] = null;
                }

                if ($isNewChapter) {
                    $chapterModel = $story->chapters()->create($chapterData);
                    $tempIdToDbIdMap[$chapterTempData['id']] = $chapterModel->id;
                } else {
                    $chapterModel->update($chapterData);
                }

                if (isset($chapterTempData['question']) && $chapterTempData['question'] && !$chapterTempData['is_end']) {
                    $qData = $chapterTempData['question'];
                    $question = $chapterModel->question;

                    if (!$question) {
                        $question = new Question();
                        $question->chapter_id = $chapterModel->id;
                    }

                    $question->text = $qData['text'];
                    $question->type = $qData['type'];
                    $question->wrong_feedback = $qData['wrong_feedback'] ?? null;
                    $question->hint = $qData['hint'] ?? null;
                    $question->input_answer = ($qData['type'] == 1 || $qData['type'] == 2) ? ($qData['input_answer'] ?? null) : null;
                    $question->save();

                    if ($qData['type'] == 3 && !empty($qData['options'])) {
                        $existingOptionIds = $question->options->pluck('id')->toArray(); 
                        $optionsToKeepIds = []; 

                        foreach ($qData['options'] as $optData) {
                            $optionModel = null;
                            if (isset($optData['id']) && is_numeric($optData['id'])) {
                                $optionModel = Option::find((int)$optData['id']);
                                $optionsToKeepIds[] = (int)$optData['id'];
                            }

                            $optionData = [
                                'text' => $optData['text'],
                                'is_correct' => $optData['is_correct'],
                                'next_chapter_id' => isset($optData['next_chapter_id']) && isset($tempIdToDbIdMap[$optData['next_chapter_id']])
                                    ? $tempIdToDbIdMap[$optData['next_chapter_id']]
                                    : null,
                            ];

                            if ($optionModel) {
                                $optionModel->update($optionData);
                            } else {
                                $option = new Option($optionData);
                                $question->options()->save($option);
                            }
                        }

                        $optionsToDelete = array_diff($existingOptionIds, $optionsToKeepIds);
                        if (!empty($optionsToDelete)) {
                            Option::whereIn('id', $optionsToDelete)->delete();
                        }
                    } else {
                        $question->options()->delete();
                    }
                } else {
                    if ($chapterModel->question) {
                        $chapterModel->question->options()->delete();
                        $chapterModel->question()->delete();
                    }
                }
            }

            foreach ($chaptersData as $chapterTempData) {
                $chapterModel = Chapter::find($tempIdToDbIdMap[$chapterTempData['id']]);
                if ($chapterModel) {
                    if (!$chapterTempData['is_end'] && !(isset($chapterTempData['question']) && $chapterTempData['question']['type'] == 3)) {
                        if (isset($chapterTempData['next_chapter_id']) && isset($tempIdToDbIdMap[$chapterTempData['next_chapter_id']])) {
                            $chapterModel->next_chapter_id = $tempIdToDbIdMap[$chapterTempData['next_chapter_id']];
                        } else {
                            $chapterModel->next_chapter_id = null;
                            Log::warning("Final next chapter ID not found for chapter {$chapterTempData['id']}");
                        }
                    } else {
                        $chapterModel->next_chapter_id = null;
                    }
                    $chapterModel->save();
                }
            }
            return redirect()->route('stories.show', $story->id)->with('success', 'Příběh byl úspěšně uložen!');
        });
    }
}
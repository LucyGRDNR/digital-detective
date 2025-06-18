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
        // Validate main story data and overall structure
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'place' => 'nullable|string|max:80',
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Main story image
            'place_GPS' => 'nullable|string|max:255',
            'distance' => 'required|integer|min:0',
            'time' => 'required|integer|min:0',
            'chapters_data' => 'required|string', 
            'chapter_images' => 'nullable|array', 
            'chapter_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ]);

        // Decode the JSON string of chapters data into a PHP array
        $chaptersData = json_decode($validatedData['chapters_data'], true);

        foreach ($chaptersData as $index => $chapter) {
            // Validate individual chapter data.
            $chapterValidator = Validator::make($chapter, [
                'id' => 'required|string', // Temporary frontend ID
                'title' => 'required|string|max:255',
                'content' => 'nullable|string',
                'is_end' => 'required|boolean',
                'next_chapter' => 'nullable|string', // Temporary frontend ID of the next chapter
                'question' => 'nullable|array',
            ]);

            // If chapter validation fails, return an error response
            if ($chapterValidator->fails()) {
                return response()->json(['message' => "Kapitola " . ($index + 1) . ": " . $chapterValidator->errors()->first()], 400);
            }

            // Validate question and options if the chapter has a question and is not an end chapter
            if (isset($chapter['question']) && is_array($chapter['question']) && !$chapter['is_end']) {
                $question = $chapter['question'];
                $questionValidator = Validator::make($question, [
                    'text' => 'required|string',
                    'type' => 'required|integer|in:1,2,3', // 1=Text Input, 2=Number Input, 3=Multiple Choice Question
                    'wrong_feedback' => 'nullable|string', // Feedback for incorrect answers (can be null for branching MCQ)
                    'hint' => 'nullable|string',
                    'input_answer' => 'nullable|string', // Correct answer for text/number input
                    'options' => 'nullable|array', // Options for MCQ
                ]);

                // If question validation fails, return an error response
                if ($questionValidator->fails()) {
                    return response()->json(['message' => "Kapitola " . ($index + 1) . ": " . $questionValidator->errors()->first()], 400);
                }

                // Specific validation rules based on question type
                if ($question['type'] == 1 || $question['type'] == 2) { // Text or Number Input Questions
                    if (empty($question['input_answer'])) {
                        return response()->json(['message' => "Kapitola " . ($index + 1) . ": U otázky s textovým nebo číselným vstupem je vyžadována správná odpověď."], 400);
                    }
                    // Numeric validation for Type 2 (Number Input)
                    if ($question['type'] == 2) {
                        if (!is_numeric($question['input_answer'])) {
                            return response()->json(['message' => "Kapitola " . ($index + 1) . ": Správná odpověď musí být číslo u typu 'Číselný vstup'."], 400);
                        }
                    }
                    // Wrong feedback is always required for input-based questions
                    if (empty($question['wrong_feedback'])) {
                        return response()->json(['message' => "Kapitola " . ($index + 1) . ": Je třeba zadat zpětnou vazbu pro špatnou odpověď."], 400);
                    }
                } elseif ($question['type'] == 3) { // Multiple Choice Question
                    // Ensure options are provided for MCQ type
                    if (empty($question['options'])) {
                        return response()->json(['message' => "Kapitola " . ($index + 1) . ": Otázka s výběrem odpovědi musí mít alespoň jednu možnost."], 400);
                    }

                    $hasCorrectOption = false; // Flag to check if at least one correct option exists
                    // Validate each option for MCQ type
                    foreach ($question['options'] as $optIndex => $option) {
                        $optionValidator = Validator::make($option, [
                            'text' => 'required|string',
                            'is_correct' => 'required|boolean', 
                            'next_chapter_id' => 'required|string', // Temporary frontend ID of the next chapter for this option
                        ]);

                        // If option validation fails, return an error response
                        if ($optionValidator->fails()) {
                            return response()->json(['message' => "Kapitola " . ($index + 1) . ", Možnost " . ($optIndex + 1) . ": " . $optionValidator->errors()->first()], 400);
                        }

                        // Set flag if a correct option is found
                        if ($option['is_correct']) {
                            $hasCorrectOption = true;
                        }
                    }

                    // If a correct option exists for an MCQ, wrong feedback is required
                    if ($hasCorrectOption && empty($question['wrong_feedback'])) {
                        return response()->json(['message' => "Kapitola " . ($index + 1) . ": U otázky s výběrem odpovědi je vyžadována zpětná vazba pro špatnou odpověď."], 400);
                    }
                }
            }
        }

        // Database Transaction for Atomic Operations
        return DB::transaction(function () use ($request, $chaptersData, $validatedData) {
            // Store the main story image
            $imagePath = null;
            if ($request->hasFile('image_file')) {
                $imagePath = $request->file('image_file')->store('images', 'public');
            }

            // Create the main Story record
            $story = Story::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'] ?? null,
                'image_path' => $imagePath,
                'place' => $validatedData['place'] ?? null,
                'place_GPS' => $validatedData['place_GPS'] ?? null,
                'distance' => $validatedData['distance'],
                'time' => $validatedData['time'],
            ]);

            // Initialize a map to store temporary frontend chapter IDs to their new database IDs
            $tempIdToDbIdMap = [];
            foreach ($chaptersData as $chapterTempData) {
                $tempIdToDbIdMap[$chapterTempData['id']] = null; // Initialize with null, will be filled upon creation
            }

            $chapterImages = $request->file('chapter_images'); // Get all uploaded chapter images

            // Create Chapters and Populate the ID Map
            foreach ($chaptersData as $chapterTempData) {
                $chapterImagePath = null;
                $chapterTempId = $chapterTempData['id'];

                // Handle chapter image upload
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

                // Create a new Chapter instance, next_chapter_id is initially null.
                $chapter = new Chapter([
                    'title' => $chapterTempData['title'],
                    'content' => $chapterTempData['content'] ?? null,
                    'image_path' => $chapterImagePath,
                    'is_end' => $chapterTempData['is_end'],
                    'next_chapter_id' => null, // Will be updated soon after all chapters exist
                ]);
                // Associate and save the chapter to the story
                $story->chapters()->save($chapter);
                // Store the newly created chapter's database ID, mapped to its temporary frontend ID
                $tempIdToDbIdMap[$chapterTempData['id']] = $chapter->id;
            }

            // Update next_chapter_id links and Create Questions/Options
            foreach ($chaptersData as $chapterTempData) {
                // Find the chapter using its newly assigned database ID
                $chapter = Chapter::find($tempIdToDbIdMap[$chapterTempData['id']]);

                // Update the next_chapter_id for the current chapter
                // For MCQs, next chapter logic is handled by options
                if (!$chapterTempData['is_end'] && !(isset($chapterTempData['question']) && $chapterTempData['question']['type'] == 3)) {
                    if (isset($chapterTempData['next_chapter']) && isset($tempIdToDbIdMap[$chapterTempData['next_chapter']])) {
                        $chapter->next_chapter_id = $tempIdToDbIdMap[$chapterTempData['next_chapter']];
                    } else {
                        // Log a warning if a next chapter is expected but not found in the map
                        Log::warning("Next chapter ID not found in map for chapter {$chapterTempData['id']}. This might indicate a frontend validation bypass or data issue.");
                        $chapter->next_chapter_id = null;
                    }
                } else {
                    // If it's an end chapter or an MCQ, its direct next_chapter_id is null
                    $chapter->next_chapter_id = null;
                }
                $chapter->save();

                // Create Question and Options if the chapter has a question and is not an end chapter
                if (isset($chapterTempData['question']) && $chapterTempData['question'] && !$chapterTempData['is_end']) {
                    $qData = $chapterTempData['question'];
                    $question = new Question([
                        'text' => $qData['text'],
                        'type' => $qData['type'],
                        'wrong_feedback' => $qData['wrong_feedback'] ?? null,
                        'hint' => $qData['hint'] ?? null,
                        // Store input_answer only if question type is 1 (Text) or 2 (Number).
                        'input_answer' => ($qData['type'] == 1 || $qData['type'] == 2) ? ($qData['input_answer'] ?? null) : null,
                    ]);
                    $chapter->question()->save($question);

                    // If it's a Multiple Choice Question (Type 3) and has options
                    if ($qData['type'] == 3 && !empty($qData['options'])) {
                        foreach ($qData['options'] as $optData) {
                            $option = new Option([
                                'text' => $optData['text'],
                                'is_correct' => $optData['is_correct'],
                                // Map the option's next_chapter_id using the temp ID to DB ID map
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
        // Validate incoming data for the story and its nested components
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'place' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Main story image
            'place_GPS' => 'nullable|string|max:255',
            'distance' => 'required|integer|min:0',
            'time' => 'required|integer|min:0',
            'chapters_data' => 'required|string',
            'chapter_images_to_delete' => 'nullable|string',
            'chapter_images' => 'nullable|array',
            'chapter_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'delete_story_image' => 'nullable|boolean',
        ]);

        // Decode JSON data for chapters and images to be deleted
        $chaptersData = json_decode($validatedData['chapters_data'], true);
        $deletedChapterImagePaths = json_decode($validatedData['chapter_images_to_delete'] ?? '[]', true);

        // Validation for Chapters, Questions, and Options
        foreach ($chaptersData as $index => $chapter) {
            $chapterValidator = Validator::make($chapter, [
                'id' => 'required|string', // Can be temporary frontend ID or existing DB ID
                'title' => 'required|string|max:255',
                'content' => 'nullable|string',
                'is_end' => 'required|boolean',
                'next_chapter_id' => 'nullable|string', // Temporary or existing DB ID for next chapter
                'question' => 'nullable|array',
            ]);
            // If chapter validation fails, return an error response
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
                 // If question validation fails, return an error response
                if ($questionValidator->fails()) {
                    return response()->json(['message' => "Kapitola " . ($index + 1) . ": " . $questionValidator->errors()->first()], 400);
                }

                // Specific validation for question types
                if ($question['type'] == 1 || $question['type'] == 2) {
                    if (empty($question['input_answer'])) {
                        return response()->json(['message' => "Kapitola " . ($index + 1) . ": Správná odpověď je povinná pro otázku typu vstup."], 400);
                    }
                    if ($question['type'] == 2) {
                        if (!is_numeric($question['input_answer'])) {
                            return response()->json(['message' => "Kapitola " . ($index + 1) . ": Správná odpověď musí být číslo pro typ 'Číselný vstup'."], 400);
                        }
                    }
                    // Feedback is always required for text/number input types
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
                            'next_chapter_id' => 'required|string', // Frontend ID (temp or DB)
                        ]);
                        // If option validation fails, return an error response
                        if ($optionValidator->fails()) {
                            return response()->json(['message' => "Kapitola " . ($index + 1) . ", Možnost " . ($optIndex + 1) . ": " . $optionValidator->errors()->first()], 400);
                        }

                        if ($option['is_correct']) {
                            $hasCorrectOption = true;
                        }
                    }
                    // If a correct option exists for an MCQ, wrong feedback is required
                    if ($hasCorrectOption && empty($question['wrong_feedback'])) {
                        return response()->json(['message' => "Kapitola " . ($index + 1) . ": U otázky s výběrem odpovědi je vyžadována zpětná vazba pro špatnou odpověď."], 400);
                    }
                }
            }
        }

        // Database Transaction for Atomic Operations
        return DB::transaction(function () use ($request, $story, $chaptersData, $validatedData, $deletedChapterImagePaths) {
            //Update Main Story Details and Image
            $storyUpdateData = [
                'name' => $validatedData['name'],
                'description' => $validatedData['description'] ?? null,
                'place' => $validatedData['place'] ?? null,
                'place_GPS' => $validatedData['place_GPS'] ?? null,
                'distance' => $validatedData['distance'],
                'time' => $validatedData['time'],
            ];

            // Handle deletion of the existing main story image
            if (isset($validatedData['delete_story_image']) && $validatedData['delete_story_image']) {
                if ($story->image_path && Storage::disk('public')->exists($story->image_path)) {
                    Storage::disk('public')->delete($story->image_path);
                }
                $storyUpdateData['image_path'] = null; // Set path to null in DB
            }

            // Handle upload of a new main story image
            if ($request->hasFile('image_file')) {
                // Delete old image if a new one is uploaded
                if ($story->image_path && Storage::disk('public')->exists($story->image_path)) {
                    Storage::disk('public')->delete($story->image_path);
                }
                $storyUpdateData['image_path'] = $request->file('image_file')->store('images', 'public');
            }

            $story->update($storyUpdateData);

            //Process Chapters (Identify deletions, prepare for updates/creations)
            $existingChapterDbIds = $story->chapters->pluck('id')->toArray(); // Get IDs of chapters currently in DB
            $chaptersToKeepDbIds = []; // To store DB IDs of chapters that should remain
            $tempIdToDbIdMap = []; // Map frontend temp IDs to actual DB IDs (for new and existing chapters)

            // Populate initial map, existing chapters use their DB ID, new ones get null
            foreach ($chaptersData as $chapterTempData) {
                if (is_numeric($chapterTempData['id'])) { // Existing chapter
                    $tempIdToDbIdMap[$chapterTempData['id']] = (int)$chapterTempData['id'];
                    $chaptersToKeepDbIds[] = (int)$chapterTempData['id'];
                } else { // New chapter
                    $tempIdToDbIdMap[$chapterTempData['id']] = null;
                }
            }

            // Identify and delete chapters that were removed from the frontend
            $chaptersToDelete = array_diff($existingChapterDbIds, $chaptersToKeepDbIds);
            if (!empty($chaptersToDelete)) {
                foreach ($chaptersToDelete as $chapterIdToDelete) {
                    $chapterToDelete = Chapter::find($chapterIdToDelete);
                    if ($chapterToDelete) {
                        // Delete associated chapter image
                        if ($chapterToDelete->image_path && Storage::disk('public')->exists($chapterToDelete->image_path)) {
                            Storage::disk('public')->delete($chapterToDelete->image_path);
                        }
                        // Delete question and its options (if they exist) via cascade or direct deletion
                        $chapterToDelete->question()->delete();
                        $chapterToDelete->delete(); // Delete the chapter itself
                    }
                }
            }

            // Delete specific chapter images requested for deletion
            if (!empty($deletedChapterImagePaths)) {
                foreach ($deletedChapterImagePaths as $imagePathToDelete) {
                    if (Storage::disk('public')->exists($imagePathToDelete)) {
                        Storage::disk('public')->delete($imagePathToDelete);
                    }
                }
            }

            $chapterImages = $request->file('chapter_images');

            // Create new chapters or update existing ones
            foreach ($chaptersData as $chapterTempData) {
                $chapterModel = null;
                $isNewChapter = !is_numeric($chapterTempData['id']); // Determine if it's a new chapter

                // If it's an existing chapter, retrieve its model instance
                if (!$isNewChapter) {
                    $chapterModel = Chapter::find((int)$chapterTempData['id']);
                }

                // Prepare common chapter data for creation or update
                $chapterData = [
                    'title' => $chapterTempData['title'],
                    'content' => $chapterTempData['content'] ?? null,
                    'is_end' => $chapterTempData['is_end'],
                    'next_chapter_id' => null,
                ];

                $chapterTempId = $chapterTempData['id'];
                // Handle new or updated chapter images
                if ($chapterImages && array_key_exists($chapterTempId, $chapterImages)) {
                    $newChapterImageFile = $chapterImages[$chapterTempId];
                    if ($newChapterImageFile instanceof \Illuminate\Http\UploadedFile && $newChapterImageFile->isValid()) {
                        // Delete old image if a new one is uploaded for an existing chapter
                        if ($chapterModel && $chapterModel->image_path && Storage::disk('public')->exists($chapterModel->image_path)) {
                            Storage::disk('public')->delete($chapterModel->image_path);
                        }
                        $chapterData['image_path'] = $newChapterImageFile->store('chapter_images', 'public');
                    }
                } else if ($chapterModel && $chapterModel->image_path && (!isset($validatedData['chapter_images_to_delete']) || !in_array($chapterModel->image_path, $deletedChapterImagePaths))) {
                    // If no new image, and old image not explicitly marked for deletion, keep existing path
                    $chapterData['image_path'] = $chapterModel->image_path;
                } else {
                    // Otherwise, set image path to null
                    $chapterData['image_path'] = null;
                }

                // Create or update the chapter record
                if ($isNewChapter) {
                    $chapterModel = $story->chapters()->create($chapterData);
                    // Update the map for newly created chapters
                    $tempIdToDbIdMap[$chapterTempData['id']] = $chapterModel->id;
                } else {
                    $chapterModel->update($chapterData);
                }

                // Process Question and Options for the current chapter
                if (isset($chapterTempData['question']) && $chapterTempData['question'] && !$chapterTempData['is_end']) {
                    $qData = $chapterTempData['question'];
                    $question = $chapterModel->question;

                    // If no question exists, create a new one
                    if (!$question) {
                        $question = new Question();
                        $question->chapter_id = $chapterModel->id;
                    }

                    // Update question properties
                    $question->text = $qData['text'];
                    $question->type = $qData['type'];
                    $question->wrong_feedback = $qData['wrong_feedback'] ?? null;
                    $question->hint = $qData['hint'] ?? null;
                    $question->input_answer = ($qData['type'] == 1 || $qData['type'] == 2) ? ($qData['input_answer'] ?? null) : null;
                    $question->save();

                    // Process Options if it's a Multiple Choice Question (Type 3)
                    if ($qData['type'] == 3 && !empty($qData['options'])) {
                        $existingOptionIds = $question->options->pluck('id')->toArray(); // Current options in DB
                        $optionsToKeepIds = []; // IDs of options that should remain

                        foreach ($qData['options'] as $optData) {
                            $optionModel = null;
                            // Check if option exists by ID
                            if (isset($optData['id']) && is_numeric($optData['id'])) {
                                $optionModel = Option::find((int)$optData['id']);
                                $optionsToKeepIds[] = (int)$optData['id'];
                            }

                            // Prepare option data
                            $optionData = [
                                'text' => $optData['text'],
                                'is_correct' => $optData['is_correct'],
                                // Map next_chapter_id for the option using the temp ID to DB ID map
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

                        // Delete options that were removed from the frontend
                        $optionsToDelete = array_diff($existingOptionIds, $optionsToKeepIds);
                        if (!empty($optionsToDelete)) {
                            Option::whereIn('id', $optionsToDelete)->delete();
                        }
                    } else {
                        // If question type is not 3 or options are empty, delete all existing options for this question
                        $question->options()->delete();
                    }
                } else {
                    // If chapter no longer has a question (or is end chapter), delete its question and option
                    if ($chapterModel->question) {
                        $chapterModel->question->options()->delete();
                        $chapterModel->question()->delete();
                    }
                }
            }

            //Update `next_chapter_id` for all chapters
            foreach ($chaptersData as $chapterTempData) {
                $chapterModel = Chapter::find($tempIdToDbIdMap[$chapterTempData['id']]);
                if ($chapterModel) {
                    // If not an end chapter AND not a type 3 question, set direct next_chapter_id
                    if (!$chapterTempData['is_end'] && !(isset($chapterTempData['question']) && $chapterTempData['question']['type'] == 3)) {
                        if (isset($chapterTempData['next_chapter_id']) && isset($tempIdToDbIdMap[$chapterTempData['next_chapter_id']])) {
                            $chapterModel->next_chapter_id = $tempIdToDbIdMap[$chapterTempData['next_chapter_id']];
                        } else {
                            $chapterModel->next_chapter_id = null;
                            Log::warning("Final next chapter ID not found for chapter {$chapterTempData['id']}");
                        }
                    } else {
                        // For end chapters or chapters with MCQ, next_chapter_id is null
                        $chapterModel->next_chapter_id = null;
                    }
                    $chapterModel->save();
                }
            }
            return redirect()->route('stories.show', $story->id)->with('success', 'Příběh byl úspěšně aktualizován!');
        });
    }

    /**
     * Remove the specified story resource from storage.
     * @param  \App\Models\Story  $story The story model instance to delete.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Story $story)
    {
        DB::transaction(function () use ($story) {
            //Delete the main story image from storage
            if ($story->image_path && Storage::disk('public')->exists($story->image_path)) {
                Storage::disk('public')->delete($story->image_path);
            }

            // Delete all chapters, chapter images, questions, and options associated with the story
            foreach ($story->chapters as $chapter) {
                // Delete chapter-specific image
                if ($chapter->image_path && Storage::disk('public')->exists($chapter->image_path)) {
                    Storage::disk('public')->delete($chapter->image_path);
                }
                
                $chapter->question()->delete(); // Delete the question associated with the chapter
                $chapter->delete(); // Delete the chapter itself.
            }

            $story->delete();
        });

        return redirect()->route('home')->with('success', 'Příběh byl úspěšně smazán!');
    }
}
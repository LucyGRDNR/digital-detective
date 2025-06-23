document.addEventListener('DOMContentLoaded', function() {
            let chapterCounter = 0;
            let tempChapterIdCounter = 0;

            const chaptersContainer = document.getElementById('chapters-container');
            const chapterTemplate = document.getElementById('chapter-template');
            const optionTemplate = document.getElementById('option-template');
            const form = document.getElementById('story-edit-form');
            const chaptersDataInput = document.getElementById('chapters-data-input');
            const chapterImagesToDeleteInput = document.getElementById('chapter-images-to-delete-input');
            const deletedQuestionIdsInput = document.getElementById('deleted-question-ids-input');
            const deletedOptionIdsInput = document.getElementById('deleted-option-ids-input');


            let deletedChapterImagePaths = [];
            let deletedQuestionIds = [];
            let deletedOptionIds = [];

            const initialStoryData = window.initialStoryData;
            const lang = window.Laravel.lang;

               const updateImagePreview = (inputElement, imgElement, previewContainer) => {
                if (inputElement.files && inputElement.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imgElement.src = e.target.result;
                        if (previewContainer) {
                            previewContainer.classList.remove('hidden');
                        }
                    };
                    reader.readAsDataURL(inputElement.files[0]);
                } else if (imgElement && previewContainer) {
                    if (imgElement.dataset.originalSrc) {
                        imgElement.src = imgElement.dataset.originalSrc;
                        previewContainer.classList.remove('hidden');
                    } else {
                        previewContainer.classList.add('hidden');
                        imgElement.src = '';
                    }
                }
            };

            const storyImageUploadInput = document.getElementById('image-upload');
            const storyImageTag = document.getElementById('story-image-tag');
            const currentStoryImagePreviewDiv = document.getElementById('current-story-image-preview');

            if (storyImageUploadInput && storyImageTag) {
                storyImageUploadInput.addEventListener('change', function() {
                    updateImagePreview(this, storyImageTag, currentStoryImagePreviewDiv);
                });
            }

           /**
             * Updates the 'required' attribute for the 'Next Chapter' dropdown based on
             * whether the current chapter is an end chapter or has an MCQ question.
             * 'Next Chapter' is required ONLY if it's NOT an end chapter AND NOT a MCQ
             * @param {HTMLElement} block The chapter block element.
             */
            function updateNextChapterRequired(block) {
                const nextChapterSelect = block.querySelector('.next-chapter');
                const isEndChapter = block.querySelector('.is-end-chapter').checked;
                const hasQuestion = block.querySelector('.has-question').value === '1';
                const questionType = block.querySelector('.question-type').value;

                nextChapterSelect.required = !isEndChapter && !(hasQuestion && questionType === '3');
            }

           /**
             * Generates HTML <option> elements for chapter dropdowns.
             * Includes a default "Select a chapter" option and disables the current chapter
             * from being selected as its own 'next chapter'.
             * @param {string} [currentChapterId=''] The ID of the current chapter block, if applicable.
             * @returns {string} HTML string of <option> elements.
             */
            function getChapterOptionsHTML(currentChapterId = '') {
                let options = `<option value="">${lang.select_chapter}</option>`;
                document.querySelectorAll('.chapter-block').forEach(block => {
                    const id = block.dataset.chapterId;
                    const title = block.querySelector('.chapter-title').value.trim() || `${lang.chapter} ${block.querySelector('.chapter-number').textContent}`;
                    const disabled = id === currentChapterId ? 'disabled' : '';
                    options += `<option value="${id}" ${disabled}>${title}</option>`;
                });
                return options;
            }

            /**
             * Updates the options in all 'Next Chapter' dropdowns and MCQ option dropdowns across all chapters.
             * This function is called whenever a chapter is added, deleted, or a chapter title changes
             * to ensure dropdowns reflect the latest chapter list and titles.
             */
            function updateChapterOptions() {
                document.querySelectorAll('.chapter-block').forEach(block => {
                    const currentId = block.dataset.chapterId;

                    const nextSelect = block.querySelector('.next-chapter');
                    const prevValue = nextSelect.value;
                    nextSelect.innerHTML = getChapterOptionsHTML(currentId);
                    if ([...nextSelect.options].some(opt => opt.value === prevValue)) {
                        nextSelect.value = prevValue;
                    } else {
                        nextSelect.value = '';
                    }

                    block.querySelectorAll('.option-next').forEach(select => {
                        const optionParentDiv = select.closest('.option-item');

                        const prev = select.value;
                        const isCorrectCheckbox = optionParentDiv.querySelector('.is-correct');
                        const hasQuestionSelect = block.querySelector('.has-question');
                        const questionTypeSelect = block.querySelector('.question-type');

                        if (hasQuestionSelect.value === '1' && questionTypeSelect.value === '3') {
                             select.innerHTML = getChapterOptionsHTML(currentId);

                            const anyCorrect = [...block.querySelectorAll('.option-item')].some(opt => opt.querySelector('.is-correct').checked);

                            if (isCorrectCheckbox.checked) {
                                select.disabled = false;
                                select.required = true;
                                if ([...select.options].some(opt => opt.value === prev)) {
                                    select.value = prev;
                                } else {
                                    select.value = '';
                                }
                            } else {
                                if (anyCorrect) {
                                    select.value = currentId;
                                    select.disabled = true;
                                    select.required = false;
                                } else {
                                    select.disabled = false;
                                    select.required = false;
                                    if ([...select.options].some(opt => opt.value === prev)) {
                                        select.value = prev;
                                    } else {
                                        select.value = '';
                                    }
                                }
                            }
                        } else {
                            select.innerHTML = getChapterOptionsHTML(currentId);
                            select.disabled = false;
                            select.required = false;
                            if ([...select.options].some(opt => opt.value === prev)) {
                                select.value = prev;
                            } else {
                                select.value = '';
                            }
                        }
                    });

                    updateNextChapterRequired(block);
                });
            }

           /**
             * Toggles the visibility of the 'Next Chapter' section based on 'Is end chapter' checkbox
             * and 'Has Question'/'Question Type' selections.
             * @param {HTMLElement} block The chapter block element.
             */
            function toggleNextChapterVisibility(block) {
                const isEndChapter = block.querySelector('.is-end-chapter').checked;
                const hasQuestion = block.querySelector('.has-question').value === '1';
                const questionType = block.querySelector('.question-type').value;
                const nextChapterSection = block.querySelector('.next-chapter-section');
                const nextChapterSelect = block.querySelector('.next-chapter');

                const shouldHide = isEndChapter || (hasQuestion && questionType === '3');

                nextChapterSection.classList.toggle('hidden', shouldHide);

                if (shouldHide) {
                    nextChapterSelect.value = '';
                }
            }

            /**
             * Toggles the visibility of the 'Add Question?' section and the full 'Question Details' section.
             * If a chapter is marked as an end chapter, questions are not allowed.
             * @param {HTMLElement} block The chapter block element.
             */
            function toggleQuestionSectionVisibility(block) {
                const isEndChapter = block.querySelector('.is-end-chapter').checked;
                const hasQuestionSection = block.querySelector('.has-question-section');
                const hasQuestionSelect = block.querySelector('.has-question');
                const questionSection = block.querySelector('.question-section');

                if (isEndChapter) {
                    hasQuestionSection.classList.add('hidden');
                    hasQuestionSelect.value = '0';
                    questionSection.classList.add('hidden');
                    resetQuestionFields(block);
                } else {
                    hasQuestionSection.classList.remove('hidden');
                    hasQuestionSelect.dispatchEvent(new Event('change'));
                }
            }

            /**
             * Resets and clears all input fields within the question section of a given chapter block.
             * @param {HTMLElement} block The chapter block element.
             */
            function resetQuestionFields(block) {
                block.querySelector('.question-text').value = '';
                block.querySelector('.question-hint').value = '';
                block.querySelector('.question-type').value = '';
                block.querySelector('.input-answer').value = '';
                block.querySelector('.mcq-answer-section .options').innerHTML = '';
                block.querySelector('.wrong-feedback').value = '';
                toggleAnswerTypeVisibility(block);
            }

            /**
             * Toggles the visibility of the 'Input Answer' and 'MCQ Answer' sections
             * based on the selected 'Question Type' (1=Text, 2=Number, 3=MCQ) and whether a question is enabled.
             * Manages required attributes for answer fields and ensures at least two options for MCQ.
             * Also collects IDs for deletion.
             * @param {HTMLElement} block The chapter block element.
             */
            function toggleAnswerTypeVisibility(block) {
                const questionType = block.querySelector('.question-type').value;
                const hasQuestion = block.querySelector('.has-question').value === '1';
                const inputAnswerSection = block.querySelector('.input-answer-section');
                const mcqAnswerSection = block.querySelector('.mcq-answer-section');
                const inputAnswerField = inputAnswerSection.querySelector('.input-answer');

                const showInputSections = (hasQuestion && (questionType === '1' || questionType === '2'));
                inputAnswerSection.classList.toggle('hidden', !showInputSections);

                const showMcqSection = (hasQuestion && questionType === '3');
                mcqAnswerSection.classList.toggle('hidden', !showMcqSection);

                if (inputAnswerField) {
                    inputAnswerField.required = showInputSections;
                    if (showInputSections) {
                        if (questionType === '1') {
                            inputAnswerField.type = 'text';
                        } else if (questionType === '2') {
                            inputAnswerField.type = 'number';

                        }
                    } else {
                        inputAnswerField.value = '';
                    }
                }

                if (!showMcqSection) {
                    block.querySelectorAll('.mcq-answer-section .option-db-id').forEach(input => {
                        if (input.value && !deletedOptionIds.includes(input.value)) {
                            deletedOptionIds.push(input.value);
                        }
                    });
                    mcqAnswerSection.querySelector('.options').innerHTML = '';
                } else if (showMcqSection) {
                    const optionsCount = mcqAnswerSection.querySelector('.options').children.length;
                    for (let i = optionsCount; i < 2; i++) {
                        addOption(mcqAnswerSection.querySelector('.options'));
                    }
                }
                updateDeleteOptionButtons(block);
                updateAddOptionVisibility(block);
            }

            /**
             * Updates the 'required' attribute for the 'Wrong Answer Feedback' field.
             * It's required only if a question is enabled, unless it's an MCQ with no correct options.
             * It also controls the visibility of the feedback field and its label by hiding their common parent.
             * @param {HTMLElement} block The chapter block element.
             */
            function updateWrongFeedbackRequired(block) {
                const hasQuestion = block.querySelector('.has-question').value === '1';
                const questionType = block.querySelector('.question-type').value;
                const wrongFeedbackInput = block.querySelector('.wrong-feedback');
                const feedbackContainer = wrongFeedbackInput ? wrongFeedbackInput.closest('div') : null;

                if (hasQuestion) {
                    if (questionType === '3') {
                        const options = block.querySelectorAll('.options > .option-item');
                        let hasCorrectOption = false;
                        options.forEach(optionDiv => {
                            if (optionDiv.querySelector('.is-correct').checked) {
                                hasCorrectOption = true;
                            }
                        });

                        wrongFeedbackInput.required = hasCorrectOption;
                        feedbackContainer.classList.toggle('hidden', !hasCorrectOption);

                        if (!hasCorrectOption) {
                            wrongFeedbackInput.value = '';
                        }
                    } else {
                        wrongFeedbackInput.required = true;
                        feedbackContainer.classList.remove('hidden');
                    }
                } else {
                    wrongFeedbackInput.required = false;
                    wrongFeedbackInput.value = '';
                    feedbackContainer.classList.add('hidden');
                }
            }

           /**
             * Toggles the visibility of the 'Add Option' button for MCQ questions.
             * It's hidden if there are already 5 options.
             * @param {HTMLElement} block The chapter block element.
             */
            function updateAddOptionVisibility(block) {
                const addBtn = block.querySelector('.add-option');
                const count = block.querySelectorAll('.options > .option-item').length;
                addBtn.style.display = count >= 5 ? 'none' : 'inline-block';
            }

            /**
             * Enables/disables 'Delete Option' buttons for MCQ options.
             * They are disabled if there are 2 or fewer options.
             * @param {HTMLElement} block The chapter block element.
             */
            function updateDeleteOptionButtons(block) {
                const optionsContainer = block.querySelector('.options');
                const deleteButtons = optionsContainer.querySelectorAll('.delete-option');
                if (deleteButtons.length <= 2) {
                    deleteButtons.forEach(btn => btn.disabled = true);
                } else {
                    deleteButtons.forEach(btn => btn.disabled = false);
                }
            }

            /**
             * Enables/disables 'Delete Chapter' buttons.
             * They are disabled if there is only one chapter.
             */
            function updateDeleteChapterButtons() {
                const deleteButtons = document.querySelectorAll('.delete-chapter');
                if (deleteButtons.length <= 1) {
                    deleteButtons.forEach(btn => btn.disabled = true);
                } else {
                    deleteButtons.forEach(btn => btn.disabled = false);
                }
            }

            /**
             * Updates the display text next to the chapter number, showing its next chapter.
             * @param {HTMLElement} block The chapter block element.
             */
            function updateChapterNextDisplay(block) {
                const displaySpan = block.querySelector('.chapter-next-display');
                const isEndChapter = block.querySelector('.is-end-chapter').checked;
                const hasQuestion = block.querySelector('.has-question').value === '1';
                const questionType = block.querySelector('.question-type').value;
                const nextChapterSelect = block.querySelector('.next-chapter');
                const currentChapterId = block.dataset.chapterId;

                let displayText = '';

                if (isEndChapter) {
                    displayText = lang.ends_story;
                } else if (hasQuestion && questionType === '3') {
                    displayText = lang.branches_with_question;
                } else if (nextChapterSelect.value) {
                    const selectedOption = nextChapterSelect.options[nextChapterSelect.selectedIndex];
                    const nextChapterTitle = selectedOption ? selectedOption.textContent.trim() : 'Unselected';

                    if (nextChapterTitle && !nextChapterTitle.startsWith(lang.chapter + ' ')) {
                        displayText = `${lang.follows_chapter} ${nextChapterTitle}`;
                    } else if (selectedOption && selectedOption.value) {
                        const nextBlock = document.querySelector(`.chapter-block[data-chapter-id="${selectedOption.value}"]`);
                        if (nextBlock) {
                            const nextNumber = nextBlock.querySelector('.chapter-number').textContent;
                            displayText = `${lang.follows_chapter} ${lang.chapter} ${nextNumber}`;
                        }
                    } else {
                        displayText = `${lang.follows_chapter} ${lang.unselected_chapter}`;
                    }
                } else {
                    displayText = `${lang.follows_chapter} ${lang.unselected_chapter}`;
                }
                displaySpan.textContent = displayText;
            }

            /**
             * Function to add a new chapter block to the container.
             * Clones the chapter template, assigns a unique ID, sets up event listeners,
             * and updates other chapter dropdowns to include the new chapter.
             * Populates inputs with existing data from DB.
             */
            window.addChapter = function(chapterData = null) {
                const clone = chapterTemplate.content.cloneNode(true);
                const block = clone.querySelector('.chapter-block');

                let chapterId;
                if (chapterData && chapterData.id) {
                    chapterId = chapterData.id;
                    block.querySelector('.chapter-db-id').value = chapterId;
                } else {
                    chapterId = `chapter-${Date.now()}-${Math.random().toString(36).substr(2, 5)}`;
                }
                block.dataset.chapterId = chapterId;
                chapterCounter++;
                block.querySelector('.chapter-number').textContent = chapterCounter;
                block.querySelector('.chapter-temp-id').value = chapterId;

                const chapterImageInput = block.querySelector('.chapter-image-upload');
                if (chapterImageInput) {
                    chapterImageInput.name = `chapter_images[${chapterId}]`;
                    chapterImageInput.id = `chapter-image-${chapterId}`;
                }

                if (chapterData) {
                    block.querySelector('.chapter-title').value = chapterData.title || '';
                    block.querySelector('.chapter-content').value = chapterData.content || '';
                    block.querySelector('.is-end-chapter').checked = chapterData.is_end;

                    const currentChapterImageContainer = block.querySelector('.current-chapter-image-container');
                    const currentChapterImage = currentChapterImageContainer.querySelector('img');
                    const deleteChapterImageButton = currentChapterImageContainer.querySelector(
                        '.delete-chapter-image-button');
                    if (chapterData.image_path) {
                        currentChapterImage.src = baseImageUrl  + chapterData.image_path;
                        currentChapterImageContainer.classList.remove('hidden');
                        deleteChapterImageButton.classList.remove('hidden');
                        chapterImageInput.required = false;
                    } else {
                        currentChapterImageContainer.classList.add('hidden');
                        currentChapterImage.src = '';
                        deleteChapterImageButton.classList.add('hidden');
                        chapterImageInput.required = false;
                    }


                    if (chapterData.question) {
                        block.querySelector('.has-question').value = '1';
                        block.querySelector('.question-db-id').value = chapterData.question.id || '';
                        block.querySelector('.question-text').value = chapterData.question.text || '';
                        block.querySelector('.question-hint').value = chapterData.question.hint || '';
                        block.querySelector('.question-type').value = chapterData.question.type;
                        block.querySelector('.wrong-feedback').value = chapterData.question.wrong_feedback || '';

                        if (chapterData.question.type == 1 || chapterData.question.type == 2) {
                            block.querySelector('.input-answer').value = chapterData.question.input_answer || '';
                        } else if (chapterData.question.type == 3) {
                            if (chapterData.question.options && chapterData.question.options.length > 0) {
                                block.querySelector('.mcq-answer-section .options').innerHTML = '';
                                chapterData.question.options.forEach(option => {
                                    addOption(block.querySelector('.mcq-answer-section .options'), option);
                                });
                            }
                        }
                    } else {
                        block.querySelector('.has-question').value = '0';
                    }

                    if (!chapterData.is_end && !(chapterData.question && chapterData.question.type == 3) && chapterData
                        .next_chapter_id) {
                        block.querySelector('.next-chapter').dataset.initialValue = chapterData
                            .next_chapter_id;
                    }
                }

                setupChapterEventListeners(block);

                chaptersContainer.appendChild(block);

                updateChapterOptions();
                updateDeleteChapterButtons();
                updateChapterNextDisplay(block);

                block.querySelector('.is-end-chapter').dispatchEvent(new Event('change'));
                block.querySelector('.has-question').dispatchEvent(new Event('change'));

                const allChapters = document.querySelectorAll('.chapter-block');
                if (allChapters.length > 1) {
                    const prevBlock = allChapters[allChapters.length - 2];
                    const prevIsEndChapter = prevBlock.querySelector('.is-end-chapter').checked;
                    const prevHasQuestion = prevBlock.querySelector('.has-question').value === '1';
                    const prevQuestionType = prevBlock.querySelector('.question-type').value;

                    if (!prevIsEndChapter && !(prevHasQuestion && prevQuestionType === '3')) {
                        const prevNextSelect = prevBlock.querySelector('.next-chapter');
                        if (!prevNextSelect.value) {
                            prevNextSelect.value = chapterId;
                            updateChapterNextDisplay(prevBlock);
                        }
                    }
                }

                updateDeleteChapterButtons();
            };

             /**
             * Sets up all event listeners for a given chapter block.
             * Also collects IDs for deletion.
             * @param {HTMLElement} block The chapter block element to set up listeners for.
             */
            function setupChapterEventListeners(block) {
                const titleInput = block.querySelector('.chapter-title');
                titleInput.addEventListener('input', function() {
                    updateChapterOptions();
                    document.querySelectorAll('.chapter-block').forEach(b => updateChapterNextDisplay(b));
                });

                const isEndChapterCheckbox = block.querySelector('.is-end-chapter');
                isEndChapterCheckbox.addEventListener('change', function() {
                    toggleNextChapterVisibility(block);
                    toggleQuestionSectionVisibility(block);
                    updateNextChapterRequired(block);
                    updateChapterNextDisplay(block);
                    updateWrongFeedbackRequired(block);
                });

                const hasQuestionSelect = block.querySelector('.has-question');
                hasQuestionSelect.addEventListener('change', function() {
                    const hasQuestion = this.value === '1';
                    block.querySelector('.question-section').classList.toggle('hidden', !hasQuestion);
                    block.querySelector('.question-type').dispatchEvent(new Event('change'));
                    updateWrongFeedbackRequired(block);
                    toggleNextChapterVisibility(block);
                    updateNextChapterRequired(block);
                    updateChapterNextDisplay(block);

                    if (!hasQuestion) {
                        const questionDbId = block.querySelector('.question-db-id').value;
                        if (questionDbId && !deletedQuestionIds.includes(questionDbId)) {
                            deletedQuestionIds.push(questionDbId);
                        }
                    }
                });

                const questionTypeSelect = block.querySelector('.question-type');
                questionTypeSelect.addEventListener('change', function() {
                    toggleAnswerTypeVisibility(block);
                    toggleNextChapterVisibility(block);
                    updateNextChapterRequired(block);
                    updateChapterNextDisplay(block);
                    updateWrongFeedbackRequired(block);
                });

                const addOptionBtn = block.querySelector('.add-option');
                addOptionBtn.addEventListener('click', function() {
                    const optionsContainer = block.querySelector('.options');
                    if (optionsContainer.children.length < 5) {
                        addOption(block);
                        updateChapterOptions();
                        updateWrongFeedbackRequired(block);
                    }
                    updateAddOptionVisibility(block);
                    updateDeleteOptionButtons(block);
                    updateChapterNextDisplay(block);
                });

                block.querySelector('.options').addEventListener('click', function(e) {
                    if (e.target.classList.contains('delete-option')) {
                        const optionItem = e.target.closest('.option-item');
                        if (optionItem) {
                            optionItem.remove();
                            updateChapterOptions();
                            updateAddOptionVisibility(block);
                            updateDeleteOptionButtons(block);
                            updateNextChapterRequired(block);
                            updateChapterNextDisplay(block);
                            updateWrongFeedbackRequired(block);
                        }
                    }
                });


                block.querySelector('.options').addEventListener('change', function(e) {
                    if (e.target.classList.contains('is-correct')) {
                        updateChapterOptions();
                        updateNextChapterRequired(block);
                        updateChapterNextDisplay(block);
                        updateWrongFeedbackRequired(block);
                    } else if (e.target.classList.contains('option-next')) {
                        updateChapterNextDisplay(block);
                    }
                });

                const nextChapterSelect = block.querySelector('.next-chapter');
                nextChapterSelect.addEventListener('change', function() {
                    updateChapterNextDisplay(block);
                });

                const chapterImageUploadInput = block.querySelector('.chapter-image-upload');
                const currentChapterImageContainer = block.querySelector('.current-chapter-image-container');
                const previewImage = currentChapterImageContainer.querySelector('img');
                const deleteChapterImageButton = currentChapterImageContainer.querySelector(
                    '.delete-chapter-image-button');

                chapterImageUploadInput.addEventListener('change', function() {
                    const oldImagePath = previewImage.src.includes('storage/') ? previewImage.src.split('/storage/').pop() : null;

                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImage.src = e.target.result;
                            currentChapterImageContainer.classList.remove('hidden');
                            deleteChapterImageButton.classList.remove('hidden');
                        };
                        reader.readAsDataURL(this.files[0]);

                        if (oldImagePath && !deletedChapterImagePaths.includes(oldImagePath)) {
                            deletedChapterImagePaths.push(oldImagePath);
                        }
                    } else {
                        if (!oldImagePath) {
                            previewImage.src = '';
                            currentChapterImageContainer.classList.add('hidden');
                            deleteChapterImageButton.classList.add('hidden');
                        }
                    }
                });

                if (deleteChapterImageButton) {
                    deleteChapterImageButton.addEventListener('click', function() {
                       const oldImagePath = previewImage.src.includes('storage/') ? previewImage.src.split('/storage/').pop() : null;

                        if (oldImagePath && !deletedChapterImagePaths.includes(oldImagePath)) {
                            deletedChapterImagePaths.push(oldImagePath);
                        }
                        previewImage.src = '';
                        currentChapterImageContainer.classList.add('hidden');
                        chapterImageUploadInput.value = '';
                        deleteChapterImageButton.classList.add('hidden');
                    });
                }

                const deleteChapterBtn = block.querySelector('.delete-chapter');
                deleteChapterBtn.addEventListener('click', function() {
                    if (confirm(lang.confirm_delete_chapter)) {
                        const chapterToDeleteId = block.querySelector('.chapter-db-id').value;
                        if (chapterToDeleteId && !deletedQuestionIds.includes(chapterToDeleteId)) {
                            deletedQuestionIds.push(chapterToDeleteId);
                        }
                        const questionDbId = block.querySelector('.question-db-id').value;
                        if (questionDbId && !deletedQuestionIds.includes(questionDbId)) {
                            deletedQuestionIds.push(questionDbId);
                        }
                        block.querySelectorAll('.option-db-id').forEach(optionInput => {
                            if (optionInput.value && !deletedOptionIds.includes(optionInput.value)) {
                                deletedOptionIds.push(optionInput.value);
                            }
                        });

                        block.remove();
                        chapterCounter = document.querySelectorAll('.chapter-block').length;
                        document.querySelectorAll('.chapter-block').forEach((chap, index) => {
                            chap.querySelector('.chapter-number').textContent = index + 1;
                            updateChapterNextDisplay(chap);
                        });
                        updateChapterOptions();
                        updateDeleteChapterButtons();
                    }
                });

                toggleNextChapterVisibility(block);
                toggleQuestionSectionVisibility(block);
                updateNextChapterRequired(block);
                updateWrongFeedbackRequired(block);
                toggleAnswerTypeVisibility(block);
                updateChapterNextDisplay(block);
            }

            /**
             * Adds a new MCQ option block to the specified container.
             * This function is used both for creating new options and for loading existing options
             * when editing a story. It populates the option's fields, sets up event listeners
             * for correctness and deletion, and updates the visibility of related UI elements.
             *
             * @param {HTMLElement} optionsContainer The DOM element that will contain the new option (typically a div with class 'options').
             * @param {Object|null} optionData Optional. An object containing data for an existing option to pre-populate the fields.
             */
            function addOption(optionsContainer, optionData = null) {
                const clone = optionTemplate.content.cloneNode(true);
                const newOptionBlock = clone.querySelector('.option-item');

                const currentChapterBlock = optionsContainer.closest('.chapter-block');
                const currentChapterId = currentChapterBlock.dataset.chapterId;

                if (optionData) {
                    newOptionBlock.querySelector('.option-db-id').value = optionData.id || '';
                    newOptionBlock.querySelector('.option-text').value = optionData.text || '';
                    newOptionBlock.querySelector('.is-correct').checked = optionData.is_correct || false;
                    newOptionBlock.querySelector('.option-next').dataset.initialValue = optionData
                        .next_chapter_id || '';
                }


                const optionNextSelect = newOptionBlock.querySelector('.option-next');
                optionNextSelect.innerHTML = getChapterOptionsHTML(currentChapterId);

                optionsContainer.appendChild(newOptionBlock);

                const isCorrectCheckbox = newOptionBlock.querySelector('.is-correct');
                isCorrectCheckbox.addEventListener('change', function() {
                    updateChapterOptions();
                });

                const deleteOptionBtn = newOptionBlock.querySelector('.delete-option');
                deleteOptionBtn.addEventListener('click', function() {
                    if (confirm(lang.confirm_delete_option)) {
                        const optionDbId = newOptionBlock.querySelector('.option-db-id').value;
                        if (optionDbId && !deletedOptionIds.includes(optionDbId)) {
                            deletedOptionIds.push(optionDbId);
                        }
                        newOptionBlock.remove();
                        updateChapterOptions();
                        updateAddOptionVisibility(currentChapterBlock);
                        updateDeleteOptionButtons(currentChapterBlock);
                    }
                });

                updateAddOptionVisibility(currentChapterBlock);
                updateDeleteOptionButtons(currentChapterBlock);
            }

            /**
             * Collects all data (new and old) from created chapters and their questions/options into a
             * structured JS array of objects. This array will be stringified and sent to the server.
             * @returns {Array<Object>} An array containing structured data for each chapter.
             */
            function collectChapters() {
                const chapters = [];
                document.querySelectorAll('.chapter-block').forEach(block => {
                    const hasQuestion = block.querySelector('.has-question').value === '1';
                    const questionType = block.querySelector('.question-type').value;

                    let questionData = null;
                    if (hasQuestion) {
                        questionData = {
                            id: block.querySelector('.question-db-id').value || null,
                            text: block.querySelector('.question-text').value.trim(),
                            hint: block.querySelector('.question-hint').value.trim(),
                            type: questionType,
                            wrong_feedback: block.querySelector('.wrong-feedback').value.trim(),
                        };

                        if (questionType === '1' || questionType === '2') {
                            questionData.input_answer = block.querySelector('.input-answer').value.trim();
                        } else if (questionType === '3') {
                            questionData.input_answer = null;
                            questionData.options = [];
                            block.querySelectorAll('.options > .option-item').forEach(optionDiv => {
                                questionData.options.push({
                                    id: optionDiv.querySelector('.option-db-id').value || null,
                                    text: optionDiv.querySelector('.option-text').value.trim(),
                                    is_correct: optionDiv.querySelector('.is-correct').checked,
                                    next_chapter_id: optionDiv.querySelector('.option-next').value,
                                });
                            });
                        }
                    }

                    let currentChapterImagePath = null;
                    const currentChapterImageContainer = block.querySelector('.current-chapter-image-container');
                    const currentChapterImage = currentChapterImageContainer.querySelector('img');
                    const chapterImageUploadInput = block.querySelector('.chapter-image-upload');
                    const chapterDbId = block.querySelector('.chapter-db-id').value;

                    if (chapterImageUploadInput.files.length > 0) {
                        currentChapterImagePath = null;
                    } else if (chapterDbId && initialStoryData.chapters.find(c => c.id == chapterDbId && c.image_path) &&
                        currentChapterImageContainer && !currentChapterImageContainer.classList.contains('hidden')) {
                        const pathFromSrc = currentChapterImage.src.includes('storage/') ? currentChapterImage.src.split('/storage/').pop() : null;
                        if (pathFromSrc && !deletedChapterImagePaths.includes('chapter_images/' + pathFromSrc)) {
                            currentChapterImagePath = 'chapter_images/' + pathFromSrc;
                        } else {
                            currentChapterImagePath = null;
                        }
                    } else {
                        currentChapterImagePath = null;
                    }

                    chapters.push({
                        id: block.dataset.chapterId,
                        title: block.querySelector('.chapter-title').value.trim(),
                        content: block.querySelector('.chapter-content').value.trim(),
                        image_path: currentChapterImagePath,
                        is_end: block.querySelector('.is-end-chapter').checked,
                        next_chapter_id: hasQuestion && questionType === '3' ? null : block.querySelector('.next-chapter').value,
                        question: questionData,
                    });
                });
                return chapters;
            }

            /**
             * Displays an inline error message next to a given input element.
             * It looks for a sibling element with the class 'text-red-500' to update.
             * @param {HTMLElement} inputElement The input element next to which the error should be displayed.
             * @param {string} message The error message to display.
             */
            function displayInlineError(inputElement, message) {
                let errorElement = inputElement.nextElementSibling;
                if (errorElement && errorElement.classList.contains('text-red-500')) {
                    errorElement.textContent = message;
                    errorElement.style.display = 'block';
                }
            }

            /**
             * Clears all inline error messages currently displayed on the form.
             * This targets all elements with the specific error class.
             */
            function clearAllInlineErrors() {
                document.querySelectorAll('.text-red-500.text-xs.mt-1').forEach(p => {
                    p.textContent = '';
                    p.style.display = 'none';
                });
            }

            window.prepareAndSubmitStory = function(event) {
                event.preventDefault();

                clearAllInlineErrors();

                let errors = [];

                function addError(inputElement, message) {
                    errors.push({ input: inputElement, message: message });
                }

                const storyNameInput = document.getElementById('story-name');
                const storyDescriptionTextarea = document.getElementById('story-description');
                const imageFileInput = document.getElementById('image-upload');
                const storyPlaceInput = document.getElementById('story-place');
                const storyDistanceInput = document.getElementById('story-distance');
                const storyTimeInput = document.getElementById('story-time');

                if (!storyNameInput.value.trim()) { addError(storyNameInput, lang.validation_story_name_required); }
                if (!storyDescriptionTextarea.value.trim()) { addError(storyDescriptionTextarea, lang.validation_story_description_required); }
                if (!storyPlaceInput.value.trim()) { addError(storyPlaceInput, lang.validation_story_place_required); }
                if (storyDistanceInput.value.trim() === '' || parseFloat(storyDistanceInput.value.trim()) < 0) { addError(storyDistanceInput, lang.validation_distance_required); }
                if (storyTimeInput.value.trim() === '' || parseFloat(storyTimeInput.value.trim()) < 0) { addError(storyTimeInput, lang.validation_time_required); }

                const chapters = collectChapters();

                for (let i = 0; i < chapters.length; i++) {
                    const chapter = chapters[i];
                    const chapterBlock = document.querySelectorAll('.chapter-block')[i];

                    const chapterTitleInput = chapterBlock.querySelector('.chapter-title');
                    if (!chapter.title) {
                        addError(chapterTitleInput, lang.validation_chapter_title_required);
                    }

                    const chapterContentTextarea = chapterBlock.querySelector('.chapter-content');
                    if (!chapter.content) {
                        addError(chapterContentTextarea, lang.validation_chapter_content_required);
                    }

                    const nextChapterSelect = chapterBlock.querySelector('.next-chapter');
                    if (!chapter.is_end && !(chapter.question && chapter.question.type === '3')) {
                        if (!chapter.next_chapter_id) {
                            addError(nextChapterSelect, lang.validation_next_chapter_required);
                        }
                    }

                    if (chapter.question) {
                        const questionTextInput = chapterBlock.querySelector('.question-text');
                        if (!chapter.question.text) {
                            addError(questionTextInput, lang.validation_question_text_required);
                        }

                        const wrongFeedbackTextarea = chapterBlock.querySelector('.wrong-feedback');
                        if (chapter.question.type === '3') {
                            const options = chapter.question.options;
                            let hasCorrectOption = false;
                            options.forEach(option => {
                                if (option.is_correct) {
                                    hasCorrectOption = true;
                                }
                            });
                            if (hasCorrectOption && !chapter.question.wrong_feedback) {
                                addError(wrongFeedbackTextarea, lang.validation_feedback_required);
                            }
                        } else {
                            if (!chapter.question.wrong_feedback) {
                                addError(wrongFeedbackTextarea, lang.validation_feedback_required);
                            }
                        }

                        const questionTypeSelect = chapterBlock.querySelector('.question-type');
                        if (!['1', '2', '3'].includes(questionTypeSelect.value)) {
                             addError(questionTypeSelect, lang.validation_answer_type_required);
                        }

                        if (chapter.question.type === '1' || chapter.question.type === '2') {
                            const inputAnswerInput = chapterBlock.querySelector('.input-answer');
                            if (!chapter.question.input_answer) {
                                addError(inputAnswerInput, lang.validation_correct_answer_required);
                            }
                            if (chapter.question.type === '2' && isNaN(chapter.question.input_answer)) {
                                addError(inputAnswerInput, lang.validation_answer_must_be_number);
                            }
                        }
                            if (chapter.question.type === '3') {
                            let hasCorrectOption = false;

                            for (let j = 0; j < chapter.question.options.length; j++) {
                                const option = chapter.question.options[j];
                                const optionNum = j + 1;
                                const optionDiv = chapterBlock.querySelectorAll('.options > .option-item')[j];

                                const optionTextInput = optionDiv.querySelector('.option-text');
                                if (!option.text) {
                                    addError(optionTextInput, lang.validation_option_text_required);
                                }

                                const optionNextSelect = optionDiv.querySelector('.option-next');
                                if (!option.next_chapter_id) {
                                    addError(optionNextSelect, lang.validation_option_next_chapter_required);
                                }

                            }
                        }
                        }
                    }

                if (errors.length > 0) {
                    errors.forEach(error => {
                        displayInlineError(error.input, error.message);
                    });
                    errors[0].input.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return;
                }

                chaptersDataInput.value = JSON.stringify(chapters);
                chapterImagesToDeleteInput.value = JSON.stringify(deletedChapterImagePaths);
                deletedQuestionIdsInput.value = JSON.stringify(deletedQuestionIds);
                deletedOptionIdsInput.value = JSON.stringify(deletedOptionIds);

                form.submit();
            };

            if (initialStoryData.chapters && initialStoryData.chapters.length > 0) {
                initialStoryData.chapters.sort((a, b) => a.order - b.order);
                initialStoryData.chapters.forEach(chapterData => {
                    addChapter(chapterData);
                });
            } else {
                addChapter();
            }

            updateChapterOptions();

            document.querySelectorAll('.chapter-block').forEach(block => {
                const nextSelect = block.querySelector('.next-chapter');
                if (nextSelect.dataset.initialValue) {
                    const initialDbId = nextSelect.dataset.initialValue;
                    const targetChapterBlock = [...document.querySelectorAll('.chapter-block')]
                        .find(b => {
                            const tempIdVal = b.querySelector('.chapter-temp-id').value;
                            const dbIdVal = b.querySelector('.chapter-db-id').value;
                            return tempIdVal == initialDbId || dbIdVal == initialDbId;
                        });
                    if (targetChapterBlock) {
                        nextSelect.value = targetChapterBlock.dataset.chapterId;
                    }
                }

                block.querySelectorAll('.option-next').forEach(optionNextSelect => {
                    if (optionNextSelect.dataset.initialValue) {
                        const initialDbId = optionNextSelect.dataset.initialValue;
                        const targetChapterBlock = [...document.querySelectorAll('.chapter-block')]
                            .find(b => {
                                const tempIdVal = b.querySelector('.chapter-temp-id').value;
                                const dbIdVal = b.querySelector('.chapter-db-id').value;
                                return tempIdVal == initialDbId || dbIdVal == initialDbId;
                            });
                        if (targetChapterBlock) {
                            optionNextSelect.value = targetChapterBlock.dataset.chapterId;
                        }
                    }
                });
            });
        });
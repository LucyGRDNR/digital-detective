<div>
    <h1 class="text-2xl font-bold mb-2 text-white"><?php echo e($story->name); ?></h1>
    <p class="text-lg text-gray-300 mb-4"><?php echo e(__('play.chapter')); ?>: <span><?php echo e($currentChapter->title); ?></span></p>

    <div id="game-content-area" class="bg-gray-800 p-4 rounded-lg shadow-md">

        <div id="chapter-content" class="mb-4">
            <p class="text-gray-200 text-base leading-relaxed text-justify"><?php echo nl2br(e($currentChapter->content)); ?></p>
        </div>

        <!--[if BLOCK]><![endif]--><?php if($currentChapter->image_path): ?>
            <div class="mb-4 overflow-hidden rounded-lg shadow-md">
                <img src="<?php echo e(asset('storage/' . $currentChapter->image_path)); ?>" alt="Chapter Image"
                    class="w-full max-h-64 object-cover object-center">
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!--[if BLOCK]><![endif]--><?php if($question && !$isGameEnd && !$showFeedback): ?>
            <div class="mt-4 rounded-lg bg-gray-800">
                <h3 class="text-md font-semibold mb-3 text-white"><?php echo e($question->text); ?></h3>

                <!--[if BLOCK]><![endif]--><?php if($question->hint): ?>
                    <div class="mt-3 mb-3">
                        <!--[if BLOCK]><![endif]--><?php if($hintWasShown): ?>
                            <div class="p-3 border border-gray-600 rounded-lg bg-gray-700/70">
                                <p class="text-sm text-gray-300"><?php echo e($question->hint); ?></p>
                                <button wire:click="hideHint" class="mt-2 bg-gray-600 text-white px-3 py-1 rounded hover:bg-gray-700 text-xs"><?php echo e(__('play.hide_hint')); ?></button>
                            </div>
                        <?php else: ?>
                            <button wire:click="showHint" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 text-sm"><i class="fa-regular fa-lightbulb"></i></button>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <!--[if BLOCK]><![endif]--><?php if(in_array($question->type, [1,2])): ?>
                    <div>
                        <input type="<?php echo e($question->type === 2 ? 'number' : 'text'); ?>"
                            wire:model.live="inputAnswer"
                            wire:keydown.enter="submitAnswer"
                            class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white placeholder-gray-400 mt-3 focus:ring focus:ring-blue-500 focus:border-blue-500"
                            placeholder="<?php echo e($question->type === 2 ? __('play.enter_number') : __('play.enter_answer')); ?>">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['inputAnswer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-red-400 mt-1 text-sm"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        <button wire:click="submitAnswer"
                                class="mt-3 w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed"
                                <?php if($inputAnswer === ''): ?> disabled <?php endif; ?>>
                            <?php echo e(__('play.submit')); ?>

                        </button>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <!--[if BLOCK]><![endif]--><?php if($question->type === 3): ?>
                    <div class="space-y-2 mt-3">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $question->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div>
                                <input type="radio" id="option-<?php echo e($option->id); ?>" name="question-<?php echo e($question->id); ?>-options" wire:model.live="selectedOptionId" value="<?php echo e($option->id); ?>"
                                        class="form-radio h-4 w-4 text-blue-600 bg-gray-700 border-gray-600 focus:ring-blue-500 cursor-pointer">
                                <label for="option-<?php echo e($option->id); ?>" class="ml-2 text-gray-300 cursor-pointer"><?php echo e($option->text); ?></label>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['selectedOptionId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-red-400 mt-1 text-sm"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        <button wire:click="submitAnswer"
                                class="mt-3 w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed"
                                <?php if(!$selectedOptionId): ?> disabled <?php endif; ?>>
                            <?php echo e(__('play.submit')); ?>

                        </button>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!--[if BLOCK]><![endif]--><?php if(!$question && !$isGameEnd && !$showFeedback): ?>
            <div class="mt-4">
                <button wire:click="continueGame"
                        class="w-full bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 text-lg font-semibold">
                    <?php echo e(__('play.continue')); ?>

                </button>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <!--[if BLOCK]><![endif]--><?php if($showFeedback && !$isGameEnd): ?>
        <div class="mt-4 p-4 rounded-lg bg-red-900 border border-red-950">
            <h3 class="text-md font-semibold mb-3 whitespace-pre-wrap text-white"><?php echo e($feedbackMessage); ?></h3>
            <button wire:click="clearFeedbackAndContinue"
                    class="mt-3 w-full bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">
                <?php echo e(__('play.continue')); ?>

            </button>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!--[if BLOCK]><![endif]--><?php if($isGameEnd): ?>
        <div class="mt-6 text-center text-xl font-semibold text-green-400 p-4 bg-gray-800 rounded-lg shadow-md">
            <span><?php echo e(__('play.end_story_congratulations')); ?></span>
            <br>
            <a href="/" class="underline text-blue-400 hover:text-blue-500 mt-4 inline-block"><?php echo e(__('play.back_to_homepage')); ?></a>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div><?php /**PATH C:\Users\lugar\Desktop\digital-detective\digital-detective\resources\views/livewire/play-story.blade.php ENDPATH**/ ?>
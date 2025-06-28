<div>
    <form wire:submit.prevent="save" enctype="multipart/form-data" class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg my-8">
        <div>
            <label><?php echo e(__('create-edit.story_name')); ?></label>
            <input type="text" wire:model="name" maxlength="80" required class="w-full" />
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        <div>
            <label><?php echo e(__('create-edit.story_description')); ?></label>
            <textarea wire:model="description" rows="3" required class="w-full"></textarea>
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        <div>
            <label><?php echo e(__('create-edit.story_main_image')); ?></label>
            <input type="file" wire:model="image_file" required />
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['image_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            <!--[if BLOCK]><![endif]--><?php if($image_file): ?>
                <img src="<?php echo e($image_file->temporaryUrl()); ?>" class="max-w-xs mt-2" />
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        <div>
            <label><?php echo e(__('create-edit.story_place')); ?></label>
            <input type="text" wire:model="place" maxlength="80" required class="w-full" />
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['place'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        <div>
            <label><?php echo e(__('create-edit.story_place_gps_optional')); ?></label>
            <input type="text" wire:model="place_GPS" class="w-full" />
        </div>
        <div>
            <label><?php echo e(__('create-edit.story_distance_km')); ?></label>
            <input type="number" wire:model="distance" min="0" required class="w-full" />
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['distance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        <div>
            <label><?php echo e(__('create-edit.story_estimated_time_minutes')); ?></label>
            <input type="number" wire:model="time" min="0" required class="w-full" />
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <hr class="my-6" />

        <h3><?php echo e(__('create-edit.chapters')); ?></h3>
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $chapters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $chapter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="border p-4 mb-4 bg-gray-50">
                <label><?php echo e(__('create-edit.chapter_title')); ?></label>
                <input type="text" wire:model="chapters.<?php echo e($i); ?>.title" maxlength="40" required class="w-full" />
                <label><?php echo e(__('create-edit.chapter_content')); ?></label>
                <textarea wire:model="chapters.<?php echo e($i); ?>.content" rows="2" class="w-full"></textarea>
                <label><?php echo e(__('create-edit.chapter_upload_image_optional')); ?></label>
                <input type="file" wire:model="chapters.<?php echo e($i); ?>.image" />
                <!--[if BLOCK]><![endif]--><?php if(isset($chapter['image']) && $chapter['image']): ?>
                    <img src="<?php echo e($chapter['image']->temporaryUrl()); ?>" class="max-w-xs mt-2" />
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <div>
                    <input type="checkbox" wire:model="chapters.<?php echo e($i); ?>.is_end" />
                    <label><?php echo e(__('create-edit.is_end_chapter')); ?></label>
                </div>
                <div>
                    <label><?php echo e(__('create-edit.next_chapter_title')); ?></label>
                    <select wire:model="chapters.<?php echo e($i); ?>.next_chapter" class="w-full">
                        <option value="">--</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $chapters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j => $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <!--[if BLOCK]><![endif]--><?php if($j !== $i): ?>
                                <option value="<?php echo e($j); ?>"><?php echo e($c['title'] ?: 'Chapter '.($j+1)); ?></option>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>
                <div>
                    <label><?php echo e(__('create-edit.add_question')); ?></label>
                    <input type="checkbox" wire:model="chapters.<?php echo e($i); ?>.question.enabled" />
                </div>
                <!--[if BLOCK]><![endif]--><?php if($chapter['question']['enabled']): ?>
                    <div class="border p-2 mt-2 bg-gray-100">
                        <label><?php echo e(__('create-edit.question_text')); ?></label>
                        <textarea wire:model="chapters.<?php echo e($i); ?>.question.text" class="w-full"></textarea>
                        <label><?php echo e(__('create-edit.answer_type')); ?></label>
                        <select wire:model="chapters.<?php echo e($i); ?>.question.type" class="w-full">
                            <option value="">--</option>
                            <option value="1"><?php echo e(__('create-edit.answer_type_text')); ?></option>
                            <option value="2"><?php echo e(__('create-edit.answer_type_number')); ?></option>
                            <option value="3"><?php echo e(__('create-edit.answer_type_multiple_choice')); ?></option>
                        </select>
                        <label><?php echo e(__('create-edit.question_hint_optional')); ?></label>
                        <input type="text" wire:model="chapters.<?php echo e($i); ?>.question.hint" class="w-full" />
                        <label><?php echo e(__('create-edit.wrong_answer_feedback')); ?></label>
                        <textarea wire:model="chapters.<?php echo e($i); ?>.question.wrong_feedback" class="w-full"></textarea>
                        <!--[if BLOCK]><![endif]--><?php if(in_array($chapter['question']['type'], [1,2])): ?>
                            <label><?php echo e(__('create-edit.correct_answer')); ?></label>
                            <input type="text" wire:model="chapters.<?php echo e($i); ?>.question.input_answer" class="w-full" />
                        <?php elseif($chapter['question']['type'] == 3): ?>
                            <h5><?php echo e(__('create-edit.options_max_5')); ?></h5>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $chapter['question']['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center space-x-2">
                                    <input type="text" wire:model="chapters.<?php echo e($i); ?>.question.options.<?php echo e($k); ?>.text" placeholder="<?php echo e(__('create-edit.option_text_placeholder')); ?>" class="w-1/2" />
                                    <input type="checkbox" wire:model="chapters.<?php echo e($i); ?>.question.options.<?php echo e($k); ?>.is_correct" />
                                    <label><?php echo e(__('create-edit.correct_answer')); ?></label>
                                    <select wire:model="chapters.<?php echo e($i); ?>.question.options.<?php echo e($k); ?>.next_chapter" class="w-1/3">
                                        <option value="">--</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $chapters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j => $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <!--[if BLOCK]><![endif]--><?php if($j !== $i): ?>
                                                <option value="<?php echo e($j); ?>"><?php echo e($c['title'] ?: 'Chapter '.($j+1)); ?></option>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                    <button type="button" wire:click="removeOption(<?php echo e($i); ?>, <?php echo e($k); ?>)" class="text-red-500">&times;</button>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            <button type="button" wire:click="addOption(<?php echo e($i); ?>)" class="mt-2 bg-blue-500 text-white px-2 py-1 rounded"><?php echo e(__('create-edit.add_option')); ?></button>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <button type="button" wire:click="removeChapter(<?php echo e($i); ?>)" class="text-red-500 mt-2"><?php echo e(__('create-edit.delete_chapter')); ?></button>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        <button type="button" wire:click="addChapter" class="bg-gray-800 hover:bg-blue-700 text-white px-8 py-3 rounded-lg"><?php echo e(__('create-edit.add_chapter_button')); ?></button>
        <div class="flex justify-end mt-8">
            <button type="submit" class="bg-green-700 text-white px-8 py-3 rounded-lg"><?php echo e(__('create-edit.save_story_button')); ?></button>
        </div>
    </form>
</div><?php /**PATH C:\Users\lugar\Desktop\digital-detective\digital-detective\resources\views/livewire/story-create.blade.php ENDPATH**/ ?>
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($story->name); ?> - <?php echo e(__('welcome-show.digital_detective')); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-[url('/storage/app/public/images/download.png')] bg-no-repeat bg-cover bg-fixed text-white min-h-screen relative">

    <?php echo $__env->make('partials._navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="px-4 py-10">
        <div class="max-w-3xl mx-auto rounded-2xl bg-gray-800 bg-opacity-70 shadow-md overflow-hidden relative">

            <div class="relative w-full h-80">
                <img src="<?php echo e(asset('storage/' . $story->image_path)); ?>"
                     alt="<?php echo e($story->name); ?>"
                     class="w-full h-full object-cover" />
            </div>

            <div class="p-6">
                <h1 class="text-3xl font-bold mb-4 text-center"><?php echo e($story->name); ?></h1>

                <p class="text-gray-300 mb-4 text-sm md:text-base text-justify"><?php echo e($story->description); ?></p>

                <div class="mb-6 text-sm md:text-base text-gray-400">
                    <p class="mb-2 text-md text-gray-300">
                    <strong class="text-gray-200">
                        <i class="fas fa-map-marker-alt mr-2 text-base"></i> <?php echo e(__('welcome-show.location')); ?>:
                    </strong> <?php echo e($story->place); ?>

                    </p>
                    <p class="mb-2 text-md text-gray-300">
                        <strong class="text-gray-200">
                            <i class="fas fa-clock mr-2"></i> <?php echo e(__('welcome-show.time')); ?>:
                        </strong> <?php echo e($story->time); ?> <?php echo e(__('welcome-show.minutes')); ?>

                    </p>
                    <p class="mb-2 text-md text-gray-300">
                        <strong class="text-gray-200">
                            <i class="fas fa-route mr-2"></i> <?php echo e(__('welcome-show.distance')); ?>:
                        </strong> <?php echo e($story->distance); ?> <?php echo e(__('welcome-show.kilometers')); ?>

                    </p>
                </div>

                <?php if(auth()->guard()->check()): ?>
                    <?php
                        $user = Auth::user();
                        $userProgress = $user->progress()->where('story_id', $story->id)->first();
                        $hasActivePlaythrough = ($userProgress && $userProgress->current_chapter_id !== null && !$userProgress->is_end);
                        $userEverCompletedStory = ($userProgress && $userProgress->completed);
                    ?>

                    <div class="mt-auto pt-4">
                        <?php if($hasActivePlaythrough): ?>
                            <div class="flex flex-col sm:flex-row justify-between space-y-2 sm:space-y-0 sm:space-x-2">
                                <a href="<?php echo e(route('play.story', ['story' => $story->id])); ?>"
                                   class="flex-1 text-center py-2 px-4 rounded-md bg-gray-800 hover:bg-green-800 text-white hover:bg-green-700 transition duration-150 ease-in-out text-lg font-semibold">
                                    <?php echo e(__('welcome-show.resume_story')); ?>

                                </a>
                                <a href="<?php echo e(route('play.story', ['story' => $story->id, 'start_over' => true])); ?>"
                                   class="flex-1 text-center py-2 px-4 rounded-md bg-gray-800 hover:bg-red-800 text-white hover:bg-red-700 transition duration-150 ease-in-out text-lg font-semibold">
                                    <?php echo e(__('welcome-show.start_over')); ?>

                                </a>
                            </div>
                        <?php else: ?>
                            <a href="<?php echo e(route('play.story', ['story' => $story->id, 'start_over' => true])); ?>"
                               class="block text-center py-2 px-4 rounded-md bg-gray-800 text-white hover:bg-green-800 transition duration-150 ease-in-out text-lg font-semibold">
                                <?php echo e(__('welcome-show.start_story')); ?>

                            </a>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="mt-6 text-center text-yellow-400 text-sm md:text-base">
                        <?php echo __('welcome-show.login_or_register_to_play',
                            [
                                'login' => '<a href="'. route('login') .'" class="underline text-blue-400">'. __('welcome-show.login_link') .'</a>',
                                'register' => '<a href="'. route('register') .'" class="underline text-blue-400">'. __('welcome-show.register_link') .'</a>'
                            ]
                            ); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html><?php /**PATH C:\Users\lugar\Desktop\digital-detective\digital-detective\resources\views/show.blade.php ENDPATH**/ ?>
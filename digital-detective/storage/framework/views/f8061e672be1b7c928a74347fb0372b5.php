<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digitální Detektiv</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body class="bg-[url('/storage/app/public/images/download.png')] bg-repeat bg-center text-white min-h-screen">

    <?php echo $__env->make('partials._navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="px-6">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            <?php $__currentLoopData = $stories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $story): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="relative flex flex-col rounded-lg bg-gray-800 bg-opacity-90 p-4 shadow-md transition duration-200 ease-in-out hover:scale-105 hover:shadow-lg">
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(Auth::user()->hasRole('admin')): ?>
                            <a href="<?php echo e(route('stories.edit', $story->id)); ?>"
                               class="absolute top-2 right-2 text-blue-400 hover:text-blue-200 z-10 p-2 rounded-full bg-gray-700 bg-opacity-70 hover:bg-opacity-100 transition duration-150 ease-in-out"
                               title="Upravit příběh">
                                <i class="fas fa-edit text-lg"></i>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>

                    <a href="<?php echo e(route('stories.show', $story->id)); ?>" style="text-decoration: none; color: inherit;">
                        <div class="mb-3 h-48 w-full overflow-hidden rounded">
                            <img src="<?php echo e(asset('storage/' . $story->image_path)); ?>" onerror="this.onerror=null;this.src='https://placehold.co/400x250/333333/FFFFFF?text=No+Image';" alt="<?php echo e($story->name); ?>" class="h-full w-full object-cover" />
                        </div>
                        <h2 class="mb-1 text-lg font-bold"><?php echo e($story->name); ?></h2>
                        <p class="mb-1 text-sm text-gray-300"><?php echo e(__('welcome-show.location')); ?>: <?php echo e($story->place); ?></p>
                        <p class="mb-1 text-sm text-gray-300"><?php echo e(__('welcome-show.time')); ?>: <?php echo e($story->time); ?> <?php echo e(__('welcome-show.minutes')); ?></p>
                        <p class="mb-4 text-sm text-gray-300"><?php echo e(__('welcome-show.distance')); ?>: <?php echo e($story->distance); ?> <?php echo e(__('welcome-show.kilometers')); ?></p>
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </main>
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html><?php /**PATH C:\Users\Lucy\Downloads\digital-detective\digital-detective\resources\views/welcome.blade.php ENDPATH**/ ?>
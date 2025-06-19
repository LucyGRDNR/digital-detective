<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?php echo e($story->name); ?> - <?php echo e(__('play.digital_detective')); ?></title>
      <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
      <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
      <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

  </head>
  <body class="bg-[url('/storage/app/public/images/download.png')] bg-repeat bg-center text-white min-h-screen">
    <?php echo $__env->make('partials._navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <main class="px-4 py-10">
      <div id="game-container" class="max-w-3xl mx-auto rounded-lg bg-gray-900 bg-opacity-80 p-6 shadow-md border border-gray-700">
         <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('play-story', ['story' => $story, 'start_over' => $startOver]);

$__html = app('livewire')->mount($__name, $__params, 'lw-3296987689-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
      </div>
    </main>
      <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

  </body>
</html>
<?php /**PATH C:\Users\lugar\Desktop\digital-detective\digital-detective\resources\views/play.blade.php ENDPATH**/ ?>
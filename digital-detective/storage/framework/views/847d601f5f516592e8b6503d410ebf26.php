<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<title><?php echo e(env('APP_NAME')); ?></title>

<?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

<!-- Styles -->
<?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>


<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
<?php /**PATH C:\Users\lugar\Desktop\digital-detective\digital-detective\resources\views/layouts/includes/head.blade.php ENDPATH**/ ?>
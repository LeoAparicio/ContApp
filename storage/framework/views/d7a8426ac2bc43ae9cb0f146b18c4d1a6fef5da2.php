

<head>
    <title>Contarapp Not Found</title>
</head>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="container404">
            <div class="row d-flex justify-content-center">
                <img src="<?php echo e(asset('img/logo-contarapp-01.png')); ?>" class="logo0">
            </div>
            <div class="row d-flex justify-content-center align-top">
                <div class="msg404">4</div>
                <img class="logo spin mt-4" src="<?php echo e(asset('img/logo-contarapp-03.png')); ?>">
                <div class="msg404">4</div>
            </div>
            <div class="row d-flex justify-content-center msg404-2">
                <div>Página no encontrada.</div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Conta\Contarapp2.0\resources\views/errors/404.blade.php ENDPATH**/ ?>
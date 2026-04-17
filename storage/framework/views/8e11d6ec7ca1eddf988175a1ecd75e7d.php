<?php $__env->startSection('content'); ?>
    <?php echo $table; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make(
    config('laravolt.indonesia.view.layout'),
    [
        '__page' => [
            'title' => __('Provinsi'),
            'actions' => [
                [
                    'label' => __('Tambah'),
                    'class' => 'primary',
                    'icon' => 'icon plus circle',
                    'url' => route('indonesia::provinsi.create')
                ],
            ]
        ],
    ]
, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Kopi_Ngaji_Project\KopiNgaji\vendor\laravolt\indonesia\resources\views\provinsi\index.blade.php ENDPATH**/ ?>
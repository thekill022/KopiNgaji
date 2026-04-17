<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('ui::components.panel', ['title' => __('Tambah Provinsi')]); ?>
        <?php echo form()->post(route('indonesia::provinsi.store')); ?>

        <?php echo form()->text('id')->label('Kode')->required(); ?>

        <?php echo form()->text('name')->label('Name')->required(); ?>

        <?php echo form()->action([
            form()->submit(__('Save')),
            form()->link(__('Cancel'), route('indonesia::provinsi.index'))
        ]); ?>

        <?php echo form()->close(); ?>

    <?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(
    config('laravolt.indonesia.view.layout'),
    [
        '__page' => [
            'title' => __('Provinsi'),
            'actions' => [
                [
                    'label' => __('Lihat Semua Provinsi'),
                    'class' => '',
                    'icon' => '',
                    'url' => route('indonesia::provinsi.index')
                ],
            ]
        ],
    ]
, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Kopi_Ngaji_Project\KopiNgaji\vendor\laravolt\indonesia\resources\views\provinsi\create.blade.php ENDPATH**/ ?>
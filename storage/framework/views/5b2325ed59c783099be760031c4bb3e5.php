<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('ui::components.panel', ['title' => __('Edit Provinsi')]); ?>
        <?php echo form()->bind($provinsi)->put(route('indonesia::provinsi.update', $provinsi)); ?>

        <?php echo form()->hidden('previous_id')->value($provinsi->getKey()); ?>

        <?php echo form()->text('id')->label('Kode')->required(); ?>

        <?php echo form()->text('name')->label('Name')->required(); ?>

        <?php echo form()->action([
            form()->submit('Save'),
            form()->link('Cancel', route('indonesia::provinsi.index'))
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
, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Kopi_Ngaji_Project\KopiNgaji\vendor\laravolt\indonesia\resources\views\provinsi\edit.blade.php ENDPATH**/ ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('ui::components.panel', ['title' => __('Tambah Kecamatan')]); ?>
        <?php echo form()->post(route('indonesia::kecamatan.store')); ?>

        <?php echo form()->text('id')->label('Kode')->required(); ?>

        <?php echo form()->text('name')->label('Nama')->required(); ?>

        <?php echo form()->select('city_id', \Laravolt\Indonesia\Models\Kabupaten::pluck('name', 'id'))->label('Kabupaten')->required(); ?>

        <?php echo form()->action([
            form()->submit('Save'),
            form()->link('Cancel', route('indonesia::kecamatan.index'))
        ]); ?>

        <?php echo form()->close(); ?>

    <?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(
    config('laravolt.indonesia.view.layout'),
    [
        '__page' => [
            'title' => __('Kecamatan'),
            'actions' => [
                [
                    'label' => __('Lihat Semua Kecamatan'),
                    'class' => '',
                    'icon' => '',
                    'url' => route('indonesia::kecamatan.index')
                ],
            ]
        ],
    ]
, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Kopi_Ngaji_Project\KopiNgaji\vendor\laravolt\indonesia\resources\views\kecamatan\create.blade.php ENDPATH**/ ?>
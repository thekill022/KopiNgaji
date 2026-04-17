<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('ui::components.panel', ['title' => __('Tambah Kabupaten/Kota')]); ?>
        <?php echo form()->post(route('indonesia::kabupaten.store')); ?>

        <?php echo form()->text('id')->label('Kode')->required(); ?>

        <?php echo form()->text('name')->label('Name')->required(); ?>

        <?php echo form()->select('province_id', \Laravolt\Indonesia\Models\Provinsi::pluck('name', 'id'))->label('Provinsi')->required(); ?>

        <?php echo form()->action([
            form()->submit('Save'),
            form()->link('Cancel', route('indonesia::kabupaten.index'))
        ]); ?>

        <?php echo form()->close(); ?>

    <?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(
    config('laravolt.indonesia.view.layout'),
    [
        '__page' => [
            'title' => __('Kota/Kabupaten'),
            'actions' => [
                [
                    'label' => __('Lihat Semua Kota/Kabupaten'),
                    'class' => '',
                    'icon' => '',
                    'url' => route('indonesia::kabupaten.index')
                ],
            ]
        ],
    ]
, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Kopi_Ngaji_Project\KopiNgaji\vendor\laravolt\indonesia\resources\views\kabupaten\create.blade.php ENDPATH**/ ?>
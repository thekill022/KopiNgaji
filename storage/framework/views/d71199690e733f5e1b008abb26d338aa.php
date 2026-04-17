<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('ui::components.panel', ['title' => __('Tambah Desa/Kelurahan')]); ?>
        <?php echo form()->post(route('indonesia::kelurahan.store')); ?>

        <?php echo form()->text('id')->label('Kode')->required(); ?>

        <?php echo form()->text('name')->label('Nama Desa/Kelurahan')->required(); ?>

        <?php echo form()->select('district_id', \Laravolt\Indonesia\Models\Kecamatan::pluck('name', 'id'))->label('Kecamatan')->required(); ?>

        <?php echo form()->action([
            form()->submit('Save'),
            form()->link('Cancel', route('indonesia::kelurahan.index'))
        ]); ?>

        <?php echo form()->close(); ?>

    <?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(
    config('laravolt.indonesia.view.layout'),
    [
        '__page' => [
            'title' => __('Desa/Kelurahan'),
            'actions' => [
                [
                    'label' => __('Lihat Semua Desa/Kelurahan'),
                    'class' => '',
                    'icon' => '',
                    'url' => route('indonesia::kelurahan.index')
                ],
            ]
        ],
    ]
, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Kopi_Ngaji_Project\KopiNgaji\vendor\laravolt\indonesia\resources\views\kelurahan\create.blade.php ENDPATH**/ ?>
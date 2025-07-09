

<?php $__env->startSection('content'); ?>
    <div id="form-pet-container">
        <h2>Editar Animal</h2>

        <form action="<?php echo e(route('pets.update', $pet)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="<?php echo e($pet->nome); ?>" required>

            <label for="raca">Raça:</label>
            <input type="text" name="raca" id="raca" value="<?php echo e($pet->raca); ?>" required>

            <label for="foto">Nova Foto:</label>
            <input type="file" name="foto" id="foto">

            <button type="submit" class="btn-update">Atualizar</button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\projetos\PlataformaAdocao\resources\views/edit.blade.php ENDPATH**/ ?>
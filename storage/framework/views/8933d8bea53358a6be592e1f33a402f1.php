

<?php $__env->startSection('content'); ?>
<div id="form-pet-container">
    <h2>Cadastrar Animal</h2>

    <form action="<?php echo e(route('pets.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required>

        <div class="form-row">
    <label for="especie">Espécie:</label>
    <select name="especie" id="especie" required>
        <option value="Cachorro">Cachorro</option>
        <option value="Gato">Gato</option>
        <option value="Outro">Outro</option>
    </select>
</div>

        <label for="idade">Idade (anos):</label>
        <input type="number" name="idade" id="idade" min="0">

        <label for="saude">Condição de Saúde:</label>
        <textarea name="saude" id="saude" rows="3"></textarea>

       <div class="form-row">
    <label for="ong_id">ONG responsável:</label>
    <select name="ong_id" id="ong_id" required>
        <?php $__currentLoopData = $ongs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ongId => $ongNome): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($ongId); ?>"><?php echo e($ongNome); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

        <div class="form-check">
    <input type="checkbox" name="disponivel" id="disponivel" value="1" checked>
    <label for="disponivel">Disponível para adoção</label>
</div>

        <button type="submit" class="btn-update">Salvar</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\projetos\PlataformaAdocao\resources\views/create.blade.php ENDPATH**/ ?>
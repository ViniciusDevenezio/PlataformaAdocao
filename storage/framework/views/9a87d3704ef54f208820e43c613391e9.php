<?php $__env->startSection('head'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('menu'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2 class="h2cad" style="color: black; font-size: 24px; display: block;">Cadastro de Animais</h2>
    <form class="formcad" action="#" method="POST">
        <label class="labelcad" for="nome">Nome do Animal:</label>
        <input class="inputcad" type="text" id="nome" name="nome" required>

        <label class="labelcad" for="idade">Idade:</label>
        <input class="inputcad" type="number" id="idade" name="idade" min="0" required>

        <label class="labelcad" for="especie">Espécie:</label>
        <select class="selectcad" id="especie" name="especie">
            <option value="Cachorro">Cachorro</option>
            <option value="Gato">Gato</option>
            <option value="Outro">Outro</option>
        </select>

        <label class="labelcad" for="raca">Raça:</label>
        <input class="inputcad" type="text" id="raca" name="raca">

        <label class="labelcad" for="descricao">Descrição:</label>
        <textarea class="textareacad" id="descricao" name="descricao" rows="3"></textarea>

        <label class="labelcad" for="foto">Foto do Animal:</label>
        <input class="inputcad" type="file" id="foto" name="foto" accept="image/*">

        <button class="buttoncad" type="submit">Cadastrar</button>
    </form>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\CésarDuarte\Documents\GitHub\PlataformaAdocao\resources\views/cadastro.blade.php ENDPATH**/ ?>
<?php $__env->startSection('head'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('menu'); ?>

<?php $__env->stopSection(); ?>

    <div class="container">
        <h2>Cadastro de Animais</h2>
        <form action="#" method="POST">
            <label for="nome">Nome do Animal:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="idade">Idade:</label>
            <input type="number" id="idade" name="idade" min="0" required>

            <label for="especie">Espécie:</label>
            <select id="especie" name="especie">
                <option value="Cachorro">Cachorro</option>
                <option value="Gato">Gato</option>
                <option value="Outro">Outro</option>
            </select>

            <label for="raca">Raça:</label>
            <input type="text" id="raca" name="raca">

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="3"></textarea>

            <label for="foto">Foto do Animal:</label>
            <input type="file" id="foto" name="foto" accept="image/*">

            <button type="submit">Cadastrar</button>
        </form>
    </div>


<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\CésarDuarte\Desktop\Teste\PlataformaAdocao\resources\views/cadastro.blade.php ENDPATH**/ ?>
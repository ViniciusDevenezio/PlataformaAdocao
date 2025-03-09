<?php $__env->startSection('head'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('menu'); ?>

<?php $__env->stopSection(); ?>

<div class="login-container text-center">
    <h2>Boas-vindas</h2>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card p-4">
                <h4>Acesse sua conta</h4>
                <input type="text" class="form-control my-2" placeholder="E-mail, CPF ou CNPJ">
                <input type="password" class="form-control my-2" placeholder="Digite sua senha">
                <div class="form-check text-start">
                    <input type="checkbox" class="form-check-input" id="manterConectado">
                    <label class="form-check-label" for="manterConectado">Mantenha-me conectado</label>
                </div>
                <button class="btn btn-orange w-100 mt-3">Entrar</button>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4">
                <h4>Crie sua conta!</h4>
                <input type="text" class="form-control my-2" placeholder="Digite o CPF ou CNPJ">
                <button class="btn btn-outline-primary w-100">Criar conta ONG</button>
                <button class="btn btn-outline-primary w-100 mt-2">Criar conta Adotante</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\CésarDuarte\Documents\GitHub\PlataformaAdocao\resources\views/login.blade.php ENDPATH**/ ?>
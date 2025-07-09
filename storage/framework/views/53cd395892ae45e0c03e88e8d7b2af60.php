

<?php $__env->startSection('content'); ?>
<div class="pet-list-container">
    <h1>Gerenciamento de Animais</h1>

    <?php if(session('success')): ?>
        <div class="alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <a href="<?php echo e(route('pets.create')); ?>" class="btn-cadastrar-pet">+ Adicionar Animal</a>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Espécie</th>
                    <th>Idade</th>
                    <th>ONG Responsável</th>
                    <th>Disponível?</th>
                    <th style="width: 140px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $animais; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $animal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($animal->id); ?></td>
                    <td><?php echo e($animal->nome); ?></td>
                    <td><?php echo e($animal->especie); ?></td>
                    <td><?php echo e($animal->idade ?? '-'); ?></td>
                    <td><?php echo e($animal->ong->nome ?? '-'); ?></td>
                    <td><?php echo e($animal->disponivel ? 'Sim' : 'Não'); ?></td>
                    <td>
                        <a href="<?php echo e(route('pets.edit', $animal)); ?>" class="btn btn-sm btn-primary" title="Editar">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="<?php echo e(route('pets.destroy', $animal)); ?>" method="POST" style="display:inline-block;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir?')">
                                <i class="fas fa-trash-alt"></i> Excluir
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php if($animais->isEmpty()): ?>
                <tr>
                    <td colspan="7" style="text-align: center;">Nenhum animal cadastrado.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\projetos\PlataformaAdocao\resources\views/index.blade.php ENDPATH**/ ?>
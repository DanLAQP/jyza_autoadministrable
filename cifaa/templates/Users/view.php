<style>
    .label-text {
        color: #f8f9fa; /* Color plomo (gris) */
        font-weight: bold;
    }
    .data-box {
        background-color: #6c757d; /* Fondo claro similar a un input */
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 5px 10px;
    }
    
    .actions {
        text-align: center;
        margin-top: 30px;
    }
</style>

<div class="container mt-4 mb-4">
    <!-- Header -->
    <div class="col-12 mb-4">
        <h3 class="text-info"><i class="fas fa-user"></i> Información del Usuario</h3>
    </div>

    <!-- Cuerpo -->
    <div>
        <!-- Campo: Nombre de Usuario -->
        <div class="row mb-3">
            <div class="col-3">
                <p class="label-text"><?= __('Nombre de Usuario:') ?></p>
            </div>
            <div class="col-9">
                <div class="data-box"><?= h($user->username) ?></div>
            </div>
        </div>

        <!-- Campo: Rol -->
        <div class="row mb-3">
            <div class="col-3">
                <p class="label-text"><?= __('Rol:') ?></p>
            </div>
            <div class="col-9">
                <div class="data-box">
                    <?php 
                        $roles = [1 => 'Administrador', 2 => 'Usuario'];
                        echo $roles[$user->rol] ?? __('N/A');
                    ?>
                </div>
            </div>
        </div>

        <!-- Campo: Fechas -->
        <div class="row mb-3">
            <div class="col-3">
                <p class="label-text"><?= __('Creado el:') ?></p>
            </div>
            <div class="col-9">
                <div class="data-box"><?= h($user->created) ?></div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-3">
                <p class="label-text"><?= __('Modificado el:') ?></p>
            </div>
            <div class="col-9">
                <div class="data-box"><?= h($user->modified) ?></div>
            </div>
        </div>
    </div>

    <!-- Acciones -->
    <div class="text-center mt-4">
        <?= $this->Html->link(__('Volver a la Lista'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    </div>
</div>

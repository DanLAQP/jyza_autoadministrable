<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<div class="text-center">
    <!-- Ícono de usuario dentro de un círculo -->
    <div class="user-icon">
        <i class="fa-solid fa-user"></i>
    </div>
</div>
<div class="text-center">
    <h3 class="text-info fw-bold mb-4 text-uppercase">Iniciar Sesión</h3>
</div>







<!-- Mensajes Flash en login -->
<div class="mb-3">
    <?= $this->Flash->render() ?>
</div>

<?= $this->Form->create() ?>


<div class="mb-3">
    <?= $this->Form->control('username', [
        'label' => false,
        'placeholder' => 'Correo electrónico',
        'class' => 'form-control py-3',
        'required' => true,
    ]) ?>
</div>

<div class="mb-4">
    <?= $this->Form->control('password', [
        'label' => false,
        'placeholder' => 'Contraseña',
        'class' => 'form-control  py-3',
        'required' => true,
    ]) ?>
</div>

<div class="text-center">
    <?= $this->Form->button(__('Ingresar'), ['class' => 'btn btn-info btn-lg w-100']) ?>
</div>

<?= $this->Form->end() ?>
<style>
    .user-icon {
        width: 90px;
        height: 90px;
        background: #b0b0b0;
        color: #333;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 auto 20px;
        font-size: 36px; 
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); 
    }
    .form-control {
        background: #b0b0b0;
        padding: 6px 12px !important;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2) !important; 
    }
    .form-control:hover{
        border-color: white;
    }
    .form-control:focus {
        background: #b0b0b0;
        outline: none;
        box-shadow: 0 0 5px rgba(51, 51, 51, 0.5);
    }
    }
</style>
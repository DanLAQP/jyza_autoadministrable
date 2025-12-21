<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CertificadoModulo $certificadoModulo
 * @var \Cake\Collection\CollectionInterface|string[] $certificados
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Certificado Modulos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="certificadoModulos form content">
            <?= $this->Form->create($certificadoModulo) ?>
            <fieldset>
                <legend><?= __('Add Certificado Modulo') ?></legend>
                <?php
                    echo $this->Form->control('certificado_id', ['options' => $certificados]);
                    echo $this->Form->control('titulo');
                    echo $this->Form->control('descripcion');
                    echo $this->Form->control('horas');
                    echo $this->Form->control('posicion');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ContenidosLeccion> $contenidosLeccion
 */
?>

<div class="container mt-4 mb-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="text-info mb-0"><i class="fas fa-file-alt"></i> Contenidos de Lección</h2>
            <?php if (!empty($usuario) && $usuario->rol == 1): ?>
                <?= $this->Html->link('<i class="fas fa-plus"></i> Nuevo Contenido', ['action' => 'add'], ['class' => 'btn btn-primary btn-lg', 'escape' => false]) ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-dark">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Todos los Contenidos</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-dark">
                            <thead class="table-secondary">
                                <tr>
                                    <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                                    <th><?= $this->Paginator->sort('leccion_id', 'Lección') ?></th>
                                    <th><?= $this->Paginator->sort('tipo', 'Tipo') ?></th>
                                    <th><?= $this->Paginator->sort('archivo', 'Archivo') ?></th>
                                    <th><?= $this->Paginator->sort('posicion', 'Posición') ?></th>
                                    <th><?= $this->Paginator->sort('created', 'Creado') ?></th>
                                    <th><?= $this->Paginator->sort('modified', 'Modificado') ?></th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($contenidosLeccion as $contenido): ?>
                                <tr>
                                    <td><?= $this->Number->format($contenido->id) ?></td>
                                    <td><?= $contenido->hasValue('leccione') ? $this->Html->link($contenido->leccione->titulo, ['controller' => 'Lecciones', 'action' => 'view', $contenido->leccione->id]) : '<em class="text-muted">Sin lección</em>' ?></td>
                                    <td>
                                        <?php
                                            $tipoClass = match($contenido->tipo) {
                                                'video' => 'primary',
                                                'texto' => 'info',
                                                'imagen' => 'success',
                                                'quiz' => 'warning',
                                                default => 'secondary'
                                            };
                                            $tipoIcon = match($contenido->tipo) {
                                                'video' => 'film',
                                                'texto' => 'file-alt',
                                                'imagen' => 'image',
                                                'quiz' => 'question-circle',
                                                default => 'file'
                                            };
                                        ?>
                                        <span class="badge bg-<?= $tipoClass ?>">
                                            <i class="fas fa-<?= $tipoIcon ?>"></i> <?= ucfirst(h($contenido->tipo)) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php
                                            $fullPath = $contenido->archivo;
                                            $fileName = basename($fullPath);
                                            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                                            if (strlen($fileName) > 40) {
                                                $base = pathinfo($fileName, PATHINFO_FILENAME);
                                                $short = mb_substr($base, 0, 40);
                                                $fileName = $short . (strlen($base) > 40 ? '...' : '') . ($ext ? ".{$ext}" : '');
                                            }
                                        ?>
                                        <span title="<?= h($fullPath) ?>"><?= h($fileName) ?></span>
                                    </td>
                                    <td><span class="badge bg-secondary"><?= $this->Number->format($contenido->posicion) ?></span></td>
                                    <td><?= h($contenido->created) ?></td>
                                    <td><?= h($contenido->modified) ?></td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <?= $this->Html->link(
                                                '<i class="fas fa-eye"></i>',
                                                ['action' => 'view', $contenido->id],
                                                ['class' => 'btn btn-info', 'title' => 'Ver', 'escape' => false]
                                            ) ?>
                                            <?php if (!empty($usuario) && $usuario->rol == 1): ?>
                                                <?= $this->Html->link(
                                                    '<i class="fas fa-edit"></i>',
                                                    ['action' => 'edit', $contenido->id],
                                                    ['class' => 'btn btn-warning', 'title' => 'Editar', 'escape' => false]
                                                ) ?>
                                                <?= $this->Form->postLink(
                                                    '<i class="fas fa-trash"></i>',
                                                    ['action' => 'delete', $contenido->id],
                                                    ['confirm' => '¿Estás seguro?', 'class' => 'btn btn-danger', 'title' => 'Eliminar', 'escape' => false]
                                                ) ?>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Paginación -->
                    <div class="mt-3">
                        <nav aria-label="Paginación">
                            <ul class="pagination justify-content-center">
                                <?php
                                echo $this->Paginator->first('<i class="fas fa-step-backward"></i> Primera', ['class' => 'page-link']);
                                echo $this->Paginator->prev('<i class="fas fa-chevron-left"></i> Anterior', ['class' => 'page-link']);
                                echo $this->Paginator->numbers(['class' => 'page-link']);
                                echo $this->Paginator->next('Siguiente <i class="fas fa-chevron-right"></i>', ['class' => 'page-link']);
                                echo $this->Paginator->last('Última <i class="fas fa-step-forward"></i>', ['class' => 'page-link']);
                                ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
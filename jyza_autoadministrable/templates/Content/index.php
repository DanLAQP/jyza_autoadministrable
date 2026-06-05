<div class="container">
    <h2>Panel Autoadministrable</h2>
    <p>Gestiona las secciones y bloques de contenido.</p>

    <?php if (empty($contentSections)): ?>
        <div class="alert alert-info">No hay secciones registradas. Puedes crear entradas en la tabla <strong>content_sections</strong>.</div>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Slug</th>
                    <th>Título</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contentSections as $s): ?>
                    <tr>
                        <td><?= h($s->id) ?></td>
                        <td><?= h($s->slug) ?></td>
                        <td><?= h($s->title) ?></td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="<?= $this->Url->build(['controller' => 'Content', 'action' => 'edit', $s->id]) ?>">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

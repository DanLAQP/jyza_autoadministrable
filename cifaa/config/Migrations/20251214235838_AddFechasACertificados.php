<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddFechasACertificados extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('certificados');
        
        $table->addColumn('fecha_inicio', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => true,
            'after' => 'fecha_emision',
            'comment' => 'Fecha de inicio del curso (texto libre)'
        ]);
        
        $table->addColumn('fecha_fin', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => true,
            'after' => 'fecha_inicio',
            'comment' => 'Fecha de finalización del curso (texto libre)'
        ]);
        
        $table->update();
    }
}

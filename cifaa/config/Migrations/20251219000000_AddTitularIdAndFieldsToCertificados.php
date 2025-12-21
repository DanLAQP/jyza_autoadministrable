<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddTitularIdAndFieldsToCertificados extends AbstractMigration
{
    /**
     * Change Method.
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('certificados');
        
        // Agregar columna titular_id como campo simple
        if (!$table->hasColumn('titular_id')) {
            $table->addColumn('titular_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
                'after' => 'user_id',
            ]);
        }
        
        // Agregar otros campos si no existen
        if (!$table->hasColumn('nombre_titular')) {
            $table->addColumn('nombre_titular', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ]);
        }
        
        if (!$table->hasColumn('dni_titular')) {
            $table->addColumn('dni_titular', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ]);
        }
        
        if (!$table->hasColumn('nombre_curso_manual')) {
            $table->addColumn('nombre_curso_manual', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ]);
        }
        
        if (!$table->hasColumn('tipo')) {
            $table->addColumn('tipo', 'string', [
                'default' => 'certificado',
                'limit' => 50,
                'null' => false,
            ]);
        }
        
        if (!$table->hasColumn('nota_final')) {
            $table->addColumn('nota_final', 'decimal', [
                'default' => null,
                'precision' => 5,
                'scale' => 2,
                'null' => true,
            ]);
        }
        
        if (!$table->hasColumn('duracion_meses')) {
            $table->addColumn('duracion_meses', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ]);
        }
        
        if (!$table->hasColumn('fecha_inicio')) {
            $table->addColumn('fecha_inicio', 'date', [
                'default' => null,
                'null' => true,
            ]);
        }
        
        if (!$table->hasColumn('fecha_fin')) {
            $table->addColumn('fecha_fin', 'date', [
                'default' => null,
                'null' => true,
            ]);
        }
        
        if (!$table->hasColumn('nombre_gerente')) {
            $table->addColumn('nombre_gerente', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ]);
        }
        
        if (!$table->hasColumn('modulos')) {
            $table->addColumn('modulos', 'text', [
                'default' => null,
                'null' => true,
            ]);
        }
        
        if (!$table->hasColumn('estado')) {
            $table->addColumn('estado', 'string', [
                'default' => 'activo',
                'limit' => 50,
                'null' => false,
            ]);
        }
        
        $table->update();
    }
}

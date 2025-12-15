<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/**
 * Agrega campos personalizables para certificados:
 * - nombre_completo: Nombre completo del estudiante (puede ser diferente al username)
 * - nota_final: Nota final del curso (decimal 5,2)
 * - duracion_meses: Duración del curso en meses
 * - modulos: JSON con los módulos y sus temas
 */
class AddCamposPersonalizablesACertificados extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('certificados');
        
        $table->addColumn('nombre_completo', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
            'after' => 'user_id',
            'comment' => 'Nombre completo del estudiante para el certificado'
        ]);
        
        $table->addColumn('nota_final', 'decimal', [
            'default' => null,
            'null' => true,
            'precision' => 5,
            'scale' => 2,
            'after' => 'horas',
            'comment' => 'Nota final del curso (0.00 - 20.00)'
        ]);
        
        $table->addColumn('duracion_meses', 'integer', [
            'default' => null,
            'null' => true,
            'after' => 'nota_final',
            'comment' => 'Duración del curso en meses'
        ]);
        
        $table->addColumn('modulos', 'text', [
            'default' => null,
            'null' => true,
            'after' => 'duracion_meses',
            'comment' => 'JSON con módulos y temas del certificado'
        ]);
        
        $table->update();
    }
}

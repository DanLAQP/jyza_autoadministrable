<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddArchivoPdfToCertificados extends AbstractMigration
{
    /**
     * Change Method.
     * 
     * Agrega columnas para el sistema de certificados:
     * 1. archivo_pdf: Ruta relativa del archivo PDF generado (ej: uploads/certificados/certificado_ABC123.pdf)
     * 2. estado: Estado del certificado (activo/anulado) para control administrativo
     * 
     * Nota: Las columnas user_id y curso_id ya existen en la tabla desde la migracion CreateCertificados
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('certificados');
        
        // 1. Columna para almacenar ruta del PDF generado
        $table->addColumn('archivo_pdf', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
            'after' => 'codigo',
            'comment' => 'Ruta relativa del archivo PDF en el servidor (uploads/certificados/...)'
        ]);
        
        // 2. Estado del certificado para control administrativo
        $table->addColumn('estado', 'enum', [
            'default' => 'activo',
            'values' => ['activo', 'anulado'],
            'null' => false,
            'after' => 'archivo_pdf',
            'comment' => 'Estado del certificado: activo (valido) o anulado (revocado)'
        ]);
        
        // Agregar indices para mejorar rendimiento de consultas
        $table->addIndex(['user_id'], ['name' => 'idx_certificados_user_id']);
        $table->addIndex(['curso_id'], ['name' => 'idx_certificados_curso_id']);
        $table->addIndex(['estado'], ['name' => 'idx_certificados_estado']);
        $table->addIndex(['codigo'], ['name' => 'idx_certificados_codigo', 'unique' => true]);
        
        $table->update();
    }
}

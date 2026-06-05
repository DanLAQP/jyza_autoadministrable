<?php
/**
 * CakePHP Database Migration
 * 
 * Crear tablas para el sistema de contenidos autoadministrable
 * 
 * Ejecutar: bin/cake migrations migrate
 */

use Migrations\AbstractMigration;

class CreateContentTables extends AbstractMigration
{
    public function change()
    {
        // Tabla: Secciones de Contenido
        if (!$this->hasTable('content_sections')) {
            $table = $this->table('content_sections', ['id' => false, 'primary_key' => ['id']]);
            
            $table->addColumn('id', 'integer', ['autoIncrement' => true, 'signed' => false])
            ->addColumn('slug', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('title', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('metadata', 'json', ['null' => true, 'default' => null])
            ->addColumn('is_active', 'boolean', ['default' => true])
            ->addColumn('sort_order', 'integer', ['default' => 0])
            ->addColumn('created_by', 'integer', ['null' => true])
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('modified', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['slug'], ['unique' => true])
            ->addIndex(['is_active'])
            ->addIndex(['created_by'])
                ->addForeignKey('created_by', 'users', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
                ->create();
        }

        // Tabla: Bloques de Contenido
        if (!$this->hasTable('content_blocks')) {
            $table = $this->table('content_blocks', ['id' => false, 'primary_key' => ['id']]);
            
            $table->addColumn('id', 'integer', ['autoIncrement' => true, 'signed' => false])
            ->addColumn('section_id', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('block_key', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('block_type', 'string', [
                'limit' => 50,
                'default' => 'text',
                'null' => false,
            ])
            ->addColumn('content', 'text', ['null' => true])
            ->addColumn('metadata', 'json', ['null' => true, 'default' => null])
            ->addColumn('sort_order', 'integer', ['default' => 0])
            ->addColumn('is_active', 'boolean', ['default' => true])
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('modified', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['section_id'])
            ->addIndex(['block_type'])
            ->addIndex(['section_id', 'block_key'], ['unique' => true])
                ->addForeignKey('section_id', 'content_sections', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                ->create();
        }

        // Tabla: Versionado/Historial de Cambios
        if (!$this->hasTable('content_versions')) {
            $table = $this->table('content_versions', ['id' => false, 'primary_key' => ['id']]);
            
            $table->addColumn('id', 'integer', ['autoIncrement' => true, 'signed' => false])
            ->addColumn('block_id', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('content_before', 'text', ['null' => true])
            ->addColumn('content_after', 'text', ['null' => true])
            ->addColumn('change_type', 'string', [
                'limit' => 50,
                'default' => 'updated',
                'null' => false,
            ])
            ->addColumn('changed_by', 'integer', ['null' => false])
            ->addColumn('change_reason', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['block_id'])
            ->addIndex(['changed_by'])
            ->addIndex(['created'])
            ->addForeignKey('block_id', 'content_blocks', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                ->addForeignKey('changed_by', 'users', 'id', ['delete' => 'RESTRICT', 'update' => 'CASCADE'])
                ->create();
        }

        // Tabla: Gestión de Imágenes
        if (!$this->hasTable('content_images')) {
            $table = $this->table('content_images', ['id' => false, 'primary_key' => ['id']]);
            
            $table->addColumn('id', 'integer', ['autoIncrement' => true, 'signed' => false])
            ->addColumn('section_id', 'integer', ['null' => true, 'signed' => false])
            ->addColumn('block_id', 'integer', ['null' => true, 'signed' => false])
            ->addColumn('original_filename', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('stored_filename', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('file_path', 'string', ['limit' => 500, 'null' => false])
            ->addColumn('file_size', 'integer', ['null' => true])
            ->addColumn('mime_type', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('dimensions', 'json', ['null' => true])
            ->addColumn('alt_text', 'string', ['limit' => 500, 'null' => true])
            ->addColumn('title', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('uploaded_by', 'integer', ['null' => false])
            ->addColumn('is_active', 'boolean', ['default' => true])
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('modified', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['section_id'])
            ->addIndex(['block_id'])
            ->addIndex(['uploaded_by'])
            ->addIndex(['stored_filename'], ['unique' => true])
            ->addForeignKey('section_id', 'content_sections', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addForeignKey('block_id', 'content_blocks', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
                ->addForeignKey('uploaded_by', 'users', 'id', ['delete' => 'RESTRICT', 'update' => 'CASCADE'])
                ->create();
        }

        // Tabla: Caché de Compilación
        if (!$this->hasTable('content_cache')) {
            $table = $this->table('content_cache', ['id' => false, 'primary_key' => ['id']]);
            
            $table->addColumn('id', 'integer', ['autoIncrement' => true, 'signed' => false])
            ->addColumn('section_slug', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('cache_data', 'text', ['null' => true])
            ->addColumn('etag', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('expires_at', 'datetime', ['null' => true])
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('modified', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['section_slug'], ['unique' => true])
            ->addIndex(['expires_at'])
                ->create();
        }

        // Tabla: Auditoría (logs de cambios)
        if (!$this->hasTable('audit_logs')) {
            $table = $this->table('audit_logs', ['id' => false, 'primary_key' => ['id']]);
            
            $table->addColumn('id', 'integer', ['autoIncrement' => true, 'signed' => false])
            ->addColumn('entity_type', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('entity_id', 'integer', ['null' => false])
            ->addColumn('action', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('user_id', 'integer', ['null' => true])
            ->addColumn('changes', 'json', ['null' => true])
            ->addColumn('ip_address', 'string', ['limit' => 45, 'null' => true])
            ->addColumn('user_agent', 'text', ['null' => true])
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['entity_type', 'entity_id'])
            ->addIndex(['user_id'])
            ->addIndex(['created'])
                ->addForeignKey('user_id', 'users', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
                ->create();
        }
    }

    public function down()
    {
        $this->dropTable('audit_logs');
        $this->dropTable('content_cache');
        $this->dropTable('content_images');
        $this->dropTable('content_versions');
        $this->dropTable('content_blocks');
        $this->dropTable('content_sections');
    }
}

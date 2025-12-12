<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddStatusToInscripciones extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        /*
        $table = $this->table('inscripciones');
        if (!$table->hasColumn('estado')) {
            $table->addColumn('estado', 'string', [
                'limit' => 20,
                'default' => 'pendiente',
                'comment' => 'Estado de la inscripción: pendiente, aprobada, rechazada'
            ]);
            $table->update();
        }
        */
    }
}

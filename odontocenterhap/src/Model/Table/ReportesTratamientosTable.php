<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class ReportesTratamientosTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('reportes_tratamientos'); // Nombre de la vista en la base de datos
        $this->setPrimaryKey('tratamiento_id');  // Campo que actúa como clave primaria
    }
}

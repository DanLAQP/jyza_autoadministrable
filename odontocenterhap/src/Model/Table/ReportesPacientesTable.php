<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class ReportesPacientesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('reportes_pacientes'); // Nombre de la vista en la base de datos
        $this->setPrimaryKey('paciente_id'); // Define una clave primaria (puede no ser única)
    }
}

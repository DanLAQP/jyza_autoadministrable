<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ReportesOrdenesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        // Indicar que esto es una vista y no una tabla normal
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        
        // Si necesitas asociaciones
        $this->belongsTo('Pacientes', [
            'foreignKey' => 'paciente_id'
        ]);
        
        $this->belongsTo('Doctores', [
            'foreignKey' => 'doctor_id'
        ]);
        $this->belongsTo('OrdenesTratamientos', [
            'foreignKey' => 'orden_id'
        ]);
    }
}
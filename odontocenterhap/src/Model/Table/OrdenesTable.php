<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ordenes Model
 *
 * @property \App\Model\Table\PacientesTable&\Cake\ORM\Association\BelongsTo $Pacientes
 * @property \App\Model\Table\DoctoresTable&\Cake\ORM\Association\BelongsTo $Doctores
 * @property \App\Model\Table\OrdenesTratamientosTable&\Cake\ORM\Association\HasMany $OrdenesTratamientos
 * @property \App\Model\Table\VisitasTable&\Cake\ORM\Association\HasMany $Visitas
 */
class OrdenesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('ordenes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Pacientes', [
            'foreignKey' => 'paciente_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Doctores', [
            'foreignKey' => 'doctor_id',
            'joinType' => 'INNER',
        ]);
      $this->hasMany('OrdenesTratamientos', [
    'foreignKey' => 'orden_id',
    'dependent' => true,
    'cascadeCallbacks' => true,
    'saveStrategy' => 'append'  // Esto permite que agregue nuevos relacionados sin reemplazar
]);

$this->belongsTo('Pacientes1', [
    'foreignKey' => 'paciente_id',
    'joinType' => 'INNER',
]);


        $this->hasMany('Visitas', [
            'foreignKey' => 'orden_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
    }

    public function validationDefault(Validator $validator): Validator
{
    $validator
        ->integer('paciente_id')
        ->notEmptyString('paciente_id');

    $validator
        ->integer('doctor_id')
        ->notEmptyString('doctor_id');

    $validator
        ->decimal('total')
        ->allowEmptyString('total');

    $validator
        ->decimal('saldo')
        ->allowEmptyString('saldo');

    $validator
        ->decimal('monto_laboratorio')
        ->allowEmptyString('monto_laboratorio');

    $validator
        ->decimal('monto_materiales')
        ->allowEmptyString('monto_materiales');

    $validator
        ->decimal('pago_doctor')
        ->allowEmptyString('pago_doctor');

    $validator
        ->decimal('restante_clinica')
        ->allowEmptyString('restante_clinica');

    $validator
        ->scalar('observaciones')
        ->maxLength('observaciones', 1000)
        ->allowEmptyString('observaciones');

    $validator
    ->decimal('porcentaje_doctor')
    ->range('porcentaje_doctor', [0, 1], 'Debe estar entre 0.00 y 1.00')
    ->allowEmptyString('porcentaje_doctor');

    return $validator;
}


    public function buildRules(RulesChecker $rules): RulesChecker
    {
        
        $rules->add($rules->existsIn(['doctor_id'], 'Doctores'), ['errorField' => 'doctor_id']);

        return $rules;
    }
    public function beforeSave(\Cake\Event\EventInterface $event, \Cake\Datasource\EntityInterface $entity, \ArrayObject $options)
{
    if ($entity->saldo !== null) {
        $entity->estado = ($entity->saldo == 0) ? 'cancelado' : 'pendiente';
    }
}

}

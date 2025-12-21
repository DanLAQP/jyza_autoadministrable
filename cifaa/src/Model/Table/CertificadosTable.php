<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Certificados Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\CursosTable&\Cake\ORM\Association\BelongsTo $Cursos
 * @property \App\Model\Table\CertificadoModulosTable&\Cake\ORM\Association\HasMany $CertificadoModulos
 *
 * @method \App\Model\Entity\Certificado newEmptyEntity()
 * @method \App\Model\Entity\Certificado newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Certificado> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Certificado get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Certificado findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Certificado patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Certificado> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Certificado|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Certificado saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Certificado>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Certificado>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Certificado>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Certificado> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Certificado>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Certificado>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Certificado>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Certificado> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CertificadosTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('certificados');
        $this->setDisplayField('codigo');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'usuario_id',
        ]);
        $this->belongsTo('Cursos', [
            'foreignKey' => 'curso_id',
        ]);
        $this->hasMany('CertificadoModulos', [
            'foreignKey' => 'certificado_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('usuario_id')
            ->allowEmptyString('usuario_id');

        $validator
            ->integer('titular_id')
            ->allowEmptyString('titular_id');

        $validator
            ->scalar('nombre_titular')
            ->maxLength('nombre_titular', 255)
            ->allowEmptyString('nombre_titular');

        $validator
            ->scalar('dni_titular')
            ->maxLength('dni_titular', 20)
            ->allowEmptyString('dni_titular');

        $validator
            ->integer('curso_id')
            ->allowEmptyString('curso_id');

        $validator
            ->scalar('nombre_curso_manual')
            ->maxLength('nombre_curso_manual', 255)
            ->allowEmptyString('nombre_curso_manual');

        $validator
            ->scalar('tipo')
            ->maxLength('tipo', 50)
            ->inList('tipo', ['certificado', 'diplomado'])
            ->notEmptyString('tipo');

        $validator
            ->decimal('nota_final')
            ->allowEmptyString('nota_final');

        $validator
            ->integer('horas_lectivas')
            ->requirePresence('horas_lectivas', 'create')
            ->allowEmptyString('horas_lectivas');

        $validator
            ->integer('duracion_meses')
            ->allowEmptyString('duracion_meses');

        $validator
            ->date('fecha_inicio')
            ->allowEmptyDate('fecha_inicio');

        $validator
            ->date('fecha_fin')
            ->allowEmptyDate('fecha_fin');

        $validator
            ->scalar('nombre_gerente')
            ->maxLength('nombre_gerente', 255)
            ->allowEmptyString('nombre_gerente');

        $validator
            ->scalar('codigo')
            ->maxLength('codigo', 50)
            ->requirePresence('codigo', 'create')
            ->notEmptyString('codigo')
            ->add('codigo', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('nombre_completo')
            ->maxLength('nombre_completo', 255)
            ->allowEmptyString('nombre_completo');

        $validator
            ->scalar('modulos')
            ->allowEmptyString('modulos');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['codigo']), ['errorField' => 'codigo']);
        
        // usuario_id es opcional
        $rules->add(
            $rules->existsIn(['usuario_id'], 'Users'),
            ['errorField' => 'usuario_id']
        );
        
        // curso_id es opcional
        $rules->add(
            $rules->existsIn(['curso_id'], 'Cursos'),
            ['errorField' => 'curso_id']
        );

        return $rules;
    }
}

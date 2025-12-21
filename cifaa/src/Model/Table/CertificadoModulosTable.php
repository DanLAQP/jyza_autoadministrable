<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CertificadoModulos Model
 *
 * @property \App\Model\Table\CertificadosTable&\Cake\ORM\Association\BelongsTo $Certificados
 *
 * @method \App\Model\Entity\CertificadoModulo newEmptyEntity()
 * @method \App\Model\Entity\CertificadoModulo newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\CertificadoModulo> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CertificadoModulo get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\CertificadoModulo findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\CertificadoModulo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\CertificadoModulo> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CertificadoModulo|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\CertificadoModulo saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\CertificadoModulo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CertificadoModulo>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CertificadoModulo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CertificadoModulo> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CertificadoModulo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CertificadoModulo>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CertificadoModulo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CertificadoModulo> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CertificadoModulosTable extends Table
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

        $this->setTable('certificado_modulos');
        $this->setDisplayField('titulo');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Certificados', [
            'foreignKey' => 'certificado_id',
            'joinType' => 'INNER',
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
            ->integer('certificado_id')
            ->notEmptyString('certificado_id');

        $validator
            ->scalar('titulo')
            ->maxLength('titulo', 255)
            ->requirePresence('titulo', 'create')
            ->notEmptyString('titulo');

        $validator
            ->scalar('descripcion')
            ->allowEmptyString('descripcion');

        $validator
            ->integer('horas')
            ->allowEmptyString('horas');

        $validator
            ->integer('posicion')
            ->notEmptyString('posicion');

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
        $rules->add($rules->existsIn(['certificado_id'], 'Certificados'), ['errorField' => 'certificado_id']);

        return $rules;
    }
}

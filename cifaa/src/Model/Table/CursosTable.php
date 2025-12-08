<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cursos Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\InscripcionesTable&\Cake\ORM\Association\HasMany $Inscripciones
 * @property \App\Model\Table\ModulosTable&\Cake\ORM\Association\HasMany $Modulos
 *
 * @method \App\Model\Entity\Curso newEmptyEntity()
 * @method \App\Model\Entity\Curso newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Curso> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Curso get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Curso findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Curso patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Curso> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Curso|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Curso saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Curso>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Curso>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Curso>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Curso> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Curso>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Curso>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Curso>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Curso> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CursosTable extends Table
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

        $this->setTable('cursos');
        $this->setDisplayField('titulo');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'usuario_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Inscripciones', [
            'foreignKey' => 'curso_id',
        ]);
        $this->hasMany('Modulos', [
            'foreignKey' => 'curso_id',
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
            ->notEmptyString('usuario_id');

        $validator
            ->scalar('titulo')
            ->maxLength('titulo', 255)
            ->requirePresence('titulo', 'create')
            ->notEmptyString('titulo');

        $validator
            ->scalar('descripcion')
            ->allowEmptyString('descripcion');

        $validator
            ->scalar('miniatura')
            ->maxLength('miniatura', 255)
            ->allowEmptyString('miniatura');

        $validator
            ->scalar('nivel')
            ->maxLength('nivel', 50)
            ->allowEmptyString('nivel');

        $validator
            ->scalar('categoria')
            ->maxLength('categoria', 255)
            ->allowEmptyString('categoria');

        $validator
            ->scalar('estado')
            ->maxLength('estado', 50)
            ->allowEmptyString('estado');

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
        $rules->add($rules->existsIn(['usuario_id'], 'Users'), ['errorField' => 'usuario_id']);

        return $rules;
    }
}

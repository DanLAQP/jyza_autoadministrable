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

        // NUEVA ARQUITECTURA: Certificados pertenecen a TITULARES
        $this->belongsTo('Titulares', [
            'foreignKey' => 'titular_id',
            'joinType' => 'INNER',  // Obligatorio (NOT NULL en DB)
        ]);
        
        $this->belongsTo('Cursos', [
            'foreignKey' => 'curso_id',
            'joinType' => 'LEFT',
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
        // NUEVO: titular_id es obligatorio
        $validator
            ->integer('titular_id')
            ->requirePresence('titular_id', 'create')
            ->notEmptyString('titular_id');

        // DEPRECATED: user_id_legacy es opcional
        $validator
            ->integer('user_id_legacy')
            ->allowEmptyString('user_id_legacy');

        $validator
            ->integer('curso_id')
            ->allowEmptyString('curso_id');

        $validator
            ->scalar('nombre_completo')
            ->maxLength('nombre_completo', 255)
            ->requirePresence('nombre_completo', 'create')
            ->notEmptyString('nombre_completo');

        $validator
            ->scalar('nombre_curso')
            ->maxLength('nombre_curso', 255)
            ->requirePresence('nombre_curso', 'create')
            ->notEmptyString('nombre_curso');

        $validator
            ->integer('horas')
            ->requirePresence('horas', 'create')
            ->notEmptyString('horas');

        $validator
            ->decimal('nota_final')
            ->allowEmptyString('nota_final');

        $validator
            ->integer('duracion_meses')
            ->allowEmptyString('duracion_meses');

        $validator
            ->scalar('fecha_inicio')
            ->maxLength('fecha_inicio', 100)
            ->allowEmptyString('fecha_inicio');

        $validator
            ->scalar('fecha_fin')
            ->maxLength('fecha_fin', 100)
            ->allowEmptyString('fecha_fin');

        $validator
            ->scalar('modulos')
            ->allowEmptyString('modulos');

        $validator
            ->date('fecha_emision')
            ->requirePresence('fecha_emision', 'create')
            ->notEmptyDate('fecha_emision');

        $validator
            ->scalar('codigo')
            ->maxLength('codigo', 50)
            ->requirePresence('codigo', 'create')
            ->notEmptyString('codigo')
            ->add('codigo', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('archivo_pdf')
            ->maxLength('archivo_pdf', 255)
            ->allowEmptyString('archivo_pdf');

        $validator
            ->scalar('estado')
            ->notEmptyString('estado')
            ->inList('estado', ['activo', 'anulado']);

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
        // NUEVO: titular_id debe existir en tabla titulares (obligatorio)
        $rules->add($rules->existsIn(['titular_id'], 'Titulares'), [
            'errorField' => 'titular_id',
            'message' => 'El titular especificado no existe.'
        ]);
        
        // curso_id es opcional, solo validar si está presente
        $rules->add(
            function ($entity, $options) {
                if (empty($entity->curso_id)) {
                    return true;
                }
                return $this->Cursos->exists(['id' => $entity->curso_id]);
            },
            'validCurso',
            [
                'errorField' => 'curso_id',
                'message' => 'El curso especificado no existe'
            ]
        );
        
        // Código debe ser único
        $rules->add($rules->isUnique(['codigo']), [
            'errorField' => 'codigo', 
            'message' => 'Este código de certificado ya existe.'
        ]);

        return $rules;
    }

    /**
     * Validar que solo exista un certificado activo por usuario y curso.
     * Metodo auxiliar para prevenir duplicados.
     * 
     * @param int $userId ID del usuario
     * @param int $cursoId ID del curso
     * @return bool True si no existe certificado activo, False si ya existe
     */
    public function puedeGenerarCertificado($userId, $cursoId): bool
    {
        $count = $this->find()
            ->where([
                'user_id' => $userId,
                'curso_id' => $cursoId,
                'estado' => 'activo'
            ])
            ->count();

        return $count === 0;
    }

    /**
     * Obtener certificado activo de un usuario para un curso especifico.
     * 
     * @param int $userId ID del usuario
     * @param int $cursoId ID del curso
     * @return \App\Model\Entity\Certificado|null
     */
    public function obtenerCertificadoActivo($userId, $cursoId)
    {
        return $this->find()
            ->where([
                'user_id' => $userId,
                'curso_id' => $cursoId,
                'estado' => 'activo'
            ])
            ->first();
    }
}

<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Titulares Model
 *
 * Representa la tabla de titulares - identidad certificable de personas.
 * Esta tabla es independiente de la autenticación del sistema.
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\HasOne $User
 * @property \App\Model\Table\CertificadosTable&\Cake\ORM\Association\HasMany $Certificados
 *
 * @method \App\Model\Entity\Titular newEmptyEntity()
 * @method \App\Model\Entity\Titular newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Titular> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Titular get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Titular findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Titular patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Titular> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Titular|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Titular saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Titular>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Titular>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Titular>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Titular> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Titular>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Titular>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Titular>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Titular> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TitularesTable extends Table
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

        $this->setTable('titulares');
        $this->setDisplayField('nombre_completo');
        $this->setPrimaryKey('id');
        $this->setEntityClass('App\Model\Entity\Titular');

        $this->addBehavior('Timestamp');

        // Un titular puede tener máximo un usuario vinculado
        $this->hasOne('Users', [
            'foreignKey' => 'titular_id',
        ]);

        // Un titular puede tener múltiples certificados
        $this->hasMany('Certificados', [
            'foreignKey' => 'titular_id',
            'dependent' => false, // No eliminar certificados si se elimina titular (RESTRICT en DB)
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
            ->scalar('dni')
            ->maxLength('dni', 20)
            ->requirePresence('dni', 'create')
            ->notEmptyString('dni')
            ->add('dni', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => 'Este DNI ya está registrado.'
            ]);

        $validator
            ->scalar('nombre_completo')
            ->maxLength('nombre_completo', 200)
            ->requirePresence('nombre_completo', 'create')
            ->notEmptyString('nombre_completo', 'El nombre completo es obligatorio');

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
        // DNI debe ser único
        $rules->add($rules->isUnique(['dni'], 'Este DNI ya está registrado.'));

        return $rules;
    }

    /**
     * Buscar titular por DNI
     *
     * @param string $dni DNI a buscar
     * @return \App\Model\Entity\Titular|null
     */
    public function buscarPorDni(string $dni): ?\App\Model\Entity\Titular
    {
        return $this->find()
            ->where(['dni' => $dni])
            ->first();
    }

    /**
     * Buscar o crear titular
     * Si el DNI existe, retorna el titular existente
     * Si no existe, crea uno nuevo con los datos proporcionados
     *
     * @param string $dni DNI del titular
     * @param string $nombreCompleto Nombre completo del titular
     * @return \App\Model\Entity\Titular|null
     */
    public function buscarOCrear(string $dni, string $nombreCompleto): ?\App\Model\Entity\Titular
    {
        // Buscar existente
        $titular = $this->buscarPorDni($dni);
        
        if ($titular) {
            return $titular;
        }

        // Crear nuevo
        $titular = $this->newEntity([
            'dni' => $dni,
            'nombre_completo' => $nombreCompleto
        ]);

        $resultado = $this->save($titular);
        if ($resultado !== false) {
            // Recargar la entidad desde la BD para asegurar el tipo correcto
            return $this->get($resultado->id);
        }

        return null;
    }

    /**
     * Verificar si un titular está vinculado a un usuario
     *
     * @param int $titularId ID del titular
     * @return bool
     */
    public function tieneUsuarioVinculado(int $titularId): bool
    {
        $usuario = $this->Users->find()
            ->where(['titular_id' => $titularId])
            ->first();

        return !empty($usuario);
    }

    /**
     * Obtener estadísticas de un titular
     *
     * @param int $titularId ID del titular
     * @return array
     */
    public function obtenerEstadisticas(int $titularId): array
    {
        $titular = $this->get($titularId, [
            'contain' => ['Users', 'Certificados']
        ]);

        $certificadosActivos = 0;
        $certificadosAnulados = 0;
        $certificados = 0;
        $diplomados = 0;

        if (!empty($titular->certificados)) {
            foreach ($titular->certificados as $cert) {
                // Contar por estado
                if ($cert->estado === 'activo') {
                    $certificadosActivos++;
                } else {
                    $certificadosAnulados++;
                }

                // Contar por tipo
                if (strpos($cert->codigo, 'CER-') === 0) {
                    $certificados++;
                } elseif (strpos($cert->codigo, 'DIP-') === 0) {
                    $diplomados++;
                }
            }
        }

        return [
            'total_certificados' => count($titular->certificados ?? []),
            'certificados_activos' => $certificadosActivos,
            'certificados_anulados' => $certificadosAnulados,
            'tipo_certificado' => $certificados,
            'tipo_diplomado' => $diplomados,
            'tiene_usuario' => !empty($titular->user),
            'username' => $titular->user->username ?? null
        ];
    }

    /**
     * Finder: Titulares sin usuario vinculado
     *
     * @param \Cake\ORM\Query\SelectQuery $query Query object
     * @param array $options Options
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findSinUsuario(SelectQuery $query, array $options = []): SelectQuery
    {
        return $query
            ->leftJoinWith('Users')
            ->where(['Users.id IS' => null]);
    }

    /**
     * Finder: Titulares con usuario vinculado
     *
     * @param \Cake\ORM\Query\SelectQuery $query Query object
     * @param array $options Options
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findConUsuario(SelectQuery $query, array $options = []): SelectQuery
    {
        return $query
            ->innerJoinWith('Users')
            ->where(['Users.id IS NOT' => null]);
    }

    /**
     * Finder: Titulares con DNI temporal
     *
     * @param \Cake\ORM\Query\SelectQuery $query Query object
     * @param array $options Options
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findConDniTemporal(SelectQuery $query, array $options = []): SelectQuery
    {
        return $query->where(['dni LIKE' => 'TEMP-%']);
    }
}

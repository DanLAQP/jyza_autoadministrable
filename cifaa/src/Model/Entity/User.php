<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher;

/**
 * User Entity
 *
 * NUEVA ARQUITECTURA: Usuarios se vinculan a TITULARES (opcional para admin, obligatorio para estudiantes)
 *
 * @property int $id
 * @property int|null $titular_id FK a titulares (identidad certificable)
 * @property string $username
 * @property string $password
 * @property int $rol 1=admin, 2=docente, 3=estudiante
 * @property string $dni
 * @property string $estado activo/inactivo
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Titular|null $titular Titular vinculado (heredar certificados)
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'titular_id' => true,  // NUEVO - Vinculación a titular
        'username' => true,
        'password' => true,
        'rol' => true,
        'dni' => true,
        'nombre_completo' => true,  // Campo temporal para crear titular
        'estado' => true,
        'created' => true,
        'modified' => true,
        'titular' => true,  // NUEVO - Relación
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var list<string>
     */
    protected array $_hidden = [
        'password',
    ];
    protected function _setPassword(string $password): string
    {
        return (new DefaultPasswordHasher())->hash($password);
    }
}

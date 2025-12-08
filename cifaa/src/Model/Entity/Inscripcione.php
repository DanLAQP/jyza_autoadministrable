<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Inscripcione Entity
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $curso_id
 * @property int|null $progreso
 * @property string $estado
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Curso $curso
 */
class Inscripcione extends Entity
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
        'usuario_id' => true,
        'curso_id' => true,
        'progreso' => true,
        'estado' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'curso' => true,
    ];
}

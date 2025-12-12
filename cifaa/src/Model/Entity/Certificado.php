<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Certificado Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $curso_id
 * @property int $horas
 * @property \Cake\I18n\Date $fecha_emision
 * @property string $codigo
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Curso $curso
 */
class Certificado extends Entity
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
        'user_id' => true,
        'curso_id' => true,
        'horas' => true,
        'fecha_emision' => true,
        'codigo' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'curso' => true,
    ];
}

<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EnfermedadesActuale Entity
 *
 * @property int $id
 * @property int|null $paciente_id
 * @property string|null $enfermedad
 * @property string|null $tiempo_enfermedad
 * @property string|null $sintomas_principales
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Paciente $paciente
 */
class EnfermedadesActuales extends Entity
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
        'paciente_id' => true,
        'enfermedad' => true,
        'tiempo_enfermedad' => true,
        'sintomas_principales' => true,
        'created' => true,
        'modified' => true,
        'paciente' => true,
    ];
}

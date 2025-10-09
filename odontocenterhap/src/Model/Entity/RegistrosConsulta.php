<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RegistrosConsulta Entity
 *
 * @property int $id
 * @property int $paciente_id
 * @property int $doctor_id
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property string|null $observaciones
 * @property string $estado
 * @property string $tipo_pago
 *
 * @property \App\Model\Entity\Paciente $paciente
 * @property \App\Model\Entity\Doctore $doctore
 * @property \App\Model\Entity\ConsultasTratamiento[] $consultas_tratamientos
 */
class RegistrosConsulta extends Entity
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
        'doctor_id' => true,
        'created' => true,
        'modified' => true,
        'observaciones' => true,
        'estado' => true,
        'tipo_pago' => true,
        'paciente' => true,
        'doctore' => true,
        'consultas_tratamientos' => true,
    ];
}

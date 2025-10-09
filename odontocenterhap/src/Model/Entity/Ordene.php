<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Ordene Entity
 *
 * @property int $id
 * @property int $paciente_id
 * @property int $doctor_id
 * @property string|null $total
 * @property string|null $saldo
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Paciente $paciente
 * @property \App\Model\Entity\Doctor $doctor
 * @property \App\Model\Entity\Tratamiento[] $tratamientos
 */
class Ordene extends Entity
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
    'total' => true,
    'saldo' => true,
    'monto_laboratorio' => true,
    'monto_materiales' => true,
    'pago_doctor' => true,
    'restante_clinica' => true,
    'observaciones' => true,
    'created' => true,
    'modified' => true,
    'paciente' => true,
    'doctor' => true,
    'ordenes_tratamientos' => true,
    'visitas' => true,
    'porcentaje_doctor' => true,
    'estado' => true,
];



}

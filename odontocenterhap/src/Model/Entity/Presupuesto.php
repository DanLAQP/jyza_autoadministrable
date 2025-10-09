<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Presupuesto Entity
 *
 * @property int $id
 * @property int|null $paciente_id
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 * @property string|null $total
 * @property string|null $notas
 * @property string|null $tipo_de_cambio
 *
 * @property \App\Model\Entity\Paciente $paciente
 * @property \App\Model\Entity\PresupuestosTratamiento[] $presupuestos_tratamientos
 */
class Presupuesto extends Entity
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
        'created' => true,
        'modified' => true,
        'total' => true,
        'notas' => true,
        'tipo_de_cambio' => true,
        'paciente' => true,
        'presupuestos_tratamientos' => true,
    ];
}

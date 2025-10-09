<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PresupuestosTratamiento Entity
 *
 * @property int $id
 * @property int $presupuesto_id
 * @property int $tratamiento_id
 * @property string $precio_unitario
 * @property int $cantidad
 * @property string $total
 * @property \Cake\I18n\DateTime $modified
 * @property \Cake\I18n\DateTime $created
 *
 * @property \App\Model\Entity\Presupuesto $presupuesto
 * @property \App\Model\Entity\Tratamiento $tratamiento
 */
class PresupuestosTratamiento extends Entity
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
        'presupuesto_id' => true,
        'tratamiento_id' => true,
        'precio_unitario' => true,
        'cantidad' => true,
        'total' => true,
        'modified' => true,
        'created' => true,
        'presupuesto' => true,
        'tratamiento' => true,
    ];
}

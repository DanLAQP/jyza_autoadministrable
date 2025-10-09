<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrdenesTratamiento Entity
 *
 * @property int $id
 * @property int $orden_id
 * @property int $tratamiento_id
 * @property int $cantidad
 * @property string $precio_unitario
 * @property string $subtotal
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Ordene $ordene
 * @property \App\Model\Entity\Tratamiento $tratamiento
 */
class OrdenesTratamiento extends Entity
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
        'orden_id' => true,
        'tratamiento_id' => true,
        'cantidad' => true,
        'precio_unitario' => true,
        'subtotal' => true,
        'created' => true,
        'modified' => true,
        'ordene' => true,
        'tratamiento' => true,
    ];
}

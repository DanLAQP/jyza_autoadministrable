<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Visita Entity
 *
 * @property int $id
 * @property int $orden_id
 * @property string $tipo_pago
 * @property string $abonado
 * @property \Cake\I18n\DateTime|null $fecha_entrega
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Ordene $ordene
 */
class Visita extends Entity
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
        'tipo_pago' => true,
        'abonado' => true,
        'fecha_entrega' => true,
        'created' => true,
        'modified' => true,
        'ordene' => true,
    ];
}

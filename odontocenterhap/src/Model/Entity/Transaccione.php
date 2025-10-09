<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Transaccione Entity
 *
 * @property int $id
 * @property int $producto_id
 * @property string $tipo_transaccion
 * @property int $cantidad
 * @property \Cake\I18n\DateTime $fecha_transaccion
 * @property int $user_id
 * @property string|null $notas
 *
 * @property \App\Model\Entity\Producto $producto
 * @property \App\Model\Entity\User $user
 */
class Transaccione extends Entity
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
        'producto_id' => true,
        'tipo_transaccion' => true,
        'cantidad' => true,
        'fecha_transaccion' => true,
        'user_id' => true,
        'notas' => true,
        'producto' => true,
        'user' => true,
    ];
}

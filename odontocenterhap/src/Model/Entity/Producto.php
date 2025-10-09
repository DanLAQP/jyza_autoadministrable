<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Producto Entity
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property int $categoria_id
 * @property int|null $cantidad
 * @property string $precio
 * @property int $proveedor_id
 * @property \Cake\I18n\Date|null $fecha_vencimiento
 * @property \Cake\I18n\Date $fecha_ingreso
 * @property string|null $ubicacion
 * @property int|null $stock_minimo
 * @property string|null $estado
 *
 * @property \App\Model\Entity\Categoria $categoria
 * @property \App\Model\Entity\Proveedore $proveedore
 * @property \App\Model\Entity\Transaccione[] $transacciones
 */
class Producto extends Entity
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
        'nombre' => true,
        'descripcion' => true,
        'categoria_id' => true,
        'cantidad' => true,
        'precio' => true,
        'proveedor_id' => true,
        'fecha_vencimiento' => true,
        'fecha_ingreso' => true,
        'ubicacion' => true,
        'stock_minimo' => true,
        'estado' => true,
        'categoria' => true,
        'proveedore' => true,
        'transacciones' => true,
    ];
}

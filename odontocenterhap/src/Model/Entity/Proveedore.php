<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Proveedore Entity
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $contacto_nombre
 * @property string|null $contacto_email
 * @property string|null $contacto_telefono
 * @property string|null $direccion
 */
class Proveedore extends Entity
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
        'contacto_nombre' => true,
        'contacto_email' => true,
        'contacto_telefono' => true,
        'direccion' => true,
    ];
}

<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContenidosLeccion Entity
 *
 * @property int $id
 * @property int $leccion_id
 * @property string $tipo
 * @property string|null $contenido
 * @property string|null $descripcion
 * @property string|null $archivo
 * @property int $posicion
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Leccione $leccione
 */
class ContenidosLeccion extends Entity
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
        'leccion_id' => true,
        'tipo' => true,
        'contenido' => true,
        'descripcion' => true,
        'archivo' => true,
        'posicion' => true,
        'created' => true,
        'modified' => true,
        'leccione' => true,
        'link_externo' => true,
    ];
}

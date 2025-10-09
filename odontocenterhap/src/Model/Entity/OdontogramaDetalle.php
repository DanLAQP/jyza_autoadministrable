<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OdontogramaDetalle Entity
 *
 * @property int $id
 * @property int $odontograma_id
 * @property string|null $especificaciones
 * @property string|null $observaciones
 * @property \Cake\I18n\DateTime $created_at
 * @property \Cake\I18n\DateTime $updated_at
 *
 * @property \App\Model\Entity\Odontograma $odontograma
 */
class OdontogramaDetalle extends Entity
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
        'odontograma_id' => true,
        'especificaciones' => true,
        'observaciones' => true,
        'created_at' => true,
        'updated_at' => true,
        'odontograma' => true,
    ];
}

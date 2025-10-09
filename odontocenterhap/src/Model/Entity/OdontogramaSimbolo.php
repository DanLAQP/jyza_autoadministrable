<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OdontogramaSimbolo Entity
 *
 * @property int $id
 * @property int $odontograma_id
 * @property int $simbolo_id
 * @property int|null $posicion_x
 * @property int|null $posicion_y
 * @property \Cake\I18n\DateTime $created_at
 * @property \Cake\I18n\DateTime $updated_at
 *
 * @property \App\Model\Entity\Odontograma $odontograma
 * @property \App\Model\Entity\Simbolo $simbolo
 */
class OdontogramaSimbolo extends Entity
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
        'simbolo_id' => true,
        'posicion_x' => true,
        'posicion_y' => true,
        'created_at' => true,
        'updated_at' => true,
        'diente_id' => true,
        'odontograma' => true,
        'simbolo' => true,
    ];
}

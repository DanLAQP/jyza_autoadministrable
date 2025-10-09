<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Odontograma Entity
 *
 * @property int $id
 * @property int $paciente_id
 * @property \Cake\I18n\DateTime $created_at
 * @property \Cake\I18n\DateTime $updated_at
 *
 * @property \App\Model\Entity\Paciente $paciente
 * @property \App\Model\Entity\Diente $diente
 * @property \App\Model\Entity\Simbolo[] $simbolos
 * @property \App\Model\Entity\OdontogramaSimbolo[] $odontograma_simbolos
 */
class Odontograma extends Entity
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
        'created_at' => true,
        'updated_at' => true,
        'paciente' => true,
        'diente' => true,
        'simbolos' => true,
        'odontograma_simbolos' => true,
        'tipo' => true,
        'titulo' => true,
    ];
}

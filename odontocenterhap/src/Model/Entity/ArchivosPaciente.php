<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ArchivosPaciente Entity
 *
 * @property int $id
 * @property int $paciente_id
 * @property string $tipo
 * @property string $ruta_archivo
 * @property string|null $descripcion
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Paciente $paciente
 */
class ArchivosPaciente extends Entity
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
        'tipo' => true,
        'ruta_archivo' => true,
        'descripcion' => true,
        'created' => true,
        'modified' => true,
        'paciente' => true,
    ];
}

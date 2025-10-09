<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContactosEmergencium Entity
 *
 * @property int $id
 * @property int|null $paciente_id
 * @property string|null $medico_confianza
 * @property string|null $servicio_ambulancia
 * @property string|null $nombre_contacto
 * @property string|null $telefono_contacto
 *
 * @property \App\Model\Entity\Paciente $paciente
 */
class ContactosEmergencium extends Entity
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
        'medico_confianza' => true,
        'servicio_ambulancia' => true,
        'nombre_contacto' => true,
        'telefono_contacto' => true,
        'paciente' => true,
    ];
}

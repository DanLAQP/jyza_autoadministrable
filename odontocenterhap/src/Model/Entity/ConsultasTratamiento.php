<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ConsultasTratamiento Entity
 *
 * @property int $id
 * @property int $registro_id
 * @property int $tratamiento_id
 * @property string $costo
 * @property string $monto_clinica
 * @property string $monto_doctor
 * @property string $monto_materiales
 * @property int $cantidad
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\RegistrosConsulta $registros_consulta
 * @property \App\Model\Entity\Tratamiento $tratamiento
 */
class ConsultasTratamiento extends Entity
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
        'registro_id' => true,
        'tratamiento_id' => true,
        'costo' => true,
        'monto_clinica' => true,
        'monto_doctor' => true,
        'monto_materiales' => true,
        'cantidad' => true,
        'created' => true,
        'modified' => true,
        'registros_consulta' => true,
        'tratamiento' => true,
    ];
}

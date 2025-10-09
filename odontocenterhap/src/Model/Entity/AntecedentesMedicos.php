<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AntecedentesMedicos Entity
 *
 * @property int $id
 * @property int|null $paciente_id
 * @property string|null $alergias
 * @property string|null $medicacion
 * @property string|null $nombre_medico
 * @property string|null $telefono_medico
 * @property string|null $hepatitis
 * @property string|null $tipo_hepatitis
 * @property string|null $diabetes
 * @property string|null $diabetes_estado
 * @property string|null $condicion_cardiaca
 * @property string|null $tratamiento_cardiaco
 * @property string|null $presion_alta
 * @property string|null $enfermedad_riesgo
 * @property string|null $estado_gestacion
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Paciente $paciente
 */
class AntecedentesMedicos extends Entity
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
        'alergias' => true,
        'medicacion' => true,
        'nombre_medico' => true,
        'telefono_medico' => true,
        'hepatitis' => true,
        'tipo_hepatitis' => true,
        'diabetes' => true,
        'diabetes_estado' => true,
        'condicion_cardiaca' => true,
        'tratamiento_cardiaco' => true,
        'presion_alta' => true,
        'enfermedad_riesgo' => true,
        'estado_gestacion' => true,
        'created' => true,
        'modified' => true,
        'paciente' => true,
    ];
}

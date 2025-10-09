<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AntecedentesOdontologico Entity
 *
 * @property int $id
 * @property int|null $paciente_id
 * @property string|null $motivo_consulta
 * @property string|null $frecuencia_visita
 * @property string|null $experiencia_traumatica
 * @property string|null $extracciones_dentales
 * @property string|null $complicaciones_anestesia
 * @property string|null $sangrado_encias
 * @property \Cake\I18n\Date|null $fecha_ultima_profilaxis
 * @property string|null $dolor_mandibula
 * @property string|null $satisfaccion_dental
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Paciente $paciente
 */
class AntecedentesOdontologico extends Entity
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
        'motivo_consulta' => true,
        'frecuencia_visita' => true,
        'experiencia_traumatica' => true,
        'extracciones_dentales' => true,
        'complicaciones_anestesia' => true,
        'sangrado_encias' => true,
        'fecha_ultima_profilaxis' => true,
        'dolor_mandibula' => true,
        'satisfaccion_dental' => true,
        'created' => true,
        'modified' => true,
        'paciente' => true,
    ];
}

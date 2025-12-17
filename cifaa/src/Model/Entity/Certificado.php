<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Certificado Entity
 *
 * NUEVA ARQUITECTURA: Los certificados pertenecen a TITULARES, no a USERS
 *
 * @property int $id
 * @property int $titular_id Nueva FK a titulares (identidad certificable)
 * @property int|null $user_id_legacy DEPRECATED - Mantener solo para referencia histórica
 * @property int|null $curso_id
 * @property string|null $nombre_completo Snapshot del nombre del titular
 * @property string|null $nombre_curso Snapshot del nombre del curso
 * @property int $horas
 * @property float|null $nota_final
 * @property int|null $duracion_meses
 * @property string|null $fecha_inicio
 * @property string|null $fecha_fin
 * @property string|null $modulos JSON con módulos del curso
 * @property \Cake\I18n\Date $fecha_emision
 * @property string $codigo CER-YYYY-XXXX o DIP-YYYY-XXXX
 * @property string|null $archivo_pdf
 * @property string $estado activo/anulado
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Titular $titular Titular certificado (OBLIGATORIO)
 * @property \App\Model\Entity\Curso $curso
 */
class Certificado extends Entity
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
        'titular_id' => true,  // NUEVO - Obligatorio
        'user_id_legacy' => true,  // DEPRECATED
        'curso_id' => true,
        'nombre_completo' => true,
        'nombre_curso' => true,
        'horas' => true,
        'nota_final' => true,
        'duracion_meses' => true,
        'fecha_inicio' => true,
        'fecha_fin' => true,
        'modulos' => true,
        'fecha_emision' => true,
        'codigo' => true,
        'archivo_pdf' => true,
        'estado' => true,
        'created' => true,
        'modified' => true,
        'titular' => true,  // NUEVO
        'curso' => true,
    ];
}

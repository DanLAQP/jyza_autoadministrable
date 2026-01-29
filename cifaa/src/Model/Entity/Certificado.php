<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Certificado Entity
 *
 * @property int $id
 * @property int|null $usuario_id
 * @property int|null $titular_id
 * @property string|null $nombre_titular
 * @property string|null $dni_titular
 * @property int|null $curso_id
 * @property string|null $nombre_curso_manual
 * @property string $tipo
 * @property string|null $nota_final
 * @property int $horas
 * @property int|null $duracion_meses
 * @property string|null $fecha_inicio
 * @property string|null $fecha_fin
 * @property string|null $nombre_gerente
 * @property string $codigo
 * @property string|null $nombre_completo
 * @property string|null $modulos
 * @property string|null $archivo_ruta
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Titular $titular
 * @property \App\Model\Entity\Curso $curso
 * @property \App\Model\Entity\CertificadoModulo[] $certificado_modulos
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
        'usuario_id' => true,
        'titular_id' => true,
        'nombre_titular' => true,
        'dni_titular' => true,
        'curso_id' => true,
        'nombre_curso_manual' => true,
        'tipo' => true,
        'nota_final' => true,
        'horas_lectivas' => true,
        'duracion_meses' => true,
        'fecha_inicio' => true,
        'fecha_fin' => true,
        'nombre_gerente' => true,
        'codigo' => true,
        'nombre_completo' => true,
        'modulos' => true,
        'archivo_ruta' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'titular' => true,
        'curso' => true,
        'certificado_modulos' => true,
    ];
}

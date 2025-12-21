<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CertificadoModulo Entity
 *
 * @property int $id
 * @property int $certificado_id
 * @property string $titulo
 * @property string|null $descripcion
 * @property int|null $horas
 * @property int $posicion
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Certificado $certificado
 */
class CertificadoModulo extends Entity
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
        'certificado_id' => true,
        'titulo' => true,
        'descripcion' => true,
        'horas' => true,
        'posicion' => true,
        'created' => true,
        'modified' => true,
        'certificado' => true,
    ];
}

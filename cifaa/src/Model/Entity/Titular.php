<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Titular Entity
 *
 * Representa la identidad certificable de una persona física.
 * Esta entidad es independiente del sistema de usuarios (autenticación).
 * Un titular puede existir sin tener un usuario en el sistema.
 *
 * @property int $id
 * @property string $dni
 * @property string $nombre_completo
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\User|null $user Usuario vinculado (opcional)
 * @property \App\Model\Entity\Certificado[] $certificados Lista de certificados emitidos
 */
class Titular extends Entity
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
        'dni' => true,
        'nombre_completo' => true,
        'created' => true,
        'modified' => true,
        // Relaciones
        'user' => true,
        'certificados' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var list<string>
     */
    protected array $_hidden = [];

    /**
     * Virtual field: tiene_usuario
     * Indica si el titular está vinculado a un usuario del sistema
     *
     * @return bool
     */
    protected function _getTieneUsuario(): bool
    {
        return !empty($this->user);
    }

    /**
     * Virtual field: total_certificados
     * Retorna el número de certificados emitidos (si la relación está cargada)
     *
     * @return int
     */
    protected function _getTotalCertificados(): int
    {
        if (isset($this->certificados) && is_array($this->certificados)) {
            return count($this->certificados);
        }
        return 0;
    }
}

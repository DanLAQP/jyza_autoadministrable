<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Curso Entity
 *
 * @property int $id
 * @property int $usuario_id
 * @property string $titulo
 * @property string|null $descripcion
 * @property string|null $miniatura
 * @property string|null $nivel
 * @property string|null $categoria
 * @property string|null $estado
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Inscripcione[] $inscripciones
 * @property \App\Model\Entity\Modulo[] $modulos
 */
class Curso extends Entity
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
        'titulo' => true,
        'descripcion' => true,
        'miniatura' => true,
        'nivel' => true,
        'categoria' => true,
        'estado' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'inscripciones' => true,
        'modulos' => true,
    ];
}

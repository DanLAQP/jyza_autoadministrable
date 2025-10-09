<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Paciente Entity
 *
 * @property int $id
 * @property int|null $paciente_id
 * @property string|null $dni
 * @property string|null $ruc
 * @property \Cake\I18n\Date|null $fecha_nacimiento
 * @property string|null $sexo
 * @property int|null $edad
 * @property string|null $nombre_apoderado
 * @property string|null $parentesco_apoderado
 * @property string|null $direccion
 * @property string|null $distrito
 * @property string|null $codigo_postal
 * @property string|null $email
 * @property string|null $telefono_oficina
 * @property string|null $centro_trabajo
 * @property string|null $centro_estudio
 * @property string|null $recomendacion
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\AntecedentesMedico[] $antecedentes_medicos
 * @property \App\Model\Entity\AntecedentesOdontologico[] $antecedentes_odontologicos
 * @property \App\Model\Entity\ContactosEmergencium[] $contactos_emergencia
 * @property \App\Model\Entity\EnfermedadesActuale[] $enfermedades_actuales
 * @property \App\Model\Entity\EstadosCuenta[] $estados_cuentas
 * @property \App\Model\Entity\Presupuesto[] $presupuestos
 * @property \App\Model\Entity\RegistrosTratamiento[] $registros_tratamientos
 */
class Paciente extends Entity
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
        'dni' => true,
        'ruc' => true,
        'fecha_nacimiento' => true,
        'sexo' => true,
        'edad' => true,
        'nombre_apoderado' => true,
        'parentesco_apoderado' => true,
        'direccion' => true,
        'distrito' => true,
        'codigo_postal' => true,
        'email' => true,
        'telefono_oficina' => true,
        'centro_trabajo' => true,
        'centro_estudio' => true,
        'recomendacion' => true,
        'created' => true,
        'modified' => true,
        'antecedentes_medicos' => true,
        'antecedentes_odontologicos' => true,
        'contactos_emergencia' => true,
        'enfermedades_actuales' => true,
        'estados_cuentas' => true,
        'presupuestos' => true,
        'registros_tratamientos' => true,
    ];
}

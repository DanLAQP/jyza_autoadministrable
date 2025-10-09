<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AntecedentesMedicosFixture
 */
class AntecedentesMedicosFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'paciente_id' => 1,
                'alergias' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'medicacion' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'nombre_medico' => 'Lorem ipsum dolor sit amet',
                'telefono_medico' => 'Lorem ipsum dolor ',
                'hepatitis' => 'Lorem ipsum dolor sit amet',
                'tipo_hepatitis' => 'Lorem ipsum dolor sit amet',
                'diabetes' => 'Lorem ipsum dolor sit amet',
                'diabetes_estado' => 'Lorem ipsum dolor sit amet',
                'condicion_cardiaca' => 'Lorem ipsum dolor sit amet',
                'tratamiento_cardiaco' => 'Lorem ipsum dolor sit amet',
                'presion_alta' => 'Lorem ipsum dolor sit amet',
                'enfermedad_riesgo' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'estado_gestacion' => 'Lorem ipsum dolor sit amet',
                'created' => '2024-12-15 17:32:02',
                'modified' => '2024-12-15 17:32:02',
            ],
        ];
        parent::init();
    }
}

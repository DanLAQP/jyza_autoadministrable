<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PacientesFixture
 */
class PacientesFixture extends TestFixture
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
                'nombre' => 'Lorem ipsum dolor sit amet',
                'apellido' => 'Lorem ipsum dolor sit amet',
                'dni' => 'Lorem ipsum dolor ',
                'ruc' => 1,
                'fecha_nacimiento' => '2024-12-16',
                'sexo' => 'Lorem ipsum d',
                'edad' => 1,
                'nombre_apoderado' => 'Lorem ipsum dolor sit amet',
                'parentesco_apoderado' => 'Lorem ipsum dolor ',
                'direccion' => 'Lorem ipsum dolor sit amet',
                'distrito' => 'Lorem ipsum dolor sit amet',
                'codigo_postal' => 'Lorem ip',
                'email' => 'Lorem ipsum dolor sit amet',
                'telefono_oficina' => 'Lorem ipsum dolor ',
                'telefono_celular' => 'Lorem ipsum dolor ',
                'centro_trabajo' => 'Lorem ipsum dolor sit amet',
                'centro_estudio' => 'Lorem ipsum dolor sit amet',
                'created' => '2024-12-16 22:01:38',
                'modified' => '2024-12-16 22:01:38',
                'odontograma' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            ],
        ];
        parent::init();
    }
}

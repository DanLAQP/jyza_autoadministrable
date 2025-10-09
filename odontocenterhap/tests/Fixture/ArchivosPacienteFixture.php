<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ArchivosPacienteFixture
 */
class ArchivosPacienteFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'archivos_paciente';
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
                'tipo' => '',
                'ruta_archivo' => 'Lorem ipsum dolor sit amet',
                'descripcion' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2025-01-10 12:27:04',
                'modified' => '2025-01-10 12:27:04',
            ],
        ];
        parent::init();
    }
}

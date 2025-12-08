<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ContenidosLeccionFixture
 */
class ContenidosLeccionFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'contenidos_leccion';
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
                'leccion_id' => 1,
                'tipo' => 'Lorem ipsum dolor sit amet',
                'contenido' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'archivo' => 'Lorem ipsum dolor sit amet',
                'posicion' => 1,
                'created' => '2025-12-08 00:37:59',
                'modified' => '2025-12-08 00:37:59',
            ],
        ];
        parent::init();
    }
}

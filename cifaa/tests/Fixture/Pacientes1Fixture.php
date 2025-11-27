<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * Pacientes1Fixture
 */
class Pacientes1Fixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'pacientes1';
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
                'telefono_celular' => 'Lorem ip',
                'created' => '2025-05-14 21:33:37',
                'modified' => '2025-05-14 21:33:37',
            ],
        ];
        parent::init();
    }
}

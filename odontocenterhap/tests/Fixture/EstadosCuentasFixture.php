<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EstadosCuentasFixture
 */
class EstadosCuentasFixture extends TestFixture
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
                'saldo_actual' => 1.5,
                'created' => '2024-11-06 13:05:05',
                'modified' => '2024-11-06 13:05:05',
            ],
        ];
        parent::init();
    }
}

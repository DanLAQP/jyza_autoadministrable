<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RegistrosConsultasFixture
 */
class RegistrosConsultasFixture extends TestFixture
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
                'doctor_id' => 1,
                'created' => '2025-02-01 18:20:12',
                'modified' => '2025-02-01 18:20:12',
                'observaciones' => 'Lorem ipsum dolor sit amet',
                'estado' => '',
                'tipo_pago' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}

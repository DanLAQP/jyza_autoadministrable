<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ConsultasTratamientosFixture
 */
class ConsultasTratamientosFixture extends TestFixture
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
                'registro_id' => 1,
                'tratamiento_id' => 1,
                'costo' => 1.5,
                'monto_clinica' => 1.5,
                'monto_doctor' => 1.5,
                'monto_materiales' => 1.5,
                'cantidad' => 1,
                'created' => '2025-02-01 10:50:58',
                'modified' => '2025-02-01 10:50:58',
            ],
        ];
        parent::init();
    }
}

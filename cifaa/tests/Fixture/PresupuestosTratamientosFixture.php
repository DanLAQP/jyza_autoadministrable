<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PresupuestosTratamientosFixture
 */
class PresupuestosTratamientosFixture extends TestFixture
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
                'presupuesto_id' => 1,
                'tratamiento_id' => 1,
                'cantidad' => 1,
                'total' => 1.5,
                'created' => '2024-12-12 21:59:45',
                'modified' => '2024-12-12 21:59:45',
            ],
        ];
        parent::init();
    }
}

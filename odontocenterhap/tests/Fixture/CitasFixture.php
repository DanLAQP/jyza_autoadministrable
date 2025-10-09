<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CitasFixture
 */
class CitasFixture extends TestFixture
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
                'fecha_hora' => '2025-01-01 00:41:29',
                'estado' => 'Lorem ipsum dolor sit amet',
                'created_at' => 1735710089,
                'updated_at' => 1735710089,
            ],
        ];
        parent::init();
    }
}

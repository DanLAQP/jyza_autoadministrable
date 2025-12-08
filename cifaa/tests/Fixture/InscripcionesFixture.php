<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InscripcionesFixture
 */
class InscripcionesFixture extends TestFixture
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
                'usuario_id' => 1,
                'curso_id' => 1,
                'progreso' => 1,
                'created' => '2025-12-08 00:38:05',
                'modified' => '2025-12-08 00:38:05',
            ],
        ];
        parent::init();
    }
}

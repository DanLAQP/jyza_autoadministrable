<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ModulosFixture
 */
class ModulosFixture extends TestFixture
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
                'curso_id' => 1,
                'titulo' => 'Lorem ipsum dolor sit amet',
                'posicion' => 1,
                'created' => '2025-12-08 00:37:44',
                'modified' => '2025-12-08 00:37:44',
            ],
        ];
        parent::init();
    }
}

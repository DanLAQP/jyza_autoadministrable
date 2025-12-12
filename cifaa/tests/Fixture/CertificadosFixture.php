<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CertificadosFixture
 */
class CertificadosFixture extends TestFixture
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
                'user_id' => 1,
                'curso_id' => 1,
                'horas' => 1,
                'fecha_emision' => '2025-12-12',
                'codigo' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-12-12 00:33:22',
                'modified' => '2025-12-12 00:33:22',
            ],
        ];
        parent::init();
    }
}

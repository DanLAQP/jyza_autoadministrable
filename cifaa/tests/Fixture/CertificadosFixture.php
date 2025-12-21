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
                'usuario_id' => 1,
                'nombre_titular' => 'Lorem ipsum dolor sit amet',
                'dni_titular' => 'Lorem ipsum dolor ',
                'curso_id' => 1,
                'nombre_curso_manual' => 'Lorem ipsum dolor sit amet',
                'tipo' => 'Lorem ipsum dolor sit amet',
                'nota_final' => 1.5,
                'horas_lectivas' => 1,
                'duracion_meses' => 1,
                'fecha_inicio' => '2025-12-19',
                'fecha_fin' => '2025-12-19',
                'nombre_gerente' => 'Lorem ipsum dolor sit amet',
                'codigo' => 'Lorem ipsum dolor sit amet',
                'estado' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-12-19 14:34:27',
                'modified' => '2025-12-19 14:34:27',
            ],
        ];
        parent::init();
    }
}

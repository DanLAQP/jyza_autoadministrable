<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ContactosEmergenciaFixture
 */
class ContactosEmergenciaFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'contactos_emergencia';
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
                'medico_confianza' => 'Lorem ipsum dolor sit amet',
                'servicio_ambulancia' => 'Lorem ipsum dolor sit amet',
                'nombre_contacto' => 'Lorem ipsum dolor sit amet',
                'telefono_contacto' => 'Lorem ipsum dolor ',
            ],
        ];
        parent::init();
    }
}

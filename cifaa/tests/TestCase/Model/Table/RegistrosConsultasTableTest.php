<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RegistrosConsultasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RegistrosConsultasTable Test Case
 */
class RegistrosConsultasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RegistrosConsultasTable
     */
    protected $RegistrosConsultas;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.RegistrosConsultas',
        'app.Pacientes',
        'app.Doctores',
        'app.ConsultasTratamientos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RegistrosConsultas') ? [] : ['className' => RegistrosConsultasTable::class];
        $this->RegistrosConsultas = $this->getTableLocator()->get('RegistrosConsultas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RegistrosConsultas);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\RegistrosConsultasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\RegistrosConsultasTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

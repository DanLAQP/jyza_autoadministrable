<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConsultasTratamientosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConsultasTratamientosTable Test Case
 */
class ConsultasTratamientosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ConsultasTratamientosTable
     */
    protected $ConsultasTratamientos;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.ConsultasTratamientos',
        'app.RegistrosConsultas',
        'app.Tratamientos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ConsultasTratamientos') ? [] : ['className' => ConsultasTratamientosTable::class];
        $this->ConsultasTratamientos = $this->getTableLocator()->get('ConsultasTratamientos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ConsultasTratamientos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ConsultasTratamientosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ConsultasTratamientosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

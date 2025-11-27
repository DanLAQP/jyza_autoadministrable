<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EstadosCuentasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EstadosCuentasTable Test Case
 */
class EstadosCuentasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EstadosCuentasTable
     */
    protected $EstadosCuentas;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.EstadosCuentas',
        'app.Pacientes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('EstadosCuentas') ? [] : ['className' => EstadosCuentasTable::class];
        $this->EstadosCuentas = $this->getTableLocator()->get('EstadosCuentas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->EstadosCuentas);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\EstadosCuentasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\EstadosCuentasTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

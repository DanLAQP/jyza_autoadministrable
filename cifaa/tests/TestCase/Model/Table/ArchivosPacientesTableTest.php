<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ArchivosPacientesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ArchivosPacientesTable Test Case
 */
class ArchivosPacientesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ArchivosPacientesTable
     */
    protected $ArchivosPacientes;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.ArchivosPacientes',
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
        $config = $this->getTableLocator()->exists('ArchivosPacientes') ? [] : ['className' => ArchivosPacientesTable::class];
        $this->ArchivosPacientes = $this->getTableLocator()->get('ArchivosPacientes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ArchivosPacientes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ArchivosPacientesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ArchivosPacientesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

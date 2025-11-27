<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RegistrosTratamientosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RegistrosTratamientosTable Test Case
 */
class RegistrosTratamientosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RegistrosTratamientosTable
     */
    protected $RegistrosTratamientos;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.RegistrosTratamientos',
        'app.Pacientes',
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
        $config = $this->getTableLocator()->exists('RegistrosTratamientos') ? [] : ['className' => RegistrosTratamientosTable::class];
        $this->RegistrosTratamientos = $this->getTableLocator()->get('RegistrosTratamientos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RegistrosTratamientos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\RegistrosTratamientosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\RegistrosTratamientosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

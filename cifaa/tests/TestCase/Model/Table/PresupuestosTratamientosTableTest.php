<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PresupuestosTratamientosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PresupuestosTratamientosTable Test Case
 */
class PresupuestosTratamientosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PresupuestosTratamientosTable
     */
    protected $PresupuestosTratamientos;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.PresupuestosTratamientos',
        'app.Presupuestos',
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
        $config = $this->getTableLocator()->exists('PresupuestosTratamientos') ? [] : ['className' => PresupuestosTratamientosTable::class];
        $this->PresupuestosTratamientos = $this->getTableLocator()->get('PresupuestosTratamientos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PresupuestosTratamientos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PresupuestosTratamientosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\PresupuestosTratamientosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EnfermedadesActualesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EnfermedadesActualesTable Test Case
 */
class EnfermedadesActualesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EnfermedadesActualesTable
     */
    protected $EnfermedadesActuales;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.EnfermedadesActuales',
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
        $config = $this->getTableLocator()->exists('EnfermedadesActuales') ? [] : ['className' => EnfermedadesActualesTable::class];
        $this->EnfermedadesActuales = $this->getTableLocator()->get('EnfermedadesActuales', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->EnfermedadesActuales);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\EnfermedadesActualesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\EnfermedadesActualesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

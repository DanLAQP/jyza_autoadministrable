<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContactosEmergenciaTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContactosEmergenciaTable Test Case
 */
class ContactosEmergenciaTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ContactosEmergenciaTable
     */
    protected $ContactosEmergencia;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.ContactosEmergencia',
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
        $config = $this->getTableLocator()->exists('ContactosEmergencia') ? [] : ['className' => ContactosEmergenciaTable::class];
        $this->ContactosEmergencia = $this->getTableLocator()->get('ContactosEmergencia', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ContactosEmergencia);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ContactosEmergenciaTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ContactosEmergenciaTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

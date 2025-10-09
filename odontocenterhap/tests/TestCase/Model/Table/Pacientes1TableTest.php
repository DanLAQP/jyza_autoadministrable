<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\Pacientes1Table;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\Pacientes1Table Test Case
 */
class Pacientes1TableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\Pacientes1Table
     */
    protected $Pacientes1;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Pacientes1',
        'app.Pacientes',
        'app.Citas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Pacientes1') ? [] : ['className' => Pacientes1Table::class];
        $this->Pacientes1 = $this->getTableLocator()->get('Pacientes1', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Pacientes1);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\Pacientes1Table::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\Pacientes1Table::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

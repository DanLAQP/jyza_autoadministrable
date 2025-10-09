<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AntecedentesOdontologicosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AntecedentesOdontologicosTable Test Case
 */
class AntecedentesOdontologicosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AntecedentesOdontologicosTable
     */
    protected $AntecedentesOdontologicos;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.AntecedentesOdontologicos',
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
        $config = $this->getTableLocator()->exists('AntecedentesOdontologicos') ? [] : ['className' => AntecedentesOdontologicosTable::class];
        $this->AntecedentesOdontologicos = $this->getTableLocator()->get('AntecedentesOdontologicos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AntecedentesOdontologicos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AntecedentesOdontologicosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AntecedentesOdontologicosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

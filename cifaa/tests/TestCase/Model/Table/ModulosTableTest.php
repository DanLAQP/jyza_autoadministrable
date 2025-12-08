<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ModulosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ModulosTable Test Case
 */
class ModulosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ModulosTable
     */
    protected $Modulos;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Modulos',
        'app.Cursos',
        'app.Lecciones',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Modulos') ? [] : ['className' => ModulosTable::class];
        $this->Modulos = $this->getTableLocator()->get('Modulos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Modulos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ModulosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ModulosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

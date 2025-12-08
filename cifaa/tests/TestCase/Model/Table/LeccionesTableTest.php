<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LeccionesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LeccionesTable Test Case
 */
class LeccionesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LeccionesTable
     */
    protected $Lecciones;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Lecciones',
        'app.Modulos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Lecciones') ? [] : ['className' => LeccionesTable::class];
        $this->Lecciones = $this->getTableLocator()->get('Lecciones', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Lecciones);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LeccionesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LeccionesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

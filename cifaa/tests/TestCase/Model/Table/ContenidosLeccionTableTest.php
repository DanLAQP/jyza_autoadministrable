<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContenidosLeccionTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContenidosLeccionTable Test Case
 */
class ContenidosLeccionTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ContenidosLeccionTable
     */
    protected $ContenidosLeccion;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.ContenidosLeccion',
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
        $config = $this->getTableLocator()->exists('ContenidosLeccion') ? [] : ['className' => ContenidosLeccionTable::class];
        $this->ContenidosLeccion = $this->getTableLocator()->get('ContenidosLeccion', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ContenidosLeccion);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ContenidosLeccionTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ContenidosLeccionTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

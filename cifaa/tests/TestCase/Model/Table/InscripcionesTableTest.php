<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InscripcionesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InscripcionesTable Test Case
 */
class InscripcionesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InscripcionesTable
     */
    protected $Inscripciones;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Inscripciones',
        'app.Users',
        'app.Cursos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Inscripciones') ? [] : ['className' => InscripcionesTable::class];
        $this->Inscripciones = $this->getTableLocator()->get('Inscripciones', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Inscripciones);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\InscripcionesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\InscripcionesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

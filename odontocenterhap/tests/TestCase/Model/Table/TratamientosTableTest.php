<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TratamientosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TratamientosTable Test Case
 */
class TratamientosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TratamientosTable
     */
    protected $Tratamientos;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Tratamientos',
        'app.RegistroTratamiento',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Tratamientos') ? [] : ['className' => TratamientosTable::class];
        $this->Tratamientos = $this->getTableLocator()->get('Tratamientos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Tratamientos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\TratamientosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

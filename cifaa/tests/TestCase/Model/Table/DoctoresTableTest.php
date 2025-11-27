<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DoctoresTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DoctoresTable Test Case
 */
class DoctoresTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DoctoresTable
     */
    protected $Doctores;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Doctores',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Doctores') ? [] : ['className' => DoctoresTable::class];
        $this->Doctores = $this->getTableLocator()->get('Doctores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Doctores);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DoctoresTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

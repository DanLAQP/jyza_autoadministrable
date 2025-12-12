<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CertificadosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CertificadosTable Test Case
 */
class CertificadosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CertificadosTable
     */
    protected $Certificados;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Certificados',
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
        $config = $this->getTableLocator()->exists('Certificados') ? [] : ['className' => CertificadosTable::class];
        $this->Certificados = $this->getTableLocator()->get('Certificados', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Certificados);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CertificadosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CertificadosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

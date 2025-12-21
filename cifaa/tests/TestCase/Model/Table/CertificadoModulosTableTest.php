<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CertificadoModulosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CertificadoModulosTable Test Case
 */
class CertificadoModulosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CertificadoModulosTable
     */
    protected $CertificadoModulos;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.CertificadoModulos',
        'app.Certificados',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CertificadoModulos') ? [] : ['className' => CertificadoModulosTable::class];
        $this->CertificadoModulos = $this->getTableLocator()->get('CertificadoModulos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CertificadoModulos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CertificadoModulosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CertificadoModulosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

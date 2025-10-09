<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\RegistrosConsultasController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\RegistrosConsultasController Test Case
 *
 * @uses \App\Controller\RegistrosConsultasController
 */
class RegistrosConsultasControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.RegistrosConsultas',
        'app.Pacientes',
        'app.Doctores',
        'app.ConsultasTratamientos',
    ];

    /**
     * Test exportPdf method
     *
     * @return void
     * @uses \App\Controller\RegistrosConsultasController::exportPdf()
     */
    public function testExportPdf(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\RegistrosConsultasController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\RegistrosConsultasController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\RegistrosConsultasController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\RegistrosConsultasController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test toggleState method
     *
     * @return void
     * @uses \App\Controller\RegistrosConsultasController::toggleState()
     */
    public function testToggleState(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

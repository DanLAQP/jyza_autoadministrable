<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\PacientesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\PacientesController Test Case
 *
 * @uses \App\Controller\PacientesController
 */
class PacientesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Pacientes',
        'app.AntecedentesMedicos',
        'app.AntecedentesOdontologicos',
        'app.ContactosEmergencia',
        'app.EnfermedadActual',
        'app.EstadoCuenta',
        'app.Presupuesto',
        'app.RegistroTratamiento',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\PacientesController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\PacientesController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\PacientesController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\PacientesController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\PacientesController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

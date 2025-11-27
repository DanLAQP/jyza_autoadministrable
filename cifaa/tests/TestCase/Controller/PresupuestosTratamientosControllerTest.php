<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\PresupuestosTratamientosController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\PresupuestosTratamientosController Test Case
 *
 * @uses \App\Controller\PresupuestosTratamientosController
 */
class PresupuestosTratamientosControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.PresupuestosTratamientos',
        'app.Presupuestos',
        'app.Tratamientos',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\PresupuestosTratamientosController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\PresupuestosTratamientosController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\PresupuestosTratamientosController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\PresupuestosTratamientosController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\PresupuestosTratamientosController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

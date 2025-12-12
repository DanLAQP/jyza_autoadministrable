<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\CursosController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\CursosController Test Case
 *
 * @uses \App\Controller\CursosController
 */
class CursosControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = [
        'app.Cursos',
        'app.Users',
        'app.Inscripciones',
        'app.Modulos',
    ];

    public function testViewUnauthenticated(): void
    {
        $this->get('/cursos/view/1');
        $this->assertResponseCode(302); // Redirects to login
        // $this->assertRedirectcontains('/users/login');
    }

    public function testViewAuthenticatedStudent(): void
    {
        // Mock authentication
        $this->session([
            'Auth' => [
                'id' => 3,
                'username' => 'student',
                'rol' => 3
            ]
        ]);

        $this->get('/cursos/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Solicitar Inscripción');
    }

    public function testSolicitarStudentSuccess(): void
    {
        $this->enableCsrfToken();
        
        $this->session([
            'Auth' => [
                'id' => 3,
                'username' => 'student',
                'rol' => 3
            ]
        ]);

        $this->post('/cursos/solicitar/1');
        
        // Should redirect to view
        $this->assertRedirect(['controller' => 'Cursos', 'action' => 'view', 1]);
        
        // Check flash message (partially)
        // $this->assertSessionHas('Flash.flash.0.message'); 
        
        // Assert record created
        $inscripciones = $this->getTableLocator()->get('Inscripciones');
        $query = $inscripciones->find()->where(['usuario_id' => 3, 'curso_id' => 1]);
        $this->assertEquals(1, $query->count());
        $inscripcion = $query->first();
        $this->assertEquals('pendiente', $inscripcion->estado);
    }

    public function testSolicitarAdminSuccess(): void
    {
        $this->enableCsrfToken();
        
        $this->session([
            'Auth' => [
                'id' => 1,
                'username' => 'admin',
                'rol' => 1
            ]
        ]);

        $this->post('/cursos/solicitar/1');
        
        // Should redirect to view, NOT index or student
        $this->assertRedirect(['controller' => 'Cursos', 'action' => 'view', 1]);
        
        $inscripciones = $this->getTableLocator()->get('Inscripciones');
        $count = $inscripciones->find()->where(['usuario_id' => 1, 'curso_id' => 1])->count();
        $this->assertEquals(1, $count);
    }

    public function testSolicitarDuplicate(): void
    {
        $this->enableCsrfToken();
        
        // First enrollment
        $inscripciones = $this->getTableLocator()->get('Inscripciones');
        $inscripcion = $inscripciones->newEntity([
            'usuario_id' => 3,
            'curso_id' => 1,
            'estado' => 'pendiente',
            'progreso' => 0
        ]);
        $inscripciones->save($inscripcion);

        $this->session([
            'Auth' => [
                'id' => 3,
                'username' => 'student',
                'rol' => 3
            ]
        ]);

        $this->post('/cursos/solicitar/1');
        
        // Should redirect to view with warning
        $this->assertRedirect(['controller' => 'Cursos', 'action' => 'view', 1]);
        
        // Count should still be 1
        $count = $inscripciones->find()->where(['usuario_id' => 3, 'curso_id' => 1])->count();
        $this->assertEquals(1, $count);
    }
}

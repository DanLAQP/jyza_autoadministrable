<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\CertificadosController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class CertificadosControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = [
        'app.Certificados',
        'app.Users',
        'app.Cursos',
    ];

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testIndexAdmin(): void
    {
        // Admin
        $this->session([
            'Auth' => [
                'id' => 1,
                'username' => 'admin',
                'rol' => 1,
                'estado' => 'activo'
            ]
        ]);
        
        $this->get('/certificados');
        $this->assertResponseOk();
        $this->assertResponseContains('Gestión de Certificados');
    }

    public function testIndexStudentForbidden(): void
    {
        // Student
        $this->session([
            'Auth' => [
                'id' => 3,
                'username' => 'student',
                'rol' => 3,
                'estado' => 'activo'
            ]
        ]);
        
        $this->get('/certificados');
        // Should redirect to student page or home depending on logic.
        // In ControlAccesoRoles: student -> student page (redirect)
        $this->assertRedirect();
    }

    public function testGenerarPost(): void
    {
        // Admin
        $this->session([
            'Auth' => [
                'id' => 1,
                'username' => 'admin',
                'rol' => 1,
                'estado' => 'activo'
            ]
        ]);

        $this->enableCsrfToken();
        $data = [
            'user_id' => 3, // Student in fixture
            'curso_id' => 1, // Course in fixture
            'horas' => 50,
            'fecha_emision' => '2025-12-12',
            // codigo auto-generated
        ];
        
        $this->post('/certificados/generar', $data);
        $this->assertRedirect(['action' => 'index']);

        $certificados = $this->getTableLocator()->get('Certificados');
        $query = $certificados->find()->where(['user_id' => 3, 'horas' => 50]);
        $this->assertEquals(1, $query->count());
    }

    public function testMisCertificadosStudent(): void
    {
        // Student
        $this->session([
            'Auth' => [
                'id' => 3,
                'username' => 'student',
                'rol' => 3,
                'estado' => 'activo'
            ]
        ]);

        $this->get('/certificados/mis-certificados');
        $this->assertResponseOk();
        $this->assertResponseContains('Mis Certificados');
    }
}

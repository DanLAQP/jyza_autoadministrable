<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\UsersController Test Case
 *
 * @uses \App\Controller\UsersController
 */
class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = [
        'app.Users',
    ];

    public function setUp(): void
    {
        parent::setUp();
        // Setup default authentication for Admin (ID: 1)
        // Note: Authentication plugin typically expects 'Auth' to directly contain the user data
        // unless configured otherwise. Trying flat structure.
        $this->session([
            'Auth' => [
                'id' => 1,
                'username' => 'admin',
                'rol' => 1, // Admin role
                'estado' => 'activo'
            ]
        ]);
    }

    public function testIndex(): void
    {
        $this->get('/users');
        $this->assertResponseOk();
        $this->assertResponseContains('admin');
        $this->assertResponseContains('12345678'); // Check for DNI display
    }

    public function testIndexSearch(): void
    {
        $this->get('/users?dni=87654321'); // Search for student DNI
        $this->assertResponseOk();
        $this->assertResponseContains('student');
        
        $users = $this->viewVariable('users');
        $this->assertCount(1, $users, 'Search should return exactly 1 user');
        $this->assertEquals('student', $users->first()->username);
    }

    public function testAdd(): void
    {
        $this->enableCsrfToken();
        $data = [
            'username' => 'newuser',
            'password' => 'newpassword',
            'rol' => 2,
            'dni' => '99999999',
            'estado' => 'activo'
        ];
        $this->post('/users/add', $data);

        $this->assertRedirect(['controller' => 'Users', 'action' => 'index']);
        
        $users = $this->getTableLocator()->get('Users');
        $query = $users->find()->where(['dni' => '99999999']);
        $this->assertEquals(1, $query->count());
    }

    public function testEdit(): void
    {
        $this->enableCsrfToken();
        $data = [
            'dni' => '88888888' // Update DNI
        ];
        $this->post('/users/edit/1', $data);

        $this->assertRedirect(['controller' => 'Users', 'action' => 'index']);

        $users = $this->getTableLocator()->get('Users');
        $user = $users->get(1);
        $this->assertEquals('88888888', $user->dni);
    }

    public function testView(): void
    {
        $this->get('/users/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('12345678'); // Check DNI in view (reset by fixture if not relying on previous test)
    }

    public function testUniqueDni(): void
    {
        $this->enableCsrfToken();
        // Try to add a user with existing DNI '12345678' (from fixture)
        $data = [
            'username' => 'duplicate_user',
            'password' => 'password',
            'rol' => 2,
            'dni' => '12345678', 
            'estado' => 'activo'
        ];
        $this->post('/users/add', $data);
        
        // Should not redirect on failure, should stay on page and show error
        $this->assertResponseOk(); 
        $this->assertResponseContains('Este DNI ya está registrado');
    }
}

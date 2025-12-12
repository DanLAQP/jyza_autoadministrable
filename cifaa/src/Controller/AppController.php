<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use App\Controller\Trait\ControlAccesoRoles;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/5/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Importación del trait ControlAccesoRoles
     * 
     * Descripción: Permite utilizar los métodos de control de acceso por roles
     * en todos los controladores que hereden de AppController. Esto centraliza
     * la lógica de autorización y facilita su mantenimiento.
     */
    use ControlAccesoRoles;
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Flash');

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/5/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
        $usuario = $this->Authentication->getIdentity();  // Obtiene el usuario autenticado

        // Pasar la identidad (usuario) a las vistas
        $this->set('usuario', $usuario);
    }

    /**
     * Verifica si el usuario actual está inscrito Y APROBADO en un curso
     *
     * @param int|string $cursoId ID del curso
     * @return bool true si está inscrito y aprobado, false si no
     */
    public function verificarInscripcion(int|string $cursoId): bool
    {
        $usuario = $this->getRequest()->getAttribute('identity');
        
        if (!$usuario) {
            return false;
        }
        
        // Convertir a int si es necesario
        $cursoId = (int) $cursoId;
        
        // Obtener tabla de inscripciones
        $inscripcionesTable = $this->fetchTable('Inscripciones');
        
        $inscripcion = $inscripcionesTable->find()
            ->where([
                'usuario_id' => $usuario->id,
                'curso_id' => $cursoId,
                'estado' => 'aprobada'
            ])
            ->first();
        
        return !empty($inscripcion);
    }

    /**
     * Verifica si el usuario está inscrito en el curso que contiene el módulo
     *
     * @param int|string $moduloId ID del módulo
     * @return bool true si está inscrito, false si no
     */
    public function verificarInscripcionModulo(int|string $moduloId): bool
    {
        $usuario = $this->getRequest()->getAttribute('identity');
        
        if (!$usuario) {
            return false;
        }
        
        // Convertir a int si es necesario
        $moduloId = (int) $moduloId;
        
        // Obtener el módulo con su curso
        $modulosTable = $this->fetchTable('Modulos');
        $modulo = $modulosTable->find()
            ->where(['Modulos.id' => $moduloId])
            ->select(['Modulos.curso_id'])
            ->first();
        
        if (!$modulo) {
            return false;
        }
        
        return $this->verificarInscripcion($modulo->curso_id);
    }

    /**
     * Verifica si el usuario está inscrito en el curso de una lección
     *
     * @param int|string $leccionId ID de la lección
     * @return bool true si está inscrito, false si no
     */
    public function verificarInscripcionLeccion(int|string $leccionId): bool
    {
        $usuario = $this->getRequest()->getAttribute('identity');
        
        if (!$usuario) {
            return false;
        }
        
        // Convertir a int si es necesario
        $leccionId = (int) $leccionId;
        
        // Obtener la lección con su módulo y curso
        $leccionesTable = $this->fetchTable('Lecciones');
        $leccion = $leccionesTable->find()
            ->contain(['Modulos'])
            ->where(['Lecciones.id' => $leccionId])
            ->first();
        
        if (!$leccion || !$leccion->modulo) {
            return false;
        }
        
        return $this->verificarInscripcion($leccion->modulo->curso_id);
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Permitir acciones sin autenticación
        $this->Authentication->addUnauthenticatedActions(['login', 'logout']);
    }

    // =========================================================================
    // MÉTODOS HELPER OPTIMIZADOS
    // =========================================================================
    
    /**
     * Obtiene el rol del usuario actual
     * 
     * Descripción: Método helper que simplifica la obtención del rol del usuario
     * autenticado. Evita repetir la lógica de autenticación en cada controlador.
     * 
     * Uso:
     * $role = $this->getUserRole();
     * if ($role === 3) { // Estudiante
     *     // Lógica específica para estudiantes
     * }
     * 
     * @return int|null ID del rol (1=Admin, 2=Docente, 3=Estudiante) o null si no está autenticado
     */
    protected function getUserRole(): ?int
    {
        $user = $this->Authentication->getIdentity();
        return $user ? $user->rol : null;
    }

    /**
     * Verifica si la acción actual está en la lista de acciones permitidas
     * 
     * Descripción: Simplifica la validación de permisos en beforeFilter.
     * Evita repetir la lógica de in_array() y getParam() en cada controlador.
     * 
     * Uso:
     * if ($this->isAllowedAction(['index', 'view'])) {
     *     // La acción está permitida
     * }
     * 
     * @param array $allowedActions Lista de acciones permitidas
     * @return bool true si la acción actual está permitida, false si no
     */
    protected function isAllowedAction(array $allowedActions): bool
    {
        $action = $this->request->getParam('action');
        return in_array($action, $allowedActions);
    }

    /**
     * Redirige al dashboard según el rol del usuario
     * 
     * Descripción: Centraliza la lógica de redirección post-login o cuando
     * un usuario intenta acceder a una sección no permitida. Cada rol tiene
     * su dashboard predeterminado.
     * 
     * Uso:
     * return $this->redirectByRole();
     * 
     * @return \Cake\Http\Response
     */
    protected function redirectByRole()
    {
        $role = $this->getUserRole();
        
        // Mapa de roles a sus dashboards correspondientes
        $redirects = [
            1 => ['controller' => 'Users', 'action' => 'index'],    // Admin → Gestión de usuarios
            2 => ['controller' => 'Cursos', 'action' => 'index'],   // Docente → Gestión de cursos
            3 => ['controller' => 'Cursos', 'action' => 'student']  // Estudiante → Catálogo de cursos
        ];
        
        // Si no hay rol o es desconocido, redirigir a login
        return $this->redirect($redirects[$role] ?? ['controller' => 'Users', 'action' => 'login']);
    }

    /**
     * Maneja la respuesta de acceso no autorizado
     * 
     * Descripción: Estandariza el manejo de accesos no autorizados en todo el sistema.
     * Muestra un mensaje de error y redirige al usuario según su rol o a una ruta específica.
     * 
     * Uso:
     * // Con mensaje y redirección personalizados
     * return $this->unauthorized(
     *     'No puedes editar este recurso',
     *     ['controller' => 'Cursos', 'action' => 'index']
     * );
     * 
     * // Solo con mensaje (redirige según rol)
     * return $this->unauthorized('Acceso denegado');
     * 
     * // Sin parámetros (mensaje genérico, redirige según rol)
     * return $this->unauthorized();
     * 
     * @param string|null $message Mensaje personalizado de error. Si es null, usa mensaje genérico
     * @param array|null $redirect Ruta de redirección personalizada. Si es null, usa redirectByRole()
     * @return \Cake\Http\Response
     */
    protected function unauthorized(?string $message = null, ?array $redirect = null)
    {
        // Mostrar mensaje de error (personalizado o genérico)
        $this->Flash->error($message ?? __('No tienes permiso para acceder a esta sección.'));
        
        // Redirigir a ruta específica o según el rol del usuario
        if ($redirect) {
            return $this->redirect($redirect);
        }
        
        return $this->redirectByRole();
    }
}

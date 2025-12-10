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
}

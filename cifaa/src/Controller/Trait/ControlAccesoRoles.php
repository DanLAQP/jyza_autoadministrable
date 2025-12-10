<?php
declare(strict_types=1);

/**
 * Trait de Control de Acceso por Roles
 * 
 * Este trait proporciona métodos auxiliares para verificar y controlar el acceso
 * de usuarios según su rol en el sistema. Permite validar permisos de manera
 * centralizada y consistente en todos los controladores que lo implementen.
 * 
 * Roles del sistema:
 * - 1: Administrador (acceso completo)
 * - 2: Docente (gestión de cursos asignados)
 * - 3: Estudiante/Usuario (acceso a cursos inscritos)
 * 
 * @author Sistema CIFA
 * @version 1.0
 * @since 2025-12-09
 */
namespace App\Controller\Trait;

trait ControlAccesoRoles
{
    /**
     * Verifica si el usuario actual posee un rol específico
     * 
     * Descripción: Compara el rol del usuario autenticado con el rol proporcionado.
     * Útil para validaciones simples de un solo rol.
     * 
     * @param int $roleId Identificador del rol a verificar (1=Admin, 2=Docente, 3=Estudiante)
     * @return bool true si el usuario tiene el rol especificado, false en caso contrario
     */
    protected function tieneRol(int $roleId): bool
    {
        $usuario = $this->Authentication->getIdentity();
        return $usuario && $usuario->rol == $roleId;
    }

    /**
     * Verifica si el usuario actual es administrador
     * 
     * Descripción: Método de conveniencia para verificar si el usuario tiene
     * privilegios de administrador (rol_id = 1). Los administradores tienen
     * acceso completo a todas las funcionalidades del sistema.
     * 
     * @return bool true si el usuario es administrador, false en caso contrario
     */
    protected function esAdministrador(): bool
    {
        return $this->tieneRol(1);
    }

    /**
     * Verifica si el usuario actual es docente
     * 
     * Descripción: Método de conveniencia para verificar si el usuario tiene
     * rol de docente (rol_id = 2). Los docentes pueden gestionar cursos,
     * módulos, lecciones y calificar a estudiantes.
     * 
     * @return bool true si el usuario es docente, false en caso contrario
     */
    protected function esDocente(): bool
    {
        return $this->tieneRol(2);
    }

    /**
     * Verifica si el usuario actual es estudiante
     * 
     * Descripción: Método de conveniencia para verificar si el usuario tiene
     * rol de estudiante (rol_id = 3). Los estudiantes pueden inscribirse en
     * cursos y acceder al contenido de los mismos.
     * 
     * @return bool true si el usuario es estudiante, false en caso contrario
     */
    protected function esEstudiante(): bool
    {
        return $this->tieneRol(3);
    }

    /**
     * Requiere que el usuario tenga uno de los roles permitidos
     * 
     * Descripción: Valida que el usuario actual posea al menos uno de los roles
     * especificados en el array. Si no cumple la condición, muestra un mensaje
     * de error y redirige según el rol del usuario o a login si no está autenticado.
     * Este método debe invocarse al inicio de las acciones que requieren
     * permisos específicos.
     * 
     * @param array $rolesPermitidos Array de identificadores de roles permitidos (ej: [1, 2])
     * @param array|null $redireccionAlternativa URL de redirección personalizada si falla la validación
     * @return \Cake\Http\Response|null Respuesta de redirección si el acceso es denegado, null si se permite
     */
    protected function requiereRol(array $rolesPermitidos = [], ?array $redireccionAlternativa = null)
    {
        $usuario = $this->Authentication->getIdentity();
        
        // Verificar si el usuario está autenticado
        if (!$usuario) {
            $this->Flash->error(__('Debe iniciar sesión para acceder a esta sección.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
        
        // Verificar si el usuario tiene uno de los roles permitidos
        if (!in_array($usuario->rol, $rolesPermitidos)) {
            $this->Flash->error(__('No posee los permisos necesarios para acceder a esta sección.'));
            
            // Si hay redirección personalizada, usarla
            if ($redireccionAlternativa) {
                return $this->redirect($redireccionAlternativa);
            }
            
            // Redirección por defecto según el rol del usuario
            if ($usuario->rol == 1) {
                // Administrador -> Dashboard de usuarios
                return $this->redirect(['controller' => 'Users', 'action' => 'index']);
            } elseif ($usuario->rol == 2) {
                // Docente -> Listado de cursos
                return $this->redirect(['controller' => 'Cursos', 'action' => 'index']);
            } else {
                // Estudiante -> Vista de estudiante de cursos
                return $this->redirect(['controller' => 'Cursos', 'action' => 'student']);
            }
        }
        
        // Acceso permitido
        return null;
    }

    /**
     * Requiere acceso exclusivo de administrador
     * 
     * Descripción: Método de conveniencia que restringe el acceso únicamente
     * a usuarios con rol de administrador. Útil para acciones críticas como
     * gestión de usuarios, configuración del sistema, etc.
     * 
     * @return \Cake\Http\Response|null Respuesta de redirección si no es admin, null si se permite
     */
    protected function requiereAdministrador()
    {
        return $this->requiereRol([1]);
    }

    /**
     * Requiere acceso de administrador o docente
     * 
     * Descripción: Método de conveniencia que permite el acceso a administradores
     * y docentes. Útil para funcionalidades de gestión de contenido educativo
     * que pueden realizar tanto admins como docentes.
     * 
     * @return \Cake\Http\Response|null Respuesta de redirección si no tiene permiso, null si se permite
     */
    protected function requiereAdministradorODocente()
    {
        return $this->requiereRol([1, 2]);
    }

    /**
     * Verifica si el usuario puede editar un recurso específico
     * 
     * Descripción: Valida si el usuario actual es el propietario del recurso
     * o es un administrador. Útil para edición de perfiles, contenido propio, etc.
     * Los administradores siempre tienen permiso, los demás usuarios solo si
     * son propietarios del recurso.
     * 
     * @param int $propietarioId ID del usuario propietario del recurso
     * @return bool true si puede editar, false en caso contrario
     */
    protected function puedeEditar(int $propietarioId): bool
    {
        $usuario = $this->Authentication->getIdentity();
        
        if (!$usuario) {
            return false;
        }
        
        // Los administradores pueden editar cualquier recurso
        if ($usuario->rol == 1) {
            return true;
        }
        
        // Los demás usuarios solo pueden editar sus propios recursos
        return $usuario->id == $propietarioId;
    }

    /**
     * Obtiene el usuario autenticado actual
     * 
     * Descripción: Método auxiliar para obtener la identidad del usuario
     * autenticado de manera consistente en todos los controladores.
     * 
     * @return \Authentication\IdentityInterface|null Objeto de identidad del usuario o null
     */
    protected function obtenerUsuarioActual()
    {
        return $this->Authentication->getIdentity();
    }

    /**
     * Verifica si el usuario está autenticado
     * 
     * Descripción: Comprueba si existe una sesión activa de usuario autenticado.
     * 
     * @return bool true si está autenticado, false en caso contrario
     */
    protected function estaAutenticado(): bool
    {
        return $this->Authentication->getIdentity() !== null;
    }
}

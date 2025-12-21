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

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\Database\Expression\QueryExpression;
use Cake\Database\Expression\FuncExpression;

class PagesController extends AppController
{
    public function display(string ...$path): ?Response
    {
        if (!$path) {
            return $this->redirect('/');
        }

        // Bloque de seguridad
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }

        // Lógica especial para la página "home"
        if ($path[0] === 'home') {
            // Consultar datos reales
            $certificadosCount = $this->fetchTable('Certificados')->find()->count();
            $cursosCount = $this->fetchTable('Cursos')->find()->count();
            $usuariosCount = $this->fetchTable('Users')->find()->count();

            // Consultar cantidad de diplomados emitidos
            $diplomadosCount = $this->fetchTable('Certificados')->find()
                ->where(['Certificados.tipo' => 'diplomado'])
                ->count();

            // Consultar cantidad de usuarios inscritos a cursos
            $usuariosInscritosCount = $this->fetchTable('Inscripciones')->find()->count();

            // Consultar el curso con más inscripciones
            $topCurso = $this->fetchTable('Cursos')->find()
                ->select(['titulo', 'total_inscripciones' => 'COUNT(Inscripciones.id)'])
                ->leftJoinWith('Inscripciones')
                ->group(['Cursos.id'])
                ->order(['total_inscripciones' => 'DESC'])
                ->first();

            // Manejar el caso en que no haya un curso con inscripciones
            $topCurso = $topCurso ?? (object) ['titulo' => 'Ninguno', 'total_inscripciones' => 0];

            // Consultar cantidad de inscripciones pendientes
            $inscripcionesPendientesCount = $this->fetchTable('Inscripciones')->find()
                ->where(['estado' => 'pendiente'])
                ->count();

            // Pasar datos a la vista
            $this->set(compact('certificadosCount', 'cursosCount', 'usuariosCount', 'diplomadosCount', 'usuariosInscritosCount', 'topCurso', 'inscripcionesPendientesCount'));
        }

        try {
            return $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }
}

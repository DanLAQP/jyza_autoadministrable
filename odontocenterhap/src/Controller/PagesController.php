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
            $hoy = \Cake\I18n\Date::now('America/Lima');

            // Consultar citas del día (total de citas)
            $citasDelDia = $this->fetchTable('Citas')
                ->find()
                ->where([
                    'DATE(fecha_hora)' => $hoy->format('Y-m-d')
                ])
                ->count(); // Devuelve el número total de citas del día

            // Consultar citas por estado en los últimos 7 días
            // 1. Consultar citas por estado en los últimos 7 días
                $fechaHoy = $hoy->format('Y-m-d'); // Hoy
                $fechaHace7Dias = $hoy->subDays(7)->format('Y-m-d'); // Hace 7 días

                $citasPorFechaYEstado = $this->fetchTable('Citas')
                    ->find()
                    ->select([
                        'fecha' => 'DATE(fecha_hora)',
                        'estado',
                        'count' => $this->fetchTable('Citas')->find()->func()->count('id')
                    ])
                    ->where([
                        'DATE(fecha_hora) >=' => $fechaHace7Dias,
                        'DATE(fecha_hora) <=' => $fechaHoy
                    ])
                    ->group(['fecha', 'estado'])
                    ->order(['fecha' => 'ASC'])
                    ->all();

                // 2. Agrupar citas por fecha y estado
                $citasPorFecha = [];
                $estados = []; // <-- lo llenaremos dinámicamente

                foreach ($citasPorFechaYEstado as $cita) {
                    $citasPorFecha[$cita->fecha][$cita->estado] = $cita->count;

                    // Guardamos los estados que aparecen
                    if (!in_array($cita->estado, $estados)) {
                        $estados[] = $cita->estado;
                    }
                }

                // 3. Asegurarse de que todas las fechas tengan todos los estados
                foreach ($citasPorFecha as $fecha => &$citas) {
                    foreach ($estados as $estado) {
                        if (!isset($citas[$estado])) {
                            $citas[$estado] = 0; // Inicializamos en 0 si no existe
                        }
                    }
                }

                // 4. Formatear datos para el gráfico
                $dias = array_keys($citasPorFecha);

                // Creamos el array de datosEstado dinámicamente
                $datosEstado = [];
                foreach ($estados as $estado) {
                    $datosEstado[$estado] = [];
                    foreach ($dias as $dia) {
                        $datosEstado[$estado][] = $citasPorFecha[$dia][$estado];
                    }
                }
                
            // Cumpleaños hoy
            $cumpleanosHoy = $this->fetchTable('Pacientes')
                ->find()
                ->contain(['Pacientes1'])
                ->where([
                    'MONTH(fecha_nacimiento)' => $hoy->month,
                    'DAY(fecha_nacimiento)' => $hoy->day
                ])
                ->orderAsc('Pacientes1.nombre')
                ->all();

            // Recordatorios de profilaxis
            $profilaxisPendientes = $this->fetchTable('Pacientes')
                ->find()
                ->contain(['Pacientes1'])
                ->matching('AntecedentesOdontologicos', function ($q) use ($hoy) {
                    return $q->where([
                        'AntecedentesOdontologicos.fecha_ultima_profilaxis IS NOT NULL',
                        'DATE_ADD(AntecedentesOdontologicos.fecha_ultima_profilaxis, INTERVAL 6 MONTH) <=' => $hoy->format('Y-m-d') // Formato explícito
                    ]);
                })
                ->orderAsc('Pacientes1.nombre')
                ->all();

            $tratamientosMasRealizados = [];

            // Consulta para obtener los tratamientos más realizados en los últimos 7 días
            $tratamientosQuery = $this->fetchTable('ConsultasTratamientos')
                ->find()
                ->select([
                    'tratamiento' => 'Tratamientos.nombre',
                    'cantidad' => $this->fetchTable('ConsultasTratamientos')->find()->func()->sum('ConsultasTratamientos.cantidad')
                ])
                ->innerJoinWith('Tratamientos') // Relación entre consultas_tratamientos y tratamientos
                ->innerJoinWith('RegistrosConsultas') // Relación entre consultas_tratamientos y registros_consultas
                ->where([
                    'DATE(RegistrosConsultas.modified) >=' => $fechaHace7Dias,
                    'DATE(RegistrosConsultas.modified) <= ' => $fechaHoy
                ])
                ->group(['Tratamientos.nombre']) // Agrupar por nombre del tratamiento
                ->order(['cantidad' => 'DESC']) // Ordenar por cantidad (de mayor a menor)
                ->limit(3) // Solo los 3 primeros
                ->all();

            // Convertimos los resultados en un array asociativo
            foreach ($tratamientosQuery as $t) {
                $tratamientosMasRealizados[$t->tratamiento] = $t->cantidad;
            }

            $doctoresMasConsultas = $this->fetchTable('RegistrosConsultas')
                ->find()
                ->select([
                    'doctor' => 'Doctores.nombre',
                    'cantidad' => $this->fetchTable('RegistrosConsultas')->find()->func()->count('RegistrosConsultas.id')
                ])
                ->innerJoinWith('Doctores') // Relación con la tabla Doctores
                ->where([
                    'DATE(RegistrosConsultas.modified) >=' => $fechaHace7Dias,
                    'DATE(RegistrosConsultas.modified) <= ' => $fechaHoy
                ])
                ->group(['Doctores.nombre'])
                ->orderDesc('cantidad')
                ->all();

            // Convertimos el resultado en un array asociativo [doctor => cantidad]
            $doctoresArray = [];
            foreach ($doctoresMasConsultas as $doctor) {
                $doctoresArray[$doctor->doctor] =  $doctor->cantidad; // Convertir a entero
            }

            // Pasamos las variables a la vista
            $this->set(compact('cumpleanosHoy', 'profilaxisPendientes', 'citasDelDia', 'citasPorFecha', 'datosEstado', 'dias', 'tratamientosMasRealizados', 'doctoresArray'));
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

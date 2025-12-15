<?php
namespace App\Controller;

use App\Controller\AppController;

class StatisticsController extends AppController
{
    /**
     * Calculadora Estadística Unificada
     * Incluye: Tamaño de Muestra y Margen de Error
     */
    public function calculadora()
    {
        $this->set('title', 'Calculadora Estadística');
    }
}

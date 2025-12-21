<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;
use Cake\Routing\Router;

/**
 * CertificadosPublic Controller
 * 
 * Controlador público para búsqueda y descarga de certificados
 * sin requerir autenticación
 */
class CertificadosPublicController extends Controller
{
    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        
        // Cargar componentes necesarios
        $this->loadComponent('Flash');
        
        // No cargar autenticación para este controlador
        // Todos los métodos son públicos
    }

    /**
     * Página de búsqueda de certificados
     * GET: Muestra el formulario
     * POST: Busca por código
     *
     * @return \Cake\Http\Response|null|void
     */
    public function search()
    {
        $this->viewBuilder()->setLayout('public');
        
        // Obtener la tabla de Certificados dentro del método
        $certificadosTable = $this->fetchTable('Certificados');

        $certificado = null;
        $codigoBuscado = null;

        // Obtener el código dependiendo del método de solicitud
        $codigo = $this->request->is('post') 
            ? $this->request->getData('codigo') 
            : $this->request->getQuery('codigo');

        if (!empty($codigo)) {
            $codigoBuscado = $codigo;

            // Buscar certificado por código
            $certificado = $certificadosTable->find()
                ->where(['Certificados.codigo' => $codigo])
                ->contain(['Users', 'Cursos', 'CertificadoModulos'])
                ->first();

            if (!$certificado) {
                $this->Flash->error('Certificado no encontrado. Verifica el código ingresado.');
            }
        } else {
            if ($this->request->is('post')) {
                $this->Flash->error('Por favor ingresa un código de certificado.');
            }
        }

        $this->set(compact('certificado', 'codigoBuscado'));
    }

    /**
     * Ver certificado públicamente
     * Accesible por código, sin exposición de datos sensibles
     *
     * @param string|null $codigo Código del certificado
     * @return \Cake\Http\Response|null|void
     */
    public function view($codigo = null)
    {
        $this->viewBuilder()->setLayout('public');
        
        // Obtener la tabla de Certificados dentro del método
        $certificadosTable = $this->fetchTable('Certificados');

        if (empty($codigo)) {
            $this->Flash->error('Código de certificado inválido.');
            return $this->redirect(['action' => 'search']);
        }

        $certificado = $certificadosTable->find()
            ->where(['Certificados.codigo' => $codigo])
            ->contain(['Users', 'Cursos', 'CertificadoModulos'])
            ->first();

        if (!$certificado) {
            $this->Flash->error('Certificado no encontrado.');
            return $this->redirect(['action' => 'search']);
        }

        $this->set(compact('certificado'));
    }

    /**
     * Descargar PDF del certificado
     * Sin requerir autenticación
     *
     * @param string|null $codigo Código del certificado
     * @return \Cake\Http\Response
     */
    public function downloadPdf($codigo = null)
    {
        // Obtener la tabla de Certificados dentro del método
        $certificadosTable = $this->fetchTable('Certificados');

        if (empty($codigo)) {
            $this->Flash->error('Código de certificado inválido.');
            return $this->redirect(['action' => 'search']);
        }

        $certificado = $certificadosTable->find()
            ->where(['Certificados.codigo' => $codigo])
            ->contain(['Users', 'Cursos', 'CertificadoModulos'])
            ->first();

        if (!$certificado) {
            $this->Flash->error('Certificado no encontrado.');
            return $this->redirect(['action' => 'search']);
        }

        $logoUrl = Router::url('/img/logoCifa.png', true);
        $firmaUrl = Router::url('/img/firma.png', true);

        // Renderizar la vista HTML como contenido para el PDF
        $this->viewBuilder()->enableAutoLayout(false);
        $this->set(compact('certificado', 'logoUrl', 'firmaUrl'));
        $html = $this->render('export_pdf');

        // Configurar DomPDF para el PDF
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);

        // Configurar tamaño de papel
        $dompdf->setPaper('A4', 'portrait');

        // Renderizar el PDF
        $dompdf->render();

        // Descargar el archivo PDF
        return $dompdf->stream("Certificado_{$certificado->codigo}.pdf", ['Attachment' => 1]);
    }
}

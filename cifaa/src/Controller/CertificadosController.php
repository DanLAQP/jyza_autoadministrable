<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenDate;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Certificados Controller
 *
 * @property \App\Model\Table\CertificadosTable $Certificados
 */
class CertificadosController extends AppController
{
    /**
     * Index method (Admin only)
     * Lists all certificates and allows managing them.
     */
    public function index()
    {
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }

        $query = $this->Certificados->find()
            ->contain(['Users', 'Cursos'])
            ->order(['Certificados.created' => 'DESC']);
            
        $certificados = $this->paginate($query);

        $this->set(compact('certificados'));
    }

    /**
     * Generar method (Admin only)
     * Displays form to generate a new certificate and handles creation.
     */
    public function generar()
    {
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }

        $certificado = $this->Certificados->newEmptyEntity();
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // Generate a unique code if not provided or just auto-generate
            // Format: CER-USERID-COURSEID-TIMESTAMP
            if (empty($data['codigo'])) {
                $data['codigo'] = 'CER-' . $data['user_id'] . '-' . $data['curso_id'] . '-' . time();
            }

            $certificado = $this->Certificados->patchEntity($certificado, $data);
            
            if ($this->Certificados->save($certificado)) {
                $this->Flash->success(__('El certificado ha sido generado correctamente.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo generar el certificado. Por favor, intente de nuevo.'));
        }
        
        // Load Users and Cursos for the dropdowns
        $users = $this->Certificados->Users->find('list', [
            'keyField' => 'id',
            'valueField' => 'username' // Or user's full name if available
        ])->where(['rol IN' => [2, 3]]) // Students and Teachers
          ->all();
          
        $cursos = $this->Certificados->Cursos->find('list', [
            'keyField' => 'id',
            'valueField' => 'titulo'
        ])->all();

        $this->set(compact('certificado', 'users', 'cursos'));
    }

    /**
     * Mis Certificados (Student only)
     * Shows certificates belonging to the current user.
     */
    public function misCertificados()
    {
        $user = $this->Authentication->getIdentity();
        if (!$user) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $query = $this->Certificados->find()
            ->contain(['Cursos'])
            ->where(['Certificados.user_id' => $user->id])
            ->order(['Certificados.created' => 'DESC']);

        $certificados = $this->paginate($query);

        $this->set(compact('certificados'));
    }

    /**
     * Descargar PDF
     * Generates and downloads the PDF certificate.
     */
    public function descargar($id = null)
    {
        $certificado = $this->Certificados->get($id, contain: ['Users', 'Cursos']);
        $user = $this->Authentication->getIdentity();

        // Security check: Admin or Owner
        if (!$user || ($user->rol != 1 && $user->id != $certificado->user_id)) {
            $this->Flash->error(__('No tiene permiso para descargar este certificado.'));
            return $this->redirect(['action' => 'misCertificados']);
        }

        // Configure Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true); // Allow remote images (or local via http)
        $options->set('defaultFont', 'Helvetica');
        
        $dompdf = new Dompdf($options);
        
        // Render View to String
        // We use a specific layout 'pdf/certificado'
        $html = $this->viewBuilder()
            ->setClassName('Cake\View\View')
            ->setTemplatePath('Certificados/pdf')
            ->setTemplate('certificado')
            ->setLayout('ajax') // No default layout
            ->setOption('serialize', ['certificado'])
            ->setVar('certificado', $certificado)
            ->build()
            ->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream("Certificado-{$certificado->codigo}.pdf", [
            "Attachment" => true
        ]);
        
        return null; // Stop CakePHP rendering
    }

    /**
     * Delete method (Admin only)
     */
    public function delete($id = null)
    {
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }

        $this->request->allowMethod(['post', 'delete']);
        $certificado = $this->Certificados->get($id);
        if ($this->Certificados->delete($certificado)) {
            $this->Flash->success(__('El certificado ha sido eliminado.'));
        } else {
            $this->Flash->error(__('No se pudo eliminar el certificado.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

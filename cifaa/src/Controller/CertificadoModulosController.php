<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CertificadoModulos Controller
 *
 * @property \App\Model\Table\CertificadoModulosTable $CertificadoModulos
 */
class CertificadoModulosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->CertificadoModulos->find()
            ->contain(['Certificados']);
        $certificadoModulos = $this->paginate($query);

        $this->set(compact('certificadoModulos'));
    }

    /**
     * View method
     *
     * @param string|null $id Certificado Modulo id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $certificadoModulo = $this->CertificadoModulos->get($id, contain: ['Certificados']);
        $this->set(compact('certificadoModulo'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $certificadoModulo = $this->CertificadoModulos->newEmptyEntity();
        if ($this->request->is('post')) {
            $certificadoModulo = $this->CertificadoModulos->patchEntity($certificadoModulo, $this->request->getData());
            if ($this->CertificadoModulos->save($certificadoModulo)) {
                $this->Flash->success(__('The certificado modulo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The certificado modulo could not be saved. Please, try again.'));
        }
        $certificados = $this->CertificadoModulos->Certificados->find('list', limit: 200)->all();
        $this->set(compact('certificadoModulo', 'certificados'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Certificado Modulo id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $certificadoModulo = $this->CertificadoModulos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $certificadoModulo = $this->CertificadoModulos->patchEntity($certificadoModulo, $this->request->getData());
            if ($this->CertificadoModulos->save($certificadoModulo)) {
                $this->Flash->success(__('The certificado modulo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The certificado modulo could not be saved. Please, try again.'));
        }
        $certificados = $this->CertificadoModulos->Certificados->find('list', limit: 200)->all();
        $this->set(compact('certificadoModulo', 'certificados'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Certificado Modulo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $certificadoModulo = $this->CertificadoModulos->get($id);
        if ($this->CertificadoModulos->delete($certificadoModulo)) {
            $this->Flash->success(__('The certificado modulo has been deleted.'));
        } else {
            $this->Flash->error(__('The certificado modulo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

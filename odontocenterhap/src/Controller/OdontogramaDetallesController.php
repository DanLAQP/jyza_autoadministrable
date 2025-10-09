<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * OdontogramaDetalles Controller
 *
 * @property \App\Model\Table\OdontogramaDetallesTable $OdontogramaDetalles
 */
class OdontogramaDetallesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->OdontogramaDetalles->find()
            ->contain(['Odontograma']);
        $odontogramaDetalles = $this->paginate($query);

        $this->set(compact('odontogramaDetalles'));
    }

    /**
     * View method
     *
     * @param string|null $id Odontograma Detalle id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $odontogramaDetalle = $this->OdontogramaDetalles->get($id, contain: ['Odontograma']);
        $this->set(compact('odontogramaDetalle'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $odontogramaDetalle = $this->OdontogramaDetalles->newEmptyEntity();
        if ($this->request->is('post')) {
            $odontogramaDetalle = $this->OdontogramaDetalles->patchEntity($odontogramaDetalle, $this->request->getData());
            if ($this->OdontogramaDetalles->save($odontogramaDetalle)) {
                $this->Flash->success(__('The odontograma detalle has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The odontograma detalle could not be saved. Please, try again.'));
        }
        $odontograma = $this->OdontogramaDetalles->Odontograma->find('list')->all();
        $this->set(compact('odontogramaDetalle', 'odontograma'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Odontograma Detalle id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $odontogramaDetalle = $this->OdontogramaDetalles->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $odontogramaDetalle = $this->OdontogramaDetalles->patchEntity($odontogramaDetalle, $this->request->getData());
            if ($this->OdontogramaDetalles->save($odontogramaDetalle)) {
                if ($this->request->is('ajax')) {
                    // Respuesta JSON para solicitudes AJAX exitosas
                    $this->set([
                        'status' => 'success',
                        'message' => __('The odontograma detalle has been saved.'),
                        'data' => $odontogramaDetalle,
                    ]);
                    $this->viewBuilder()->setOption('serialize', ['status', 'message', 'data']);
                    return;
                } else {
                    $this->Flash->success(__('The odontograma detalle has been saved.'));
                    // Redirigir a la edición del odontograma si no es AJAX
                    return $this->redirect(['controller' => 'Odontograma', 'action' => 'edit', $odontogramaDetalle->odontograma_id]);
                }
            } else {
                if ($this->request->is('ajax')) {
                    // Respuesta JSON para solicitudes AJAX fallidas
                    $this->set([
                        'status' => 'error',
                        'message' => __('The odontograma detalle could not be saved. Please, try again.'),
                    ]);
                    $this->viewBuilder()->setOption('serialize', ['status', 'message']);
                    return;
                } else {
                    $this->Flash->error(__('The odontograma detalle could not be saved. Please, try again.'));
                }
            }
        }

        $odontograma = $this->OdontogramaDetalles->Odontograma->find('list')->all();
        $this->set(compact('odontogramaDetalle', 'odontograma'));

        // Usar el layout adecuado
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        } else {
            $this->viewBuilder()->setLayout('default');
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Odontograma Detalle id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $odontogramaDetalle = $this->OdontogramaDetalles->get($id);
        if ($this->OdontogramaDetalles->delete($odontogramaDetalle)) {
            $this->Flash->success(__('The odontograma detalle has been deleted.'));
        } else {
            $this->Flash->error(__('The odontograma detalle could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

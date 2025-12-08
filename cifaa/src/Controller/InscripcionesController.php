<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Inscripciones Controller
 *
 * @property \App\Model\Table\InscripcionesTable $Inscripciones
 */
class InscripcionesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Inscripciones->find()
            ->contain(['Users', 'Cursos']);
        
        // Filtrar por estado si se proporciona
        $estado = $this->request->getQuery('estado');
        if ($estado && in_array($estado, ['pendiente', 'aprobada', 'rechazada'])) {
            $query = $query->where(['Inscripciones.estado' => $estado]);
        }
        
        // Ordenar por más recientes primero
        $query = $query->orderBy(['Inscripciones.created' => 'DESC']);
        
        $inscripciones = $this->paginate($query);

        $this->set(compact('inscripciones'));
    }

    /**
     * View method
     *
     * @param string|null $id Inscripcione id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $inscripcione = $this->Inscripciones->get($id, contain: ['Users', 'Cursos']);
        $this->set(compact('inscripcione'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $inscripcione = $this->Inscripciones->newEmptyEntity();
        $usuarioActual = $this->getRequest()->getAttribute('identity');
        $cursoId = $this->request->getQuery('curso_id');
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // Si viene de inscripción rápida desde el curso
            if ($cursoId && $usuarioActual) {
                $data['curso_id'] = $cursoId;
                $data['usuario_id'] = $usuarioActual->id;
                $data['progreso'] = 0;
                $data['estado'] = 'pendiente'; // Por defecto en estado pendiente
                
                // Verificar si ya existe una solicitud no aprobada
                $solicitudExistente = $this->Inscripciones->find()
                    ->where([
                        'usuario_id' => $usuarioActual->id,
                        'curso_id' => $cursoId,
                        'estado !=' => 'aprobada'
                    ])
                    ->first();
                
                if ($solicitudExistente) {
                    $this->Flash->error(__('Ya tienes una solicitud pendiente o rechazada para este curso. No puedes crear otra.'));
                    
                    // Redirigir al curso
                    if ($cursoId) {
                        return $this->redirect(['controller' => 'Cursos', 'action' => 'view', $cursoId]);
                    }
                    return $this->redirect(['action' => 'index']);
                }
            }
            
            $inscripcione = $this->Inscripciones->patchEntity($inscripcione, $data);
            if ($this->Inscripciones->save($inscripcione)) {
                $this->Flash->success(__('¡Tu solicitud de inscripción ha sido enviada! Por favor espera a que un administrador la apruebe.'));

                // Redirigir al curso si viene de allí
                if ($cursoId) {
                    return $this->redirect(['controller' => 'Cursos', 'action' => 'view', $cursoId]);
                }
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo completar la solicitud de inscripción. Por favor, intenta nuevamente.'));
        }
        
        // Pre-llenar datos si viene del curso
        if ($cursoId && $usuarioActual) {
            $inscripcione->curso_id = $cursoId;
            $inscripcione->usuario_id = $usuarioActual->id;
            $inscripcione->progreso = 0;
            $inscripcione->estado = 'pendiente';
        }
        
        $users = $this->Inscripciones->Users->find('list', limit: 200)->all();
        $cursos = $this->Inscripciones->Cursos->find('list', limit: 200)->all();
        $this->set(compact('inscripcione', 'users', 'cursos', 'cursoId', 'usuarioActual'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Inscripcione id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $inscripcione = $this->Inscripciones->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inscripcione = $this->Inscripciones->patchEntity($inscripcione, $this->request->getData());
            if ($this->Inscripciones->save($inscripcione)) {
                $this->Flash->success(__('The inscripcione has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inscripcione could not be saved. Please, try again.'));
        }
        $users = $this->Inscripciones->Users->find('list', limit: 200)->all();
        $cursos = $this->Inscripciones->Cursos->find('list', limit: 200)->all();
        $this->set(compact('inscripcione', 'users', 'cursos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Inscripcione id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inscripcione = $this->Inscripciones->get($id);
        if ($this->Inscripciones->delete($inscripcione)) {
            $this->Flash->success(__('The inscripcione has been deleted.'));
        } else {
            $this->Flash->error(__('The inscripcione could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Aprobar solicitud de inscripción
     *
     * @param string|null $id ID de la inscripción
     * @return \Cake\Http\Response
     */
    public function aprobar($id = null)
    {
        $this->request->allowMethod(['post']);
        $inscripcione = $this->Inscripciones->get($id, contain: ['Users', 'Cursos']);
        
        $inscripcione->estado = 'aprobada';
        
        if ($this->Inscripciones->save($inscripcione)) {
            $this->Flash->success(__('Inscripción aprobada. El usuario ahora puede acceder al curso.'));
        } else {
            $this->Flash->error(__('No se pudo aprobar la inscripción. Por favor, intenta nuevamente.'));
        }
        
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Rechazar solicitud de inscripción
     *
     * @param string|null $id ID de la inscripción
     * @return \Cake\Http\Response
     */
    public function rechazar($id = null)
    {
        $this->request->allowMethod(['post']);
        $inscripcione = $this->Inscripciones->get($id, contain: ['Users', 'Cursos']);
        
        $inscripcione->estado = 'rechazada';
        
        if ($this->Inscripciones->save($inscripcione)) {
            $this->Flash->success(__('Inscripción rechazada.'));
        } else {
            $this->Flash->error(__('No se pudo rechazar la inscripción. Por favor, intenta nuevamente.'));
        }
        
        return $this->redirect(['action' => 'index']);
    }
}

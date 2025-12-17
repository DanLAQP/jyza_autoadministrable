<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Titulares Controller
 *
 * Gestión de titulares - identidad certificable independiente del sistema de usuarios.
 * Solo accesible para administradores.
 *
 * @property \App\Model\Table\TitularesTable $Titulares
 */
class TitularesController extends AppController
{
    use \App\Controller\Traits\ControlAccesoRoles;

    /**
     * Index method
     * Lista todos los titulares con información de certificados y usuarios vinculados
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }

        $query = $this->Titulares->find()
            ->contain(['Users', 'Certificados'])
            ->order(['Titulares.created' => 'DESC']);

        // Filtro de búsqueda
        $termino = $this->request->getQuery('termino');
        if (!empty($termino)) {
            $query->where([
                'OR' => [
                    'Titulares.dni LIKE' => '%' . $termino . '%',
                    'Titulares.nombres LIKE' => '%' . $termino . '%',
                    'Titulares.apellidos LIKE' => '%' . $termino . '%'
                ]
            ]);
        }

        $titulares = $this->paginate($query, [
            'limit' => 20
        ]);

        $this->set(compact('titulares', 'termino'));
    }

    /**
     * View method
     * Ver detalles de un titular con todos sus certificados y usuario vinculado
     *
     * @param string|null $id Titular id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }

        $titular = $this->Titulares->get($id, [
            'contain' => [
                'Users',
                'Certificados' => [
                    'sort' => ['Certificados.created' => 'DESC']
                ]
            ]
        ]);

        // Obtener estadísticas
        $estadisticas = $this->Titulares->obtenerEstadisticas($id);

        $this->set(compact('titular', 'estadisticas'));
    }

    /**
     * Edit method
     * Editar datos de un titular (solo admin, con precaución)
     *
     * @param string|null $id Titular id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }

        $titular = $this->Titulares->get($id, [
            'contain' => ['Users', 'Certificados']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $titular = $this->Titulares->patchEntity($titular, $this->request->getData());

            if ($this->Titulares->save($titular)) {
                $this->Flash->success(__('El titular ha sido actualizado correctamente.'));
                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('No se pudo actualizar el titular. Por favor, intente nuevamente.'));
        }

        $this->set(compact('titular'));
    }

    /**
     * Buscar method (AJAX)
     * Busca un titular por DNI y retorna JSON con información
     *
     * @param string|null $dni DNI a buscar
     * @return \Cake\Http\Response
     */
    public function buscar($dni = null)
    {
        $this->request->allowMethod(['get', 'post']);
        $this->viewBuilder()->setClassName('Json');

        if (empty($dni)) {
            $response = [
                'error' => true,
                'message' => 'DNI requerido'
            ];
        } else {
            $titular = $this->Titulares->find()
                ->where(['dni' => $dni])
                ->first();

            if ($titular) {
                // Contar certificados
                $totalCertificados = $this->Titulares->Certificados->find()
                    ->where(['titular_id' => $titular->id])
                    ->count();

                $response = [
                    'encontrado' => true,
                    'titular' => [
                        'id' => $titular->id,
                        'dni' => $titular->dni,
                        'nombres' => $titular->nombres,
                        'apellidos' => $titular->apellidos,
                        'nombre_completo' => $titular->nombres . ' ' . $titular->apellidos,
                        'total_certificados' => $totalCertificados
                    ]
                ];
            } else {
                $response = [
                    'encontrado' => false,
                    'message' => 'Titular no encontrado con ese DNI'
                ];
            }
        }

        $this->set('response', $response);
        $this->viewBuilder()->setOption('serialize', 'response');

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($response));
    }

    /**
     * Verificar method (AJAX)
     * Verifica si un titular existe y si está vinculado a un usuario
     *
     * @param string|null $dni DNI a verificar
     * @return \Cake\Http\Response
     */
    public function verificar($dni = null)
    {
        $this->request->allowMethod(['get', 'post']);
        $this->viewBuilder()->setClassName('Json');

        if (empty($dni)) {
            $response = [
                'error' => true,
                'message' => 'DNI requerido'
            ];
        } else {
            $titular = $this->Titulares->find()
                ->where(['dni' => $dni])
                ->contain(['Users'])
                ->first();

            if ($titular) {
                $totalCertificados = $this->Titulares->Certificados->find()
                    ->where(['titular_id' => $titular->id])
                    ->count();

                $response = [
                    'existe' => true,
                    'id' => $titular->id,
                    'nombres' => $titular->nombres,
                    'apellidos' => $titular->apellidos,
                    'nombre_completo' => $titular->nombres . ' ' . $titular->apellidos,
                    'usuario_vinculado' => !empty($titular->user) ? $titular->user->username : null,
                    'usuario_id' => !empty($titular->user) ? $titular->user->id : null,
                    'total_certificados' => $totalCertificados
                ];
            } else {
                $response = [
                    'existe' => false,
                    'message' => 'DNI no encontrado en el sistema'
                ];
            }
        }

        $this->set('response', $response);
        $this->viewBuilder()->setOption('serialize', 'response');

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($response));
    }

    /**
     * Delete method (soft delete no implementado - RESTRICT en DB)
     * Los titulares no se pueden eliminar si tienen certificados
     *
     * @param string|null $id Titular id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }

        $this->request->allowMethod(['post', 'delete']);
        $titular = $this->Titulares->get($id, [
            'contain' => ['Certificados', 'Users']
        ]);

        // Validar que no tenga certificados
        if (!empty($titular->certificados)) {
            $this->Flash->error(__(
                'No se puede eliminar el titular porque tiene {0} certificado(s) asociado(s). ' .
                'Debe anular los certificados primero.',
                count($titular->certificados)
            ));
            return $this->redirect(['action' => 'view', $id]);
        }

        // Validar que no tenga usuario vinculado
        if (!empty($titular->user)) {
            $this->Flash->error(__(
                'No se puede eliminar el titular porque está vinculado al usuario: {0}. ' .
                'Debe desvincular el usuario primero.',
                $titular->user->username
            ));
            return $this->redirect(['action' => 'view', $id]);
        }

        if ($this->Titulares->delete($titular)) {
            $this->Flash->success(__('El titular ha sido eliminado.'));
        } else {
            $this->Flash->error(__('No se pudo eliminar el titular.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

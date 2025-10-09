<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Odontograma Controller
 *
 * @property \App\Model\Table\OdontogramaTable $Odontograma
 */
class OdontogramaController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
{
    // Obtener el término de búsqueda de la solicitud (GET)
    $searchTerm = $this->request->getQuery('search', '');

    // Construir la consulta
    $query = $this->Odontograma->find()
        ->contain(['Pacientes1', 'Dientes'])
        ->order(['Odontograma.id' => 'DESC']);

    // Agregar condiciones de búsqueda si hay un término
    if (!empty($searchTerm)) {
        $query->matching('Pacientes1', function ($q) use ($searchTerm) {
            return $q->where([
                'OR' => [
                    'LOWER(Pacientes1.nombre) LIKE' => '%' . strtolower($searchTerm) . '%',
                    'LOWER(Pacientes1.apellido) LIKE' => '%' . strtolower($searchTerm) . '%',
                ],
            ]);
        });
    }

    // Paginación de resultados
    $odontograma = $this->paginate($query);

    // Pasar datos a la vista
    $this->set(compact('odontograma', 'searchTerm'));
}


    /**
     * View method
     *
     * @param string|null $id Odontograma id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    public function view($id = null)
    {
        // Obtener el odontograma con relaciones necesarias
        $odontograma = $this->Odontograma->get($id, contain: [
            'Pacientes1',
            'OdontogramaDientes.Dientes',
            'OdontogramaSimbolos' => ['Simbolos'],
            'OdontogramaDetalles'
        ]);


        // Asignar los símbolos a los dientes
        foreach ($odontograma->odontograma_dientes as $diente) {
            $diente->simbolos = array_filter(
                $odontograma->odontograma_simbolos,
                function ($simbolo) use ($diente) {
                    return $simbolo->diente_id === $diente->diente->id;
                }
            );
        }

        // Pasar los datos a la vista
        $this->set(compact('odontograma'));
        // Usar un layout diferenciado para solicitudes normales o AJAX
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        } else {
            $this->viewBuilder()->setLayout('default');
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    // public function add()
    // {
    //     $odontograma = $this->Odontograma->newEmptyEntity();
    //     if ($this->request->is('post')) {
    //         $odontograma = $this->Odontograma->patchEntity($odontograma, $this->request->getData());

    //         // Guarda el odontograma sin símbolos, ya que se asignarán después
    //         if ($this->Odontograma->save($odontograma)) {
    //             $this->Flash->success(__('The odontograma has been saved.'));

    //             // Redirecciona al view del odontograma creado
    //             return $this->redirect(['action' => 'view', $odontograma->id]);
    //         }
    //         $this->Flash->error(__('The odontograma could not be saved. Please, try again.'));
    //     }

    //     // Solo cargar la lista de pacientes para asociar
    //     $pacientes = $this->Odontograma->Pacientes->find('list')->all();
    //     $this->set(compact('odontograma', 'pacientes'));
    //     // Usar un layout diferenciado para solicitudes normales o AJAX
    //     if ($this->request->is('ajax')) {
    //         $this->viewBuilder()->setLayout('ajax');
    //     } else {
    //         $this->viewBuilder()->setLayout('default');
    //     }
    // }
    // public function add($paciente_id = null)
    // {
    //     $odontograma = $this->Odontograma->newEmptyEntity();

    //     if ($paciente_id) {
    //         // Asigna el paciente_id al nuevo odontograma
    //         $odontograma->paciente_id = $paciente_id;
    //     }

    //     if ($this->request->is('post')) {
    //         $odontograma = $this->Odontograma->patchEntity($odontograma, $this->request->getData());

    //         if ($this->Odontograma->save($odontograma)) {
    //             $this->Flash->success(__('The odontograma has been saved.'));

    //             // Si se pasa un paciente_id, redirige al view del paciente
    //             if ($paciente_id) {
    //                 return $this->redirect(['controller' => 'Pacientes', 'action' => 'view', $paciente_id, '#' => 'odontogramas']);
    //             }

    //             // Si no se pasa un paciente_id, redirige al view del odontograma
    //             return $this->redirect(['action' => 'view', $odontograma->id]);
    //         }

    //         $this->Flash->error(__('The odontograma could not be saved. Please, try again.'));
    //     }

    //     // Cargar la lista de pacientes si no hay paciente_id
    //     $pacientes = $this->Odontograma->Pacientes->find('list')->all();
    //     $this->set(compact('odontograma', 'pacientes'));

    //     // Configurar el layout según el tipo de solicitud
    //     if ($this->request->is('ajax')) {
    //         $this->viewBuilder()->setLayout('ajax');
    //     } else {
    //         $this->viewBuilder()->setLayout('default');
    //     }
    // }
    public function add($paciente_id = null)
{
    $odontograma = $this->Odontograma->newEmptyEntity();

    if ($this->request->is('post')) {
        $data = $this->request->getData();

        // Si no vino por URL pero sí por el buscador
        if (!empty($data['paciente_id'])) {
            $data['paciente_id'] = $data['paciente_id'];
        } elseif ($paciente_id) {
            // Si vino por URL, usar ese directamente
            $data['paciente_id'] = $paciente_id;
        }

        $odontograma = $this->Odontograma->patchEntity($odontograma, $data);

        if ($this->Odontograma->save($odontograma)) {
            $this->Flash->success(__('The odontograma has been saved.'));

            // Redirigir según cómo se llegó
            return $this->redirect([
                'controller' => 'Pacientes1',
                'action' => 'view',
                $data['paciente_id'],
                '#' => 'odontogramas'
            ]);
        }

        $this->Flash->error(__('The odontograma could not be saved. Please, try again.'));
    } else {
        // Si se llega por GET con paciente_id, lo asignamos directamente
        if ($paciente_id) {
            $odontograma->paciente_id = $paciente_id;
        }
    }

    // Solo cargar lista de pacientes si no se pasó paciente_id
    $pacientes = [];
    if (!$paciente_id) {
        $pacientes = $this->Odontograma->Pacientes1->find('list')->all();
    }

    $this->set(compact('odontograma', 'pacientes'));

    // Configurar el layout según el tipo de solicitud
    $this->viewBuilder()->setLayout($this->request->is('ajax') ? 'ajax' : 'default');
}



    /**
     * Edit method
     *
     * @param string|null $id Odontograma id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $odontograma = $this->Odontograma->get($id, contain: [
            'Pacientes1',
            'OdontogramaDientes.Dientes',
            'OdontogramaSimbolos' => ['Simbolos'],
            'OdontogramaDetalles'
        ]);
        //para cambiar el titulo
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $odontograma = $this->Odontograma->patchEntity($odontograma, $data, ['fields' => ['titulo']]);
            if ($this->Odontograma->save($odontograma)) {
                $this->Flash->success(__('El título del odontograma se ha actualizado correctamente.'));
            } else {
                $this->Flash->error(__('No se pudo actualizar el título. Por favor, intente de nuevo.'));
            }
        }
        // Asignar los símbolos a los dientes
        foreach ($odontograma->odontograma_dientes as $diente) {
            $diente->simbolos = array_filter($odontograma->odontograma_simbolos, function ($simbolo) use ($diente) {
                return $simbolo->diente_id === $diente->diente->id;
            });
        }

        // Obtener todos los símbolos disponibles
        $simbolosDisponibles = $this->Odontograma->OdontogramaSimbolos->Simbolos->find('all')->toArray();

        // Obtener las categorías únicas de los símbolos
        $categorias = array_unique(array_map(function ($simbolo) {
            return $simbolo->categoria;
        }, $simbolosDisponibles));

        // Si se envía el formulario para agregar un detalle
        if ($this->request->is('post')) {
            // Crear una nueva entidad de detalle y asignar los datos del formulario
            $odontogramaDetalle = $this->Odontograma->OdontogramaDetalles->newEmptyEntity();

            // Agregar el odontograma_id para asociarlo al odontograma actual
            $data = $this->request->getData();
            $data['odontograma_id'] = $id;  // Relacionar con el odontograma actual

            // Asignar los datos del formulario al detalle
            $odontogramaDetalle = $this->Odontograma->OdontogramaDetalles->patchEntity($odontogramaDetalle, $data);

            // Guardar el detalle
            if ($this->Odontograma->OdontogramaDetalles->save($odontogramaDetalle)) {
                $this->Flash->success(__('El detalle fue agregado exitosamente.'));
                return $this->redirect(['action' => 'edit', $id]);
            } else {
                $this->Flash->error(__('No se pudo agregar el detalle. Por favor, intente de nuevo.'));
            }
        }

        // Pasar los datos a la vista
        $this->set(compact('odontograma', 'simbolosDisponibles', 'categorias'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Odontograma id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $odontograma = $this->Odontograma->get($id);
        if ($this->Odontograma->delete($odontograma)) {
            $this->Flash->success(__('The odontograma has been deleted.'));
        } else {
            $this->Flash->error(__('The odontograma could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function saveSymbolPositions()
    {
        $this->request->allowMethod(['post']); // Permitir solo solicitudes POST

        // Obtener los datos enviados desde el cliente
        $positions = $this->request->getData();

        // Verificar que los datos sean válidos
        if (empty($positions) || !is_array($positions)) {
            return $this->response
                ->withType('application/json')
                ->withStatus(400, 'Datos inválidos')
                ->withStringBody(json_encode(['status' => 'error', 'message' => 'No se recibieron datos válidos.']));
        }

        $results = []; // Para almacenar los resultados de cada operación

        foreach ($positions as $position) {
            // Validar los campos obligatorios
            if (
                empty($position['odontogramaId']) ||
                empty($position['symbolId']) ||
                empty($position['dienteId']) || // Verificar que diente_id esté presente
                !isset($position['posX']) ||
                !isset($position['posY'])
            ) {
                $results[] = [
                    'status' => 'error',
                    'message' => 'Faltan datos obligatorios',
                    'position' => $position
                ];
                continue; // Saltar a la siguiente posición si faltan datos
            }

            // Crear una nueva entidad para guardar
            $odontogramaSimbolo = $this->Odontograma->OdontogramaSimbolos->newEntity([
                'odontograma_id' => $position['odontogramaId'], // ID del odontograma
                'simbolo_id' => $position['symbolId'],         // ID del símbolo
                'diente_id' => $position['dienteId'],          // ID del diente
                'posicion_x' => $position['posX'],             // Coordenada X
                'posicion_y' => $position['posY'],             // Coordenada Y
            ]);

            // Intentar guardar en la base de datos
            if ($this->Odontograma->OdontogramaSimbolos->save($odontogramaSimbolo)) {
                $results[] = [
                    'status' => 'success',
                    'symbolId' => $position['symbolId'],
                    'message' => 'Símbolo guardado correctamente.'
                ];
            } else {
                // Registrar los errores de validación si falla el guardado
                $results[] = [
                    'status' => 'error',
                    'symbolId' => $position['symbolId'],
                    'errors' => $odontogramaSimbolo->getErrors(),
                    'message' => 'Error al guardar el símbolo.'
                ];
            }
        }

        // Devolver la respuesta JSON al cliente
        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode(['status' => 'success', 'results' => $results]));
    }
}

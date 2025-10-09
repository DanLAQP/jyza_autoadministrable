<?php

declare(strict_types=1);

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Cake\Routing\Router;

/**
 * Presupuestos Controller
 *
 * @property \App\Model\Table\PresupuestosTable $Presupuestos
 */
class PresupuestosController extends AppController
{

    public function exportPresupuestoPdf($id = null)
    {
        $logoUrl = Router::url('/img/logoClinica.png', true);
        // Obtener el paciente por ID y cargar las relaciones necesarias
        $presupuesto = $this->Presupuestos->get($id, contain: [
            'Pacientes1.Pacientes',
            'PresupuestosTratamientos.Tratamientos',
        ]);

        // Renderizar la vista HTML como contenido para el PDF
        $this->viewBuilder()->enableAutoLayout(false);
        $this->set(compact('presupuesto', 'logoUrl'));
        $html = $this->render('presupuesto_detalle');

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
        $dompdf->stream("presupuesto_detalle_{$id}.pdf", ['Attachment' => 1]);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $roles = [1, 2, 3];
        if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer());
        }
        // Obtener el término de búsqueda de la solicitud (GET)
        $searchTerm = $this->request->getQuery('search', '');

        // Construir la consulta inicial
        $query = $this->Presupuestos->find()
            ->contain(['Pacientes1' => ['Pacientes']])
            ->order(['Presupuestos.id' => 'DESC']);

        // Agregar condiciones de búsqueda si hay un término
        if (!empty($searchTerm)) {
            $query->matching('Pacientes', function ($q) use ($searchTerm) {
                return $q->where([
                    'OR' => [
                        'LOWER(Pacientes.nombre) LIKE' => '%' . strtolower($searchTerm) . '%',
                        'LOWER(Pacientes.apellido) LIKE' => '%' . strtolower($searchTerm) . '%',
                    ],
                ]);
            });
        }

        // Paginar los resultados
        $presupuestos = $this->paginate($query);

        // Pasar datos a la vista
        $this->set(compact('presupuestos', 'searchTerm'));
    }

    /**
     * View method
     *
     * @param string|null $id Presupuesto id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $roles = [1, 2, 3];
        if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer());
        }
        $presupuesto = $this->Presupuestos->get($id, contain: [
            'Pacientes1' => ['Pacientes'],
            'PresupuestosTratamientos.Tratamientos',
        ]);

        $this->set(compact('presupuesto'));
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
    public function add($paciente_id = null)
    {
        $roles = [1, 2, 3];
        if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer());
        }
        $presupuesto = $this->Presupuestos->newEmptyEntity();
        $pacienteSeleccionado = null; // Variable para el paciente seleccionado

        // Prellenar datos si el paciente_id fue pasado como parámetro en la URL
    if ($paciente_id) {
        $presupuesto->paciente_id = $paciente_id;
        $pacienteSeleccionado = $this->Presupuestos->Pacientes1->find()
            ->where(['id' => $paciente_id])
            ->first();
    }

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Combina la fecha ingresada por el usuario con la hora actual
            $fechaUsuario = new \DateTime($data['modified']);
            $horaActual = new \DateTime();
            $fechaUsuario->setTime((int)$horaActual->format('H'), (int)$horaActual->format('i'), (int)$horaActual->format('s'));

            // Asigna la fecha combinada al campo modified
            $data['modified'] = $fechaUsuario->format('Y-m-d H:i:s');
            $tratamientosData = $data['tratamientos'] ?? [];
            $totalConIgv = $data['total'] ?? 0;

            // Remover datos de tratamientos antes de guardar el presupuesto
            unset($data['tratamientos']);
            $presupuesto = $this->Presupuestos->patchEntity($presupuesto, $data);

            $presupuesto->total = $totalConIgv;

            if ($this->Presupuestos->save($presupuesto)) {
                $presupuestoId = $presupuesto->id;

                // Procesar los tratamientos y guardarlos en PresupuestosTratamientos
                foreach ($tratamientosData as $tratamiento) {
                    $presupuestoTratamiento = $this->Presupuestos->PresupuestosTratamientos->newEmptyEntity();
                    $presupuestoTratamiento = $this->Presupuestos->PresupuestosTratamientos->patchEntity($presupuestoTratamiento, [
                        'presupuesto_id' => $presupuestoId,
                        'tratamiento_id' => $tratamiento['tratamiento_id'],
                        'precio_unitario' => $tratamiento['precio_unitario'],
                        'cantidad' => $tratamiento['cantidad'],
                        'total' => $tratamiento['total'],
                    ]);

                    if (!$this->Presupuestos->PresupuestosTratamientos->save($presupuestoTratamiento)) {
                        $this->Flash->error(__('No se pudo guardar el tratamiento: {0}', $tratamiento['tratamiento_id']));
                    }
                }

                $this->Flash->success(__('El presupuesto ha sido guardado.'));

                if ($paciente_id) {
                    return $this->redirect(['controller' => 'Pacientes1', 'action' => 'view', $paciente_id, '#' => 'presupuestos']);
                }

                return $this->redirect(['action' => 'index', $presupuestoId]);
            }
            $this->Flash->error(__('El presupuesto no pudo ser guardado. Por favor, inténtelo de nuevo.'));
        }

        $pacientesData = $this->Presupuestos->Pacientes1->find('all')
            ->select(['id', 'nombre', 'apellido'])
            ->toArray();

        $pacientesData2 = $this->Presupuestos->Pacientes1->Pacientes->find('all')
            ->select(['id', 'dni', 'direccion'])
            ->toArray();

        $tratamientosData = $this->Presupuestos->PresupuestosTratamientos->Tratamientos->find('all')
            ->select(['id', 'nombre', 'costo'])
            ->toArray();

        $this->set(compact('presupuesto', 'pacientesData', 'tratamientosData', 'pacienteSeleccionado', 'pacientesData2'));
        // Usar un layout diferenciado para solicitudes normales o AJAX
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        } else {
            $this->viewBuilder()->setLayout('default');
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Presupuesto id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id)
    {
        $roles = [1, 2, 3];
        if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer());
        }
        $presupuesto = $this->Presupuestos->get($id, contain: [
            'PresupuestosTratamientos' => [
                'Tratamientos',
            ],
            'Pacientes1' => [
                'Pacientes', 
            ],
        ]);


        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            // Combina la fecha ingresada por el usuario con la hora actual
            $fechaUsuario = new \DateTime($data['modified']);
            $horaActual = new \DateTime();
            $fechaUsuario->setTime((int)$horaActual->format('H'), (int)$horaActual->format('i'), (int)$horaActual->format('s'));

            // Asigna la fecha combinada al campo modified
            $data['modified'] = $fechaUsuario->format('Y-m-d H:i:s');
            $tratamientosData = $data['tratamientos'] ?? [];
            $totalConIgv = $data['total'] ?? 0;

            unset($data['tratamientos']);
            $presupuesto = $this->Presupuestos->patchEntity($presupuesto, $data);
            $presupuesto->total = $totalConIgv;

            if ($this->Presupuestos->save($presupuesto)) {
                foreach ($tratamientosData as $tratamiento) {
                    // Si el ID está vacío, asumimos que es un nuevo tratamiento
                    if (empty($tratamiento['id'])) {
                        $presupuestoTratamiento = $this->Presupuestos->PresupuestosTratamientos->newEntity([
                            'presupuesto_id' => $presupuesto->id,
                            'tratamiento_id' => $tratamiento['tratamiento_id'],
                            'precio_unitario' => $tratamiento['precio_unitario'],
                            'cantidad' => $tratamiento['cantidad'],
                            'total' => $tratamiento['total'],
                        ]);

                        if (!$this->Presupuestos->PresupuestosTratamientos->save($presupuestoTratamiento)) {
                            $this->Flash->error(__('No se pudo guardar el nuevo tratamiento: {0}. Errores: {1}', $tratamiento['tratamiento_id'], json_encode($presupuestoTratamiento->getErrors())));
                        }
                    } else {
                        // Si el ID existe, editamos el tratamiento existente
                        if ($this->Presupuestos->PresupuestosTratamientos->exists(['id' => $tratamiento['id']])) {
                            $presupuestoTratamiento = $this->Presupuestos->PresupuestosTratamientos->get($tratamiento['id']);
                            $presupuestoTratamiento = $this->Presupuestos->PresupuestosTratamientos->patchEntity($presupuestoTratamiento, [
                                'tratamiento_id' => $tratamiento['tratamiento_id'],
                                'precio_unitario' => $tratamiento['precio_unitario'],
                                'cantidad' => $tratamiento['cantidad'],
                                'total' => $tratamiento['total'],
                            ]);

                            if (!$this->Presupuestos->PresupuestosTratamientos->save($presupuestoTratamiento)) {
                                $this->Flash->error(__('No se pudo guardar el tratamiento existente: {0}. Errores: {1}', $tratamiento['tratamiento_id'], json_encode($presupuestoTratamiento->getErrors())));
                            }
                        } else {
                            $this->Flash->error(__('No se encontró el tratamiento asociado con el ID: {0}', $tratamiento['id']));
                            continue; // Salta este tratamiento
                        }
                    }
                }
                $this->Flash->success(__('El presupuesto ha sido guardado.'));
                return $this->redirect(['action' => 'index', $presupuesto->id]);
            }
            $this->Flash->error(__('El presupuesto no pudo ser guardado. Por favor, inténtelo de nuevo.'));
        }

        $pacientesData = $this->Presupuestos->Pacientes1->find('all')
            ->select(['id', 'nombre', 'apellido'])
            ->toArray();

        $pacientesData2 = $this->Presupuestos->Pacientes1->Pacientes->find('all')
            ->select(['id', 'dni', 'direccion'])
            ->toArray();

        $tratamientosData = $this->Presupuestos->PresupuestosTratamientos->Tratamientos->find('all')
            ->select(['id', 'nombre', 'costo'])
            ->toArray();

        $this->set(compact('presupuesto', 'pacientesData', 'tratamientosData', 'pacientesData2'));
        // Usar un layout diferenciado para solicitudes normales o AJAX
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        } else {
            $this->viewBuilder()->setLayout('default');
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Presupuesto id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $presupuesto = $this->Presupuestos->get($id);
        if ($this->Presupuestos->delete($presupuesto)) {
            $this->Flash->success(__('The presupuesto has been deleted.'));
        } else {
            $this->Flash->error(__('The presupuesto could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

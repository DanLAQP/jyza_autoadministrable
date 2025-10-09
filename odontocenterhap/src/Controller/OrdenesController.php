<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Ordenes Controller
 *
 * @property \App\Model\Table\OrdenesTable $Ordenes
 */
class OrdenesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Ordenes->find()
            ->contain(['Pacientes', 'Doctores']);
        $ordenes = $this->paginate($query);

        $this->set(compact('ordenes'));
    }

    /**
     * View method
     *
     * @param string|null $id Ordene id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
   public function view($id = null)
    {
        $ordene = $this->Ordenes->get($id, 
        contain: [
            'Pacientes1',
            'Doctores',
            'OrdenesTratamientos' => ['Tratamientos'],
            'Visitas'
        ]);

        $this->set(compact('ordene'));
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
    $ordene = $this->Ordenes->newEmptyEntity();
    $pacienteSeleccionado = null;

    // Si viene paciente_id por URL, lo preseleccionamos
    if ($paciente_id) {
        $ordene->paciente_id = $paciente_id;
        // ✅ Relación correcta con Pacientes1
        $pacienteSeleccionado = $this->Ordenes->Pacientes1->find()
            ->where(['id' => $paciente_id])
            ->first();
    }

    if ($this->request->is('post')) {
        $data = $this->request->getData();

        // Convertir los tratamientos (en tabla) a OrdenesTratamientos
        $ordenesTratamientos = [];
        if (!empty($data['tratamientos'])) {
            foreach ($data['tratamientos'] as $tratamiento) {
                $ordenesTratamientos[] = [
                    'tratamiento_id' => $tratamiento['tratamiento_id'],
                    'cantidad' => $tratamiento['cantidad'],
                    'precio_unitario' => $tratamiento['precio_unitario'],
                    'subtotal' => $tratamiento['subtotal'],
                ];
            }
        }

        $data['ordenes_tratamientos'] = $ordenesTratamientos;

        // ⚙️ Cálculo de reparto con porcentaje recibido
        $total = floatval($data['total'] ?? 0);
        $montoLab = floatval($data['monto_laboratorio'] ?? 0);
        $montoMat = floatval($data['monto_materiales'] ?? 0);
        $porcentajeDoctor = isset($data['porcentaje_doctor']) ? floatval($data['porcentaje_doctor']) : 0.5;

        // Validar que el porcentaje esté en rango 0-1
        if ($porcentajeDoctor < 0) {
            $porcentajeDoctor = 0;
        } elseif ($porcentajeDoctor > 1) {
            $porcentajeDoctor = 1;
        }

        $baseDistribucion = max($total - $montoLab - $montoMat, 0);

        $data['pago_doctor'] = round($baseDistribucion * $porcentajeDoctor, 2);
        $data['restante_clinica'] = round($baseDistribucion - $data['pago_doctor'], 2);
        $data['porcentaje_doctor'] = $porcentajeDoctor;

        $ordene = $this->Ordenes->patchEntity($ordene, $data, [
            'associated' => ['OrdenesTratamientos', 'Visitas']
        ]);

        try {
            if ($this->Ordenes->saveOrFail($ordene)) {
                $this->Flash->success(__('La orden ha sido guardada.'));
                if ($paciente_id) {
                    return $this->redirect([
                        'controller' => 'Pacientes1',
                        'action' => 'view',
                        $paciente_id,
                        '#' => 'ordenes'
                    ]);
                } else {
                    return $this->redirect(['action' => 'index']);
                }
            }
        } catch (\Exception $e) {
            $this->Flash->error(__('La orden no pudo guardarse: {0}', $e->getMessage()));
        }
    }

    // ✅ También corregimos aquí la relación
    $pacientesData = $this->Ordenes->Pacientes1->find('all')
        ->select(['id'])
        ->toArray();

    $doctores = $this->Ordenes->Doctores->find('list')->all();

    $tratamientosData = $this->Ordenes->OrdenesTratamientos->Tratamientos->find()
        ->select(['id', 'nombre', 'costo'])
        ->toArray();

    $this->set(compact('ordene', 'pacienteSeleccionado', 'pacientesData', 'doctores', 'tratamientosData'));
}


    /**
     * Edit method
     *
     * @param string|null $id Ordene id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
  public function edit($id = null)
{
    $ordene = $this->Ordenes->get($id, contain: [
        'OrdenesTratamientos' => ['Tratamientos'],
        'Visitas'
    ]);

    // ✅ Relación corregida con Pacientes1
    $pacienteSeleccionado = $this->Ordenes->Pacientes1->get($ordene->paciente_id);

    if ($this->request->is(['patch', 'post', 'put'])) {
        $data = $this->request->getData();

        // Convertir tratamientos con ID si existe (para evitar duplicar)
        $ordenesTratamientos = [];
        if (!empty($data['tratamientos'])) {
            foreach ($data['tratamientos'] as $tratamiento) {
                $temp = [
                    'tratamiento_id' => $tratamiento['tratamiento_id'],
                    'cantidad' => $tratamiento['cantidad'],
                    'precio_unitario' => $tratamiento['precio_unitario'],
                    'subtotal' => $tratamiento['subtotal'],
                ];
                if (!empty($tratamiento['id'])) {
                    $temp['id'] = $tratamiento['id']; // mantener el ID existente
                }
                $ordenesTratamientos[] = $temp;
            }
        }
        $data['ordenes_tratamientos'] = $ordenesTratamientos;

        // Recalcular distribución
        $total = floatval($data['total'] ?? 0);
        $montoLab = floatval($data['monto_laboratorio'] ?? 0);
        $montoMat = floatval($data['monto_materiales'] ?? 0);
        $porcentajeDoctor = isset($data['porcentaje_doctor']) ? floatval($data['porcentaje_doctor']) : 0.5;

        $porcentajeDoctor = min(1, max(0, $porcentajeDoctor));

        $baseDistribucion = max($total - $montoLab - $montoMat, 0);
        $data['pago_doctor'] = round($baseDistribucion * $porcentajeDoctor, 2);
        $data['restante_clinica'] = round($baseDistribucion - $data['pago_doctor'], 2);
        $data['porcentaje_doctor'] = $porcentajeDoctor;

        // También conservar los IDs de visitas para evitar duplicar
        if (!empty($data['visitas'])) {
            foreach ($data['visitas'] as $i => $visita) {
                if (!empty($visita['id'])) {
                    $data['visitas'][$i]['id'] = $visita['id']; // mantener ID
                }
            }
        }

        $ordene = $this->Ordenes->patchEntity($ordene, $data, [
            'associated' => ['OrdenesTratamientos', 'Visitas']
        ]);

        try {
            if ($this->Ordenes->saveOrFail($ordene)) {
                $this->Flash->success(__('La orden ha sido actualizada.'));
                if ($ordene->paciente_id) {
                    return $this->redirect([
                        'controller' => 'Pacientes1',
                        'action' => 'view',
                        $ordene->paciente_id,
                        '#' => 'ordenes'
                    ]);
                } else {
                    return $this->redirect(['action' => 'index']);
                }
            }
        } catch (\Exception $e) {
            $this->Flash->error(__('No se pudo guardar la orden: {0}', $e->getMessage()));
        }
    }

    // ✅ Relación corregida aquí también
    $pacientesData = $this->Ordenes->Pacientes1->find('all')
        ->select(['id'])
        ->toArray();

    $doctores = $this->Ordenes->Doctores->find('list')->all();
    $tratamientosData = $this->Ordenes->OrdenesTratamientos->Tratamientos->find()
        ->select(['id', 'nombre', 'costo'])
        ->toArray();

    $this->set(compact('ordene', 'pacienteSeleccionado', 'doctores', 'tratamientosData', 'pacientesData'));
}

    /**
     * Delete method
     *
     * @param string|null $id Ordene id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ordene = $this->Ordenes->get($id);
        if ($this->Ordenes->delete($ordene)) {
            $this->Flash->success(__('The ordene has been deleted.'));
        } else {
            $this->Flash->error(__('The ordene could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

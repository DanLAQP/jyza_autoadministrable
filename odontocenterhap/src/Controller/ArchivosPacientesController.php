<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Filesystem\Folder;

/**
 * ArchivosPacientes Controller
 *
 * @property \App\Model\Table\ArchivosPacientesTable $ArchivosPacientes
 */
class ArchivosPacientesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ArchivosPacientes->find()
            ->contain(['Pacientes1']);
        $archivosPacientes = $this->paginate($query);

        $this->set(compact('archivosPacientes'));
    }

    /**
     * View method
     *
     * @param string|null $id Archivos Paciente id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $archivosPaciente = $this->ArchivosPacientes->get($id, contain: ['Pacientes1']);
        $this->set(compact('archivosPaciente'));
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
//     public function add()
// {
//     $archivosPaciente = $this->ArchivosPacientes->newEmptyEntity();

//     if ($this->request->is('post')) {
//         $data = $this->request->getData();

//         // Manejo del archivo subido
//         $archivo = $data['ruta_archivo'];
//         if (!empty($archivo->getClientFilename())) {
//             // Crear directorio si no existe
//             $pacienteId = $data['paciente_id'];
//             $tipo = $data['tipo']; // 'radiografia' o 'foto_avance'
//             $dir = WWW_ROOT . "uploads/pacientes/{$pacienteId}/{$tipo}s/";

//             // Crear carpeta manualmente si no existe
//             if (!is_dir($dir)) {
//                 mkdir($dir, 0755, true);
//             }

//             // Generar un nombre único para el archivo
//             $filename = time() . '_' . $archivo->getClientFilename();
//             $filepath = $dir . $filename;

//             // Guardar el archivo en el servidor
//             $archivo->moveTo($filepath);

//             // Guardar la ruta del archivo en los datos
//             $data['ruta_archivo'] = "uploads/pacientes/{$pacienteId}/{$tipo}s/{$filename}";
//         }

//         // Crear la entidad con los datos del formulario
//         $archivosPaciente = $this->ArchivosPacientes->patchEntity($archivosPaciente, $data);

//         // Guardar en la base de datos
//         if ($this->ArchivosPacientes->save($archivosPaciente)) {
//             $this->Flash->success(__('El archivo ha sido subido y guardado correctamente.'));
//             return $this->redirect(['action' => 'index']);
//         }

//         $this->Flash->error(__('El archivo no pudo ser subido. Por favor, inténtelo nuevamente.'));
//     }

//     $pacientes = $this->ArchivosPacientes->Pacientes->find('list')->all();

//     $this->set(compact('archivosPaciente', 'pacientes'));
//     // Usar un layout diferenciado para solicitudes normales o AJAX
//     if ($this->request->is('ajax')) {
//         $this->viewBuilder()->setLayout('ajax');
//     } else {
//         $this->viewBuilder()->setLayout('default');
//     }
// }
public function add($paciente_id = null)
{
    $archivosPaciente = $this->ArchivosPacientes->newEmptyEntity();

    // Si se pasa un paciente_id, asignarlo a la entidad
    if ($paciente_id) {
        $archivosPaciente->paciente_id = $paciente_id;
    }

    if ($this->request->is('post')) {
        $data = $this->request->getData();

        // Manejo del archivo subido
        $archivo = $data['ruta_archivo'];
        if (!empty($archivo->getClientFilename())) {
            // Crear directorio si no existe
            $tipo = $data['tipo']; // 'radiografia' o 'foto_avance'
            $dir = WWW_ROOT . "uploads/pacientes/{$paciente_id}/{$tipo}s/";

            // Crear carpeta si no existe
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            // Generar un nombre único para el archivo
            $filename = time() . '_' . $archivo->getClientFilename();
            $filepath = $dir . $filename;

            // Guardar el archivo en el servidor
            $archivo->moveTo($filepath);

            // Guardar la ruta del archivo en los datos
            $data['ruta_archivo'] = "uploads/pacientes/{$paciente_id}/{$tipo}s/{$filename}";
        }

        // Crear la entidad con los datos del formulario
        $archivosPaciente = $this->ArchivosPacientes->patchEntity($archivosPaciente, $data);

        // Guardar en la base de datos
        if ($this->ArchivosPacientes->save($archivosPaciente)) {
            $this->Flash->success(__('El archivo ha sido subido y guardado correctamente.'));

            // Redirigir al view del paciente
            if ($paciente_id) {
                return $this->redirect(['controller' => 'Pacientes1', 'action' => 'view', $paciente_id, '#' => 'archivos']);
            }

            // Si no hay paciente_id, redirigir al índice
            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->error(__('El archivo no pudo ser subido. Por favor, inténtelo nuevamente.'));
    }

    // Cargar la lista de pacientes solo si no hay paciente_id
    $pacientes = $paciente_id ? null : $this->ArchivosPacientes->Pacientes->find('list')->all();
    $this->set(compact('archivosPaciente', 'pacientes'));

    // Configurar el layout según el tipo de solicitud
    if ($this->request->is('ajax')) {
        $this->viewBuilder()->setLayout('ajax');
    } else {
        $this->viewBuilder()->setLayout('default');
    }
}

    

    /**
     * Edit method
     *
     * @param string|null $id Archivos Paciente id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
{
    $archivosPaciente = $this->ArchivosPacientes->get($id, contain: []);

    if ($this->request->is(['patch', 'post', 'put'])) {
        $data = $this->request->getData();

        // Manejo del archivo subido
        $archivo = $data['ruta_archivo'];
        if (!empty($archivo->getClientFilename())) {
            // Ruta del archivo existente
            $oldFilePath = WWW_ROOT . $archivosPaciente->ruta_archivo;

            // Crear directorio para el nuevo archivo
            $pacienteId = $data['paciente_id'];
            $tipo = $data['tipo'];
            $dir = WWW_ROOT . "uploads/pacientes/{$pacienteId}/{$tipo}s/";

            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            // Generar nombre para el nuevo archivo
            $filename = time() . '_' . $archivo->getClientFilename();
            $filepath = $dir . $filename;

            // Guardar el nuevo archivo en el servidor
            $archivo->moveTo($filepath);

            // Guardar la nueva ruta en los datos
            $data['ruta_archivo'] = "uploads/pacientes/{$pacienteId}/{$tipo}s/{$filename}";

            // Eliminar el archivo antiguo si existe
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        } else {
            // Mantener la ruta del archivo existente si no se sube uno nuevo
            unset($data['ruta_archivo']);
        }

        // Crear la entidad con los datos actualizados
        $archivosPaciente = $this->ArchivosPacientes->patchEntity($archivosPaciente, $data);

        // Guardar en la base de datos
        if ($this->ArchivosPacientes->save($archivosPaciente)) {
            $this->Flash->success(__('El archivo ha sido actualizado correctamente.'));

            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->error(__('El archivo no pudo ser actualizado. Por favor, inténtelo nuevamente.'));
    }

    $pacientes = $this->ArchivosPacientes->Pacientes->find('list')->all();

    $this->set(compact('archivosPaciente', 'pacientes'));
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
     * @param string|null $id Archivos Paciente id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $archivosPaciente = $this->ArchivosPacientes->get($id);
        if ($this->ArchivosPacientes->delete($archivosPaciente)) {
            $this->Flash->success(__('The archivos paciente has been deleted.'));
        } else {
            $this->Flash->error(__('The archivos paciente could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

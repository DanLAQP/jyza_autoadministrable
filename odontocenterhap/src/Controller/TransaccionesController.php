<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Datasource\Exception\RecordNotFoundException;
/**
 * Transacciones Controller
 *
 * @property \App\Model\Table\TransaccionesTable $Transacciones
 */
class TransaccionesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Transacciones->find()
            ->contain(['Productos', 'Users'])
            ->order(['Transacciones.fecha_transaccion' => 'DESC']); // Ordenar por fecha más reciente

        $transacciones = $this->paginate($query);

        $this->set(compact('transacciones'));
    }


    /**
     * View method
     *
     * @param string|null $id Transaccione id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $transaccione = $this->Transacciones->get($id, contain: ['Productos', 'Users']);
        $this->set(compact('transaccione'));
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
    public function add()
    {
        $transaccione = $this->Transacciones->newEmptyEntity();  // Creamos la entidad vacía
        $productos = $this->Transacciones->Productos->find('list')->toArray();
        $users = $this->Transacciones->Users->find('list')->all();


        // Obtener stock de productos
        $productosConStock = [];
        foreach ($productos as $id => $nombre) {
            $producto = $this->Transacciones->Productos->get($id);
            $productosConStock[$id] = [
                'nombre' => $nombre,
                'stock' => $producto->cantidad
            ];
        }

        // Si es una solicitud POST (cuando el formulario es enviado)
        if ($this->request->is('post')) {
            $transaccione = $this->Transacciones->patchEntity($transaccione, $this->request->getData());

            // Asignar el valor de fecha_transaccion como el timestamp actual
            $transaccione->fecha_transaccion = date('Y-m-d H:i:s');  // Asignamos la fecha y hora actuales

            // Verificamos el tipo de transacción y actualizamos el stock
            $producto = $this->Transacciones->Productos->get($transaccione->producto_id);  // Obtener el producto seleccionado
            if ($transaccione->tipo_transaccion === 'entrada') {
                // Aumentamos el stock
                $producto->cantidad += $transaccione->cantidad;
            } elseif ($transaccione->tipo_transaccion === 'salida') {
                // Verificamos si hay suficiente stock
                if ($producto->cantidad >= $transaccione->cantidad) {
                    // Disminuimos el stock
                    $producto->cantidad -= $transaccione->cantidad;
                } else {
                    $this->Flash->error(__('No hay suficiente stock para realizar esta salida.'));
                    return;
                }
            }

            // Guardamos el producto actualizado
            if ($this->Transacciones->Productos->save($producto)) {
                // Guardar la transacción
                if ($this->Transacciones->save($transaccione)) {
                    $this->Flash->success(__('La transacción ha sido guardada.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('No se pudo guardar la transacción.'));
                }
            } else {
                $this->Flash->error(__('No se pudo actualizar el stock del producto.'));
            }
        }

        // Pasar los productos con stock a la vista
        $this->set(compact('transaccione', 'productosConStock', 'users'));
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
     * @param string|null $id Transaccione id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $transaccione = $this->Transacciones->find()
        ->contain(['Productos', 'Users'])  // Usar `find()` con `contain` para incluir asociaciones
        ->where(['Transacciones.id' => $id])
        ->first();
        $users = $this->Transacciones->Users->find('list')->all();
        

        if ($this->request->is(['post', 'patch', 'put'])) {
            $data = $this->request->getData();
            $transaccione = $this->Transacciones->patchEntity($transaccione, $data);

            if ($transaccione->getErrors()) {
                $this->Flash->error(__('Errores en los datos del formulario.'));
                return;
            }

            $producto = $this->Transacciones->Productos->get($transaccione->producto_id);
            $producto->cantidad = $data['nuevo_stock']; // Usamos el stock calculado en el frontend

            $connection = $this->Transacciones->getConnection();
            $connection->begin();
            try {
                if (!$this->Transacciones->Productos->save($producto)) {
                    $this->Flash->error(__('Error al actualizar el stock del producto.'));
                    $connection->rollback();
                    return;
                }

                if (!$this->Transacciones->save($transaccione)) {
                    $this->Flash->error(__('Error al actualizar la transacción.'));
                    $connection->rollback();
                    return;
                }

                $connection->commit();
                $this->Flash->success(__('La transacción ha sido actualizada.'));
                return $this->redirect(['action' => 'index']);
            } catch (\Exception $e) {
                $connection->rollback();
                $this->Flash->error(__('Ocurrió un error: ' . $e->getMessage()));
            }
        }

        // 🔹 Aseguramos que `$users` se pase a la vista
        $this->set(compact('transaccione', 'users'));
        // Usar un layout diferenciado para solicitudes normales o AJAX
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        } else {
            $this->viewBuilder()->setLayout('default');
        }
    }
}

<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use App\Service\ImageService;
use Cake\Log\Log;

class ContentController extends AppController
{
    public function index()
    {
        // Listar secciones de contenido para gestionar
        $contentSections = \Cake\ORM\TableRegistry::getTableLocator()->get('ContentSections')
            ->find()
            ->order(['sort_order' => 'ASC'])
            ->toArray();

        $this->set('contentSections', $contentSections);
        $this->set('title', 'Panel Autoadministrable');
    }

    public function edit($id = null)
    {
        $this->request->allowMethod(['get', 'post', 'put']);

        $contentSectionsTable = \Cake\ORM\TableRegistry::getTableLocator()->get('ContentSections');
        $contentBlocksTable = \Cake\ORM\TableRegistry::getTableLocator()->get('ContentBlocks');
        $contentImagesTable = \Cake\ORM\TableRegistry::getTableLocator()->get('ContentImages');
        $imageService = new ImageService();

        $section = $contentSectionsTable->find()
            ->where(['ContentSections.id' => $id])
            ->contain(['ContentBlocks' => function ($q) {
                return $q->order(['ContentBlocks.sort_order' => 'ASC']);
            }])
            ->first();

        if (!$section) {
            $this->Flash->error('Sección no encontrada');
            return $this->redirect(['action' => 'index']);
        }

        $sectionImages = $contentImagesTable->find()
            ->where(['section_id' => $section->id])
            ->orderBy(['created' => 'DESC'])
            ->all()
            ->toArray();

        if ($this->request->is(['post', 'put'])) {
            // Log de diagnóstico: qué archivos y datos llegaron
            try {
                Log::info('ContentController::edit REQUEST METHOD', ['method' => $this->request->getMethod()]);
                Log::info('ContentController::edit CONTENT_TYPE', ['content_type' => $_SERVER['CONTENT_TYPE'] ?? 'N/A']);
                Log::info('ContentController::edit FILES COUNT', ['count' => count($_FILES), 'keys' => array_keys($_FILES)]);
                Log::info('ContentController::edit _FILES DATA', $_FILES ?? []);
            } catch (\Throwable $e) {
                Log::error('ContentController::edit error getting request data', ['error' => $e->getMessage()]);
            }

            // Persistir volcado de diagnóstico para verificar uploads incluso si logging no llega
            try {
                $debugDump = '[' . date('c') . '] ' . ($_SERVER['REMOTE_ADDR'] ?? 'cli') . "\n" . var_export(['_FILES' => $_FILES ?? [], 'data' => $this->request->getData()], true) . "\n---\n";
                file_put_contents(TMP . 'upload_debug.txt', $debugDump, FILE_APPEND | LOCK_EX);
            } catch (\Throwable $e) {
                Log::error('ContentController::edit failed to write upload_debug.txt', ['error' => $e->getMessage()]);
            }

            $data = $this->request->getData();
            $saved = 0;

            // DEBUG: Log completo de los datos recibidos
            Log::debug('ContentController::edit POST data received', [
                'has_image_file' => !empty($data['image_file']),
                'has_image_files' => !empty($data['image_files']),
                'image_files_count' => is_array($data['image_files'] ?? []) ? count($data['image_files']) : 0,
                'blocks_count' => is_array($data['blocks'] ?? []) ? count($data['blocks']) : 0,
            ]);

            // Procesar carga única (formulario superior)
            $uploadedFile = $data['image_file'] ?? null;
            if ($uploadedFile && method_exists($uploadedFile, 'getError') && $uploadedFile->getError() === UPLOAD_ERR_OK) {
                $identity = $this->Authentication->getIdentity();
                $userId = $identity ? (int)$identity->get('id') : 1;
                $assignBlockId = $data['assign_block_id'] ?? null;

                Log::info('ContentController::edit detected image_file upload', ['section' => $section->id, 'assign_block_id' => $assignBlockId]);

                try {
                    $storedImage = $imageService->processAndStore(
                        $uploadedFile,
                        $userId,
                        (int)$section->id,
                        is_numeric($assignBlockId) ? (int)$assignBlockId : null
                    );

                    if (!empty($storedImage['id'])) {
                        $imageEntity = $contentImagesTable->get((int)$storedImage['id']);
                        $imageEntity->set('title', (string)($data['image_title'] ?? ''));
                        $imageEntity->set('alt_text', (string)($data['image_alt'] ?? ''));
                        $contentImagesTable->save($imageEntity);

                        // Si el usuario indicó asignar la imagen a un bloque, actualizar el bloque
                        if (is_numeric($assignBlockId)) {
                            try {
                                $blockToAssign = $contentBlocksTable->get((int)$assignBlockId);
                                // Guardar el ID de la imagen, no la URL
                                $blockToAssign->set('content', (string)$storedImage['id']);
                                if (!$contentBlocksTable->save($blockToAssign)) {
                                    $contentBlocksTable->updateAll(
                                        ['content' => (string)$storedImage['id']],
                                        ['id' => (int)$assignBlockId]
                                    );
                                }
                                $saved++;
                            } catch (\Throwable $e) {
                                $this->Flash->error('Imagen subida pero no se pudo asignar al bloque: ' . $e->getMessage());
                                Log::error('ContentController::edit assign error', ['error' => $e->getMessage()]);
                            }
                        }

                        $this->Flash->success('Imagen subida correctamente.');
                        Log::info('ContentController::edit image stored', ['stored' => $storedImage]);
                    }
                } catch (\Throwable $e) {
                    Log::error('ContentController::edit image upload error', ['error' => $e->getMessage()]);
                    $this->Flash->error('No se pudo subir la imagen: ' . $e->getMessage());
                }
            }

            // Procesar bloques y posibles subidas por bloque
            if (!empty($data['blocks']) && is_array($data['blocks'])) {
                foreach ($data['blocks'] as $blockId => $content) {
                    Log::debug('ContentController::edit processing block', ['blockId' => $blockId, 'content' => $content]);

                    /** @var \App\Model\Entity\ContentBlock $block */
                    $block = $contentBlocksTable->get($blockId);

                    // Si existe un archivo subido específicamente para este bloque, procesarlo
                    $uploadedBlocks = $data['image_files'] ?? [];
                    $uploadedForBlock = $uploadedBlocks[$blockId] ?? null;

                    Log::debug('ContentController::edit checking image upload', [
                        'blockId' => $blockId,
                        'hasUploadedFile' => !empty($uploadedForBlock),
                        'isValidFile' => $uploadedForBlock && method_exists($uploadedForBlock, 'getError'),
                    ]);

                    if ($uploadedForBlock && method_exists($uploadedForBlock, 'getError') && $uploadedForBlock->getError() === UPLOAD_ERR_OK) {
                        Log::info('ContentController::edit detected image_files upload for block', ['blockId' => $blockId, 'filename' => $uploadedForBlock->getClientFilename()]);
                        try {
                            $identity = $this->Authentication->getIdentity();
                            $userId = $identity ? (int)$identity->get('id') : 1;
                            $stored = $imageService->processAndStore($uploadedForBlock, $userId, (int)$section->id, (int)$blockId);
                            // Guardar el ID de la imagen, no la URL
                            Log::info('ContentController::edit imageService returned', ['stored' => $stored]);
                            if (!empty($stored['id'])) {
                                $block->set('content', (string)$stored['id']);
                                Log::info('ContentController::edit set block content to image id', ['blockId' => $blockId, 'imageId' => $stored['id']]);
                            } else {
                                Log::warning('ContentController::edit store returned without id', ['stored' => $stored]);
                            }
                        } catch (\Throwable $e) {
                            Log::error('ContentController::edit error processing image for block', ['blockId' => $blockId, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
                            $this->Flash->error('No se pudo procesar la imagen para el bloque ' . $blockId . ': ' . $e->getMessage());
                        }
                    } else {
                        // Si no hay archivo, usar el contenido enviado (puede ser id o url)
                        if ($block->block_type === 'image' && is_numeric($content)) {
                            $existingImage = $contentImagesTable->find()
                                ->where(['id' => (int)$content, 'is_active' => true])
                                ->first();

                            if ($existingImage) {
                                // Guardar el ID, no la URL
                                $block->set('content', (string)$existingImage->id);
                            } else {
                                $block->set('content', $content);
                            }
                        } else {
                            $block->set('content', $content);
                        }
                    }

                    if ($contentBlocksTable->save($block)) {
                        $saved++;
                    } else {
                        if ($block->block_type === 'image' && !empty($block->content)) {
                            $contentBlocksTable->updateAll(
                                ['content' => (string)$block->content],
                                ['id' => (int)$blockId]
                            );
                            $saved++;
                            continue;
                        }

                        Log::error('ContentController::edit block save failed', [
                            'blockId' => $blockId,
                            'errors' => $block->getErrors(),
                            'content' => $block->content,
                            'blockType' => $block->block_type,
                        ]);
                    }
                }
            }

            // Invalidate cache if any
            try {
                \Cake\Cache\Cache::delete("content_section_{$section->slug}", 'api');
            } catch (\Exception $e) {
                // ignore
            }

            $this->Flash->success("Se actualizaron {$saved} bloques.");
            return $this->redirect(['action' => 'edit', $id]);
        }

        $this->set(compact('section', 'sectionImages'));
    }
}

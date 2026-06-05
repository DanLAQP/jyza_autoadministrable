<?php
/**
 * Routes API - Agregar al archivo config/routes.php
 * 
 * Estas rutas deben agregarse al final del archivo o en la sección correspondiente
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

// En el scope del router principal, agregar:

$routes->scope('/api', function (RouteBuilder $builder): void {
    $builder->setExtensions(['json']);

    // API v1 - Rutas públicas de contenido
    $builder->scope('/v1', function (RouteBuilder $builder): void {
        // Obtener contenido de una sección específica
        $builder->get('/content/{section}', [
            'controller' => 'Api/V1/Content',
            'action' => 'getSectionContent',
            '_name' => 'api_content_section',
        ]);

        // Obtener todo el contenido (para build de Astro)
        $builder->get('/content', [
            'controller' => 'Api/V1/Content',
            'action' => 'getAllContent',
            '_name' => 'api_content_all',
        ]);

        // Rutas adicionales para futuras APIs
        $builder->resources('Products', [
            'only' => ['index', 'view'],
            '_name' => 'api_products',
        ]);
    });
});

// Rutas Administrativas
$routes->scope('/admin', function (RouteBuilder $builder): void {
    $builder->setExtensions(['json', 'html']);

    // Gestión de Contenido
    $builder->get('/content', [
        'controller' => 'Admin/Content',
        'action' => 'index',
        '_name' => 'admin_content_index',
    ]);

    $builder->get('/content/edit/{id}', [
        'controller' => 'Admin/Content',
        'action' => 'edit',
        '_name' => 'admin_content_edit',
    ])
    ->setPass(['id']);

    $builder->post('/content/edit/{id}', [
        'controller' => 'Admin/Content',
        'action' => 'edit',
        '_name' => 'admin_content_update',
    ])
    ->setPass(['id']);

    $builder->get('/content/history/{blockId}', [
        'controller' => 'Admin/Content',
        'action' => 'history',
        '_name' => 'admin_content_history',
    ])
    ->setPass(['blockId']);

    $builder->post('/content/restore', [
        'controller' => 'Admin/Content',
        'action' => 'restore',
        '_name' => 'admin_content_restore',
    ]);

    $builder->post('/content/upload-image', [
        'controller' => 'Admin/Content',
        'action' => 'uploadImage',
        '_name' => 'admin_content_upload_image',
    ]);

    // Gestión de Usuarios (existente)
    $builder->resources('Users', [
        '_name' => 'admin_users',
    ]);
});

// Ruta por defecto (login)
$routes->connect('/', ['controller' => 'Users', 'action' => 'login']);
$routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
$routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);

// Rutas por defecto con inflected routes
$routes->fallbacks(DashedRoute::class);

<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CursosFixture
 */
class CursosFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public array $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'usuario_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'titulo' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => ''],
        'descripcion' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'miniatura' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => ''],
        'nivel' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => 'basico', 'comment' => ''],
        'categoria' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => ''],
        'estado' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => 'borrador', 'comment' => ''],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
    ];

    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'usuario_id' => 1,
                'titulo' => 'Curso de Prueba',
                'descripcion' => 'Descripcion del curso',
                'miniatura' => 'img.jpg',
                'nivel' => 'basico',
                'categoria' => 'test',
                'estado' => 'activo',
                'created' => '2025-12-08 00:37:41',
                'modified' => '2025-12-08 00:37:41',
            ],
        ];
        parent::init();
    }
}

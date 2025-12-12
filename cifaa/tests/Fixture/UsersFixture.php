<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public array $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'username' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => ''],
        'password' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => ''],
        'rol' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'estado' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => 'activo', 'comment' => ''],
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
                'username' => 'admin',
                'password' => 'password', // admin
                'rol' => 1,
                'created' => '2025-02-05 05:16:33',
                'modified' => '2025-02-05 05:16:33',
            ],
            [
                'id' => 3,
                'username' => 'student',
                'password' => 'password', // student
                'rol' => 3,
                'created' => '2025-02-05 05:16:33',
                'modified' => '2025-02-05 05:16:33',
            ],
             [
                'id' => 2,
                'username' => 'teacher',
                'password' => 'password', // teacher
                'rol' => 2,
                'created' => '2025-02-05 05:16:33',
                'modified' => '2025-02-05 05:16:33',
            ],
        ];
        parent::init();
    }
}

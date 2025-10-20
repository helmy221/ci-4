<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateTabelRoles extends Migration
{
    public function up()
    {
        $fields = [
            'display_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'name',
            ],
        ];

        $this->forge->addColumn('master_roles', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('master_roles', ['display_name']);
    }
}

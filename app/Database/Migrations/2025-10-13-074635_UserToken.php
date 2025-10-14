<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserToken extends Migration
{
    public function up()
    {
        // Master User
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint'  => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_user'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'jti'        => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
            'issued_at'  => ['type' => 'TIMESTAMP ', 'null' => true],
            'expires_at' => ['type' => 'TIMESTAMP ', 'null' => true],
            'revoked'    => ['type' => 'boolean', 'default' => false, 'null' => false,],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('user_tokens');
    }

    public function down()
    {
        $this->forge->dropTable('user_tokens');
    }
}

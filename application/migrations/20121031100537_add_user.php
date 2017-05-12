<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_user extends CI_Migration {

    public function up() {
    	$field = array(
            'id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
            ),
            'name' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100',
            ),
            'password' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '255',
            ),
        );
        
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('users');
    }

    public function down(){
        $this->dbforge->drop_table('users');
    }
}
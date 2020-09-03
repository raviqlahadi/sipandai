<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_Opd extends CI_Migration {
    public function up(){
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '300',
            ),
            'address' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            'code' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('opd');
    }

    public function down(){
        $this->dbforge->drop_table('opd');
    }
}

?>
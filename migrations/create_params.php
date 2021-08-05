<?php
class CreateParam extends Migrations {
    function _init_() {
        $this->_fields = [
            ['field'=>'id', 'type'=>'INTEGER(11) AUTO_INCREMENT PRIMARY KEY', 'null'=>'false'],
            ['field'=>'name', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'150'],
            ['field'=>'value', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'],
            ['field'=>'created_at', 'type'=>'INT', 'null'=>'false', 'limit'=>'11'],
            ['field'=>'updated_at', 'type'=>'INT', 'null'=>'false', 'limit'=>'11']
        ];
    }

    function up() {
        $this->Create_Table();
    }

    function down() {
        $this->Drop_Table();
    }
}

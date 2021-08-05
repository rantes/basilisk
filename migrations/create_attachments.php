<?php
class CreateAttachment extends Migrations {
    function _init_() {
        $this->_fields = [
            ['field'=>'id', 'type'=>'INTEGER(11) AUTO_INCREMENT PRIMARY KEY', 'null'=>'false'],
            ['field'=>'issue_id', 'type'=>'INT', 'null'=>'false', 'limit'=>'11'],
            ['field'=>'type', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'50'],
            ['field'=>'path', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'],
            ['field'=>'name', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'150'],
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

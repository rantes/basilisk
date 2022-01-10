<?php
class CreateIssue extends Migrations {
    function _init_() {
        $this->_fields = [
            ['field' => 'id', 'type' => 'INTEGER', 'autoincrement' => true, 'primary' => true],
            ['field'=>'project_id', 'type'=>'INTEGER', 'null'=>'false', 'limit'=>'11'],
            ['field'=>'points', 'type'=>'INTEGER', 'null'=>'false', 'limit'=>'3'],
            ['field'=>'title', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'],
            ['field'=>'description', 'type'=>'TEXT', 'null'=>'false'],
            ['field'=>'created_at', 'type'=>'INTEGER', 'null'=>'false', 'limit'=>'11'],
            ['field'=>'updated_at', 'type'=>'INTEGER', 'null'=>'false', 'limit'=>'11']
        ];
    }

    function up() {
        $this->Create_Table();
    }

    function down() {
        $this->Drop_Table();
    }
}

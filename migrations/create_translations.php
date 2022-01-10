<?php
class CreateTranslation extends Migrations {
    public function _init_() {
            $this->_fields = [
            ['field' => 'id', 'type' => 'INTEGER', 'autoincrement' => true, 'primary' => true],
            ['field'=>'domain', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'60'],
            ['field'=>'keyid', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'],
            ['field'=>'locale', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'10'],
            ['field'=>'translation', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'],
            ['field' => 'created_at', 'type' => 'INTEGER', 'null' => FALSE, 'default' => '0'],
            ['field' => 'updated_at', 'type' => 'INTEGER', 'null' => FALSE, 'default' => '0']
        ];
    }

    public function up() {
        $this->Create_Table();
        $this->Add_Single_Index('keyid');
        $this->Add_Single_Index('domain');
        $this->Add_Single_Index('locale');
    }

    public function down() {
        $this->Drop_Table();
        $this->Remove_Index('keyid');
        $this->Remove_Index('domain');
        $this->Remove_Index('locale');
    }
}

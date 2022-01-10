<?php
class testParamModel extends dumboTests {

    public function beforeEach() {
        $this->_migrateTables([
            'params'
        ]);
    }

    public function modelExistTest() {
        $this->describe('Should exists the Param Model');
        $param = $this->Param->Niu();

        $this->assertFalse(empty($param), 'Assert there is a param model instance');
        $this->assertTrue(is_a($param, 'ActiveRecord'), 'Assert the instance is an ActiveRecord instance');
    }
}
?>
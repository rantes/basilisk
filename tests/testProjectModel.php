<?php
class testProjectModel extends dumboTests {

    public function beforeEach() {
        $this->_migrateTables([
            'projects'
        ]);
    }

    public function modelExistTest() {
        $this->describe('Should exists the Project Model');
        $project = $this->Project->Niu();

        $this->assertFalse(empty($project), 'Assert there is a project model instance');
        $this->assertTrue(is_a($project, 'ActiveRecord'), 'Assert the instance is an ActiveRecord instance');
    }
}
?>
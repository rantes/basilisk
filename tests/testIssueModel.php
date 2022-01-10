<?php
class testIssueModel extends dumboTests {

    public function beforeEach() {
        $this->_migrateTables([
            'issues'
        ]);
    }

    public function modelExistTest() {
        $this->describe('Should exists the issue Model');
        $issue = $this->Issue->Niu();

        $this->assertFalse(empty($issue), 'Assert there is a issue model instance');
        $this->assertTrue(is_a($issue, 'ActiveRecord'), 'Assert the instance is an ActiveRecord instance');
    }
}
?>
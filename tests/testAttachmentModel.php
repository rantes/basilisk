<?php
class testAttachmentModel extends dumboTests {

    public function beforeEach() {
        $this->_migrateTables([
            'attachments'
        ]);
    }

    public function modelExistTest() {
        $this->describe('Should exists the attachment Model');
        $attachment = $this->Attachment->Niu();

        $this->assertFalse(empty($attachment), 'Assert there is a attachment model instance');
        $this->assertTrue(is_a($attachment, 'ActiveRecord'), 'Assert the instance is an ActiveRecord instance');
    }
}
?>
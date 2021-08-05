<?php
class UserController extends Page {
    public $layout = 'layout';
    public $noTemplate = ['create','delete'];
    public $helper = ['Menu'];

    public function indexAction() {
        $_SESSION['admin'] = 1;
        $this->menuLinks = adminMenu();
        $this->data = $this->User->Find();
    }

    public function addeditAction() {
        if (isset($this->params['id'])):
            $this->data = $this->User->Find($this->params['id']);
        else:
            $this->data = $this->User->Niu();
        endif;
    }

    public function deleteAction() {
        if (isset($this->params['id'])):
            $this->data = $this->User->Delete($this->params['id']);
        endif;

        header('Location: '.INST_URI.'user/index/');
    }

    public function createAction() {
        if (isset($_POST['user'])):
            $obj = $this->User->Niu($_POST['user']);
            $obj->Save() or die($obj->_error);
        endif;

        header('Location: '.INST_URI.'user/index/');
    }
}

<?php
require_once INST_PATH.'app/controllers/admin_base_trait.php';
class AdminController extends Page {
    use AdminBaseTrait;

    public function __construct() {
        $this->_init();
    }

    public function indexAction() {
        $this->render = ['text'=>'noop'];
    }

    public function usersAction() {
        $this->users = $this->User->Find();
    }

    public function deleteuserAction() {
        $this->_model = 'user';
        $this->deleteregAction();
    }

    public function useraddregAction() {
        $this->_model = 'user';
        $this->addregAction();
    }

    public function useraddeditAction() {
        $this->layout = false;
        if(empty($this->params['id'])):
            $this->data = $this->ProjectGroup->Niu();
        else:
            $this->data = $this->ProjectGroup->Find($this->params['id']);
        endif;
    }
}
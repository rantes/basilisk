<?php
require_once INST_PATH.'app/controllers/common_trait.php';
class IndexController extends Page {
    use CommonTrait;

    public $layout = 'layout';
    public $helper = ['Sessions','Menu'];
    public $exceptsBeforeFilter = [
        'actions' => 'login,logout,signin'
    ];
    public $noTemplate = ['logout'];

    public function before_filter() {
        Require_login();
        $this->menuLinks = generalMenu();
    }

    public function indexAction() {
        $this->render = ['text'=>'noop'];
    }

    public function loginAction() {
        $this->layout = false;
        !empty($_SESSION['user']) and header('Location: /login/index');
    }

}
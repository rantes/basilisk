<?php
require_once INST_PATH.'app/controllers/admin_base_trait.php';
class IndexController extends Page {
    use AdminBaseTrait;

    public $exceptsBeforeFilter = [
        'actions' => 'login,logout,signin'
    ];

    public function __construct() {
        $this->_init();
    }

    public function before_filter() {
        Require_login();
        $this->menuLinks = generalMenu();
    }

    public function indexAction() {
        $this->render = ['text'=>'noop'];
    }

    public function loginAction() {
        $this->layout = false;
    }
    public function signinAction() {
        $code = HTTP_401;

        if (!empty($_POST['e']) and !empty($_POST['p'])):
            $id = $this->User->login($_POST['e'], $_POST['p']);
            $id > 0 and ($code = HTTP_202) and ($_SESSION['user'] = $id);
        endif;

        http_response_code($code);
        $this->respondToAJAX('{}');
    }
    /**
    * Destroy all registered information of a session and redirect to the login page.
    */
    public function logoutAction() {
        $this->layout = false;
        php_sapi_name() !== 'cli' && session_destroy();
        $_SESSION = null;
        unset($_SESSION);
        header('Location: /index/login');
    }
}
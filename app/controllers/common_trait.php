<?php

trait CommonTrait {
    private $_loginLevel = 1;
    public $noTemplate = ['logout'];

    public function loginAction() {
        $this->layout = false;
        empty($_SESSION['user']) or header("Location: /{$this->controller}/index");
    }

    public function signinAction() {
        $code = HTTP_401;

        if (!empty($_POST['e']) and !empty($_POST['p'])):
            $id = $this->User->login($_POST['e'], $_POST['p'], $this->_loginLevel);
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
        php_sapi_name() !== 'cli' and session_destroy();
        $_SESSION = null;
        unset($_SESSION);
        header("Location: /{$this->controller}/login");
    }
}
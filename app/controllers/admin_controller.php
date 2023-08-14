<?php
require_once INST_PATH.'app/controllers/admin_base_trait.php';
require_once INST_PATH.'app/controllers/common_trait.php';
class AdminController extends Page {
    use CommonTrait;
    use AdminBaseTrait;

    public $layout = 'layout';
    public $helper = ['Sessions','Menu'];
    public $exceptsBeforeFilter = [
        'actions' => 'login,logout,signin'
    ];

    public function __construct() {
        parent::__construct();
        $this->exceptsBeforeFilter = [
            'actions' => 'signin,login,logout'
        ];

        textdomain('translations');
    }

    private function _additional_before_filter() {
        $this->_actions = [
            'users',
            'projects',
            'estates',
            'translations'
        ];
    }

    public function indexAction() {
        $this->render = ['text'=>'noop'];
        $this->pageTitle = 'Admin';
    }

    public function buildlanguagesAction() {
        chdir(INST_PATH);
        system('dumbo run background/gettext > /dev/null 2>&1 &');
        $this->respondToAJAX('{}');
    }
}
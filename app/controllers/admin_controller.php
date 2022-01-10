<?php
require_once INST_PATH.'app/controllers/admin_base_trait.php';
require_once INST_PATH.'app/controllers/common_trait.php';
class AdminController extends Page {
    use AdminBaseTrait;
    use CommonTrait;

    public $layout = 'layout';
    public $helper = ['Sessions','Menu'];

    public function __construct() {
        parent::__construct();

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
    }

    public function buildlanguagesAction() {
        chdir(INST_PATH);
        system('dumbo run background/gettext > /dev/null 2>&1 &');
        $this->respondToAJAX('{}');
    }
}
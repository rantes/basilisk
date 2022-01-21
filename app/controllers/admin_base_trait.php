<?php

trait AdminBaseTrait {
    private $_model = '';
    private $_model_camelized = '';
    private $_response = [
        'd' => [],
        'message' => ''
    ];
    private $_is_routed = false;
    private $_actions = [];
    private $_listConditions = '';

    private function _additional_before_filter() {}

    private function _prepare_data() {
        if(in_array($this->action, $this->_actions)):
            $this->_model = Singulars($this->action);
            $this->_model_camelized = Camelize($this->_model);
            $this->_is_routed = true;
            $this->action = 'landing';
        endif;
    }

    private function _edit_reg() {
        $this->layout = false;
        if(empty($this->params[1])):
            throw new Exception('ID param must be given');
        else:
            $this->render = ['file'=>"{$this->controller}/{$this->_model}_addedit.phtml"];
            $this->data = $this->{$this->_model_camelized}->Find($this->params[1]);
        endif;
    }

    private function _add_reg() {
        $this->layout = false;
        $this->render = ['file'=>"{$this->controller}/{$this->_model}_addedit.phtml"];
        $this->data = $this->{$this->_model_camelized}->Niu();
    }

    private function _list_regs() {
        $this->render = ['file'=>"{$this->controller}/{$this->_model}_list.phtml"];
        $conditions = '';
        $this->searchterm = '';

        if(!empty($_POST['search']) and !empty($_POST['search']['term']) and !empty($_POST['search']['fields'])):
            $this->searchterm = $_POST['search']['term'];
            while(null !== ($field = array_shift($_POST['search']['fields']))):
                empty($conditions) or ($conditions = "{$conditions} OR ");
                $conditions = "{$conditions}`{$field}` LIKE '%{$_POST['search']['term']}%'";
            endwhile;
            empty($conditions) or ($conditions = " ({$conditions})");
        endif;

        $conditions = "{$this->_listConditions}{$conditions}";
        empty($conditions) and ($conditions = null);

        $this->data = $this->{$this->_model_camelized}->Paginate(['conditions'=>$conditions]);
    }

    private function _delete_reg() {
        $code = HTTP_422;
        if (!empty($this->_model) and !empty($this->params['id'])):
            $obj = $this->{$this->_model_camelized}->Find((integer)$this->params['id']);
            ($obj->Delete() and ($code = HTTP_200) and ($this->_response['message'] = _('general.save.success'))) or ($this->_response['m'] = (string)$obj->_error);
        endif;

        http_response_code($code);
        $this->respondToAJAX(json_encode($this->_response));
    }

    private function _save_reg() {
        $code = HTTP_422;

        if(!empty($this->_model) and !empty($_POST[$this->_model])):
            $data = $this->{$this->_model_camelized}->Niu($_POST[$this->_model]);
            (
                $data->Save()
                and ($response['d'] = $data and ($response['message'] = _('general.save.success')) and $code = HTTP_200)
            )
            or ($response['message'] = (string)$data->_error);
        endif;

        http_response_code($code);
        $this->respondToAJAX(json_encode($response));
    }

    public function before_filter() {
        Require_login();
        $this->menuLinks = adminMenu();
        $this->_additional_before_filter();
        $this->_prepare_data();
    }

    public function landingAction() {
        $this->render = ['text'=>'noop'];
        if($this->_is_routed):
            empty($this->params[0]) and ($this->params[0] = 'list');
            switch($this->params[0]):
                case 'edit':
                    $this->_edit_reg();
                break;
                case 'add':
                    $this->_add_reg();
                break;
                case 'delete':
                    $this->_delete_reg();
                break;
                case 'save':
                    $this->_save_reg();
                break;
                case 'list':
                default:
                    $this->_list_regs();
                break;
            endswitch;
        endif;
    }
}

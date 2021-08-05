<?php
class Seed extends Page {

    private function _sowAdmin() {
        $user = $this->User->Find(array('fields'=>'id', 'conditions'=>"`email`='jserrano@muy.co'"));
        0 === $user->counter() and $this->User->Niu([
            'email' => 'admin@admin.com',
            'firstname' => 'Admin',
            'lastname' => 'Admin',
            'password' => '1234567890',
            'status' => 1
        ])->Save() or die($user->_error);
    }

    public function sow() {
        $this->_sowAdmin();
     }
}
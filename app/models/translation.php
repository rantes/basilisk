<?php
class Translation extends ActiveRecord {
    public function _init_() {
        $this->before_save = ['setDomain', 'sanitize', 'checkKeyID'];
        $this->validate = [
            'presence_of' => [
                ['field'=>'keyid','message'=>_('model.error.required.translation.key')],
                ['field'=>'locale','message'=>_('model.error.required.translation.locale')]
            ]
        ];
    }

    public function setDomain() {
        !empty($this->keyid) and empty($this->domain) and ($this->domain = explode('.', $this->keyid)[0]);
    }

    public function sanitize() {
        if (!empty($this->translation)):
            $this->translation = htmlentities($this->translation, ENT_QUOTES, 'UTF-8', false);
        endif;
    }

    public function checkKeyID() {
        $translation = new $this;
        $translation->Find([
            'first',
            'conditions' => [
                ['keyid', $this->keyid],
                ['locale', $this->locale]
            ]
        ])->counter() and $this->_error->add(['field' => 'keyid', 'message' => _('model.error.duplicated.key')]);
    }
}
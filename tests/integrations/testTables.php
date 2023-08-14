<?php
class testTables extends dumboTests {

    /**
     * Force to connect to real DB in order to check the integration
     *
     * @return void
     */
    public function beforeEach() {
        // $GLOBALS['Connection'] = null;
        // $GLOBALS['driver'] = null;
        // unset($GLOBALS['Connection']);
        // $GLOBALS['env'] = APP_ENV;
        // $GLOBALS['Connection'] = new Connection();
    }

    public function migrationsTest() {
        // $this->describe('Verifying Fields');
        // $this->assertHasFields($this->Attachment);
        // $this->assertHasFields($this->Issue);
        // $this->assertHasFields($this->Param);
        // $this->assertHasFields($this->Project);
        // $this->assertHasFields($this->User);
        // $this->assertHasFields($this->Translation);

        // $this->describe('Verifying Field types');
        // $this->assertHasFieldTypes($this->Attachment);
        // $this->assertHasFieldTypes($this->Issue);
        // $this->assertHasFieldTypes($this->Param);
        // $this->assertHasFieldTypes($this->Project);
        // $this->assertHasFieldTypes($this->User);
        // $this->assertHasFieldTypes($this->Translation);
    }

    public function relationsTest() {
        $this->describe('Verifying object relations');
    }
    /**
     * Force to renew connection for test proceed
     *
     * @return void
     */
    public function _end_() {
        $GLOBALS['Connection'] = null;
        unset($GLOBALS['Connection']);
        $GLOBALS['driver'] = null;
        unset($GLOBALS['driver']);
    }
}

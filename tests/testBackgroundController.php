<?php
include_once INST_PATH.'app/controllers/background_controller.php';
class testBackgroundController extends dumboTests {

    public function _init_() {
        $this->_controller = new BackgroundController();
        $this->_controller->shellOutput = false;
        error_reporting(E_ALL & ~E_WARNING);
    }

    public function controllerExistTest() {
        $this->describe('Should exists the Controller');

        $this->assertFalse(empty($this->_controller), 'Assert there is a controller instance');
        $this->assertTrue(is_a($this->_controller, 'Page'), 'Assert the instance is a Controller instance');
    }

    public function _loggerMethodTest() {
        $this->describe('Should call logger method and perform a log.');

        $result = $this->invokeMethod($this->_controller, '_logger', ['unit_testing', 'this is a message', false]);
        $this->assertTrue($result, 'Assert there is no error on calling the method with proper params');

        try {
            $this->invokeMethod($this->_controller, '_logger', ['value']);
        } catch(Throwable $e) {
            $result = false;
        }
        $this->assertFalse($result, 'Assert there is error on calling the method with only one param');

        try {
            $this->invokeMethod($this->_controller, '_logger', []);
        } catch(Throwable $e) {
            $result = false;
        }
        $this->assertFalse($result, 'Assert there is error on calling the method only no params');
    }

    public function _readfilesTest() {
        $this->describe('Should call readfiles method and return an array with the file pathnames.');

        file_put_contents('/tmp/testfile.test', '');
        $result = $this->invokeMethod($this->_controller, '_readfiles', ['/tmp/', '/(.+)\.test/']);
        $this->assertTrue(is_array($result), 'Assert the return value is an array');
        $this->assertFalse(empty($result), 'Assert return return value is a non empty array');
        $this->assertTrue(in_array('/tmp/testfile.test', $result), 'Assert the testfile included in the array');

        try {
            $this->invokeMethod($this->_controller, '_readfiles', ['value']);
        } catch(Throwable $e) {
            $result = false;
        }
        $this->assertFalse($result, 'Assert there is error on calling the method with only one param');

        try {
            $this->invokeMethod($this->_controller, '_readfiles', []);
        } catch(Throwable $e) {
            $result = false;
        }
        $this->assertFalse($result, 'Assert there is error on calling the method with no params');
    }

    public function gettextActionTest() {
        $this->describe('Should perform the translation keys extraction from the files to generate translation files.');

        $this->_migrateTables([
            'translations'
            ]);
        $regs = $this->Translation->Find();
        $this->assertEquals($regs->counter(), 0, 'Assert there is no an existent reg.');
        $res = true;

        try {
            $this->_controller->gettextAction();
        } catch (Throwable $e) {
            $res = false;
        }
        $this->assertTrue($res, 'Assert there is no a failure running the action.');
        $regs = $this->Translation->Find();
        $this->assertTrue($regs->counter() > 0, 'Assert there are translation regs.');
    }

    public function _end_() {
        error_reporting(E_ALL);
    }
}

?>

<?php
class testTranslationModel extends dumboTests {
    public function beforeEach() {
        /** before each test the table should be reset */
        $this->_migrateTables([
            'translations'
        ]);
    }

    public function modelExistTest() {
        $this->describe('Should exists the Translation Model');
        $translation = $this->Translation->Niu();

        $this->assertFalse(empty($translation), 'Assert there is a translation model instance');
        $this->assertTrue(is_a($translation, 'ActiveRecord'), 'Assert the instance is an ActiveRecord instance');
    }

    public function triggerErrorsOnInsertTest() {
        $this->describe('Should have errors trying to insert new reg: mandatory fields');
        $t = $this->Translation->Niu();
        $result = $t->Save();
        $errFields = $t->_error->errFields();

        $this->assertEquals(sizeof($errFields), 2, 'Assert the number of errors must be 2.');
        $this->assertFalse($result, 'Assert the result sould be false.');
        $this->assertTrue(in_array('keyid', $errFields), 'Assert if the field keyid is in the errors.');
        $this->assertTrue(in_array('locale', $errFields), 'Assert if the field locale is in the errors.');
    }

    public function saveOkTest() {
        $this->describe('Should have no errors trying to insert new reg');
        $t = $this->Translation->Niu([
            'keyid' => 'test.key',
            'domain' => 'domain',
            'locale' => 'en_US',
            'translation' => 'test'
        ]);
        $result = $t->Save();
        $errors = $t->_error->errFields();

        $this->assertEquals(sizeof($errors), 0, 'Assert the number of errors must be 0.');
        $this->assertTrue($result, 'Assert the result sould be true.');
    }

    public function ensureDomainFieldTest() {
        $this->describe('Should set domain field if is empty');
        $t = $this->Translation->Niu([
            'keyid' => 'domain.test.key',
            'locale' => 'en_US',
            'translation' => 'test'
        ]);
        $result = $t->Save();
        $errors = $t->_error->errFields();

        $this->assertEquals(sizeof($errors), 0, 'Assert the number of errors must be 0.');
        $this->assertEquals($t->domain, 'domain', 'Assert the domain is set as the first part before the dot');
        $this->assertTrue($result, 'Assert the result sould be true.');
    }

    public function sanitizationTest() {
        $this->describe('Should have sanitize the translation when is set');
        
        $t = $this->Translation->Niu([
            'keyid' => 'domain.test.sanitize',
            'locale' => 'en_US',
            'translation' => 'níño'
        ]);

        $result = $t->Save();
        $errors = $t->_error->errFields();

        $this->assertEquals(sizeof($errors), 0, 'Assert the number of errors must be 0.');
        $this->assertTrue($result, 'Assert the result sould be true.');
        $this->assertEquals($t->translation, 'n&iacute;&ntilde;o', 'Assert the translation has proper entities.');
    }

    public function duplicatedKeyTest() {
        $this->describe('Should prevent duplicated keyid for the same locale');
        
        $t = $this->Translation->Niu([
            'keyid' => 'domain.test.key',
            'locale' => 'en_US',
            'translation' => 'test'
        ]);

        $tok = $this->Translation->Niu([
            'keyid' => 'domain.test.key',
            'locale' => 'es_CO',
            'translation' => 'test'
        ]);

        $tbad = $this->Translation->Niu([
            'keyid' => 'domain.test.key',
            'locale' => 'en_US'
        ]);

        $result = $t->Save();
        $errors = $t->_error->errFields();

        $resultok = $tok->Save();
        $errorsok = $tok->_error->errFields();

        $resultbad = $tbad->Save();
        $errorsbad = $tbad->_error->errFields();

        $this->assertEquals(sizeof($errors), 0, 'Assert the number of errors for the first insertion must be 0.');
        $this->assertTrue($result, 'Assert the result sould be true on first insertion.');

        $this->assertEquals(sizeof($errorsok), 0, 'Assert the number of errors for the another locale insertion must be 0.');
        $this->assertTrue($resultok, 'Assert the result sould be true on another locale insertion.');

        $this->assertEquals(sizeof($errorsbad), 1, 'Assert the number of errors for the duplicated key locale must be 1.');
        $this->assertFalse($resultbad, 'Assert the result sould be false when trying to insert a repeated key on same locale.');
        $this->assertTrue(in_array('keyid', $errorsbad), 'Assert if the field keyid is in the errors.');
    }
}
?>
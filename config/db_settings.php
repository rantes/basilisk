<?php
$databases = [
    'dev' => [
        'driver' => $this->_sysConfig('DB_DRIVER'),
        'host' =>  $this->_sysConfig('DB_HOST'),
        'charset' => $this->_sysConfig('DB_CHARSET'),
        'dialect' => $this->_sysConfig('DB_DIALECT'),
        'port' => $this->_sysConfig('DB_PORT'),
        'schema' => $this->_sysConfig('DB_SCHEMA'),
        'username' => $this->_sysConfig('DB_USERNAME'),
        'password' => $this->_sysConfig('DB_PASSWORD'),
        'unix_socket' => $this->_sysConfig('DB_UNIX_SOCKET')
    ],
    'test' => [
        'driver' => $this->_sysConfig('DB_DRIVER_TEST'),
        'host' =>  $this->_sysConfig('DB_HOST_TEST'),
        'charset' => $this->_sysConfig('DB_CHARSET_TEST'),
        'dialect' => $this->_sysConfig('DB_DIALECT_TEST'),
        'port' => $this->_sysConfig('DB_PORT_TEST'),
        'schema' => $this->_sysConfig('DB_SCHEMA_TEST'),
        'username' => $this->_sysConfig('DB_USERNAME_TEST'),
        'password' => $this->_sysConfig('DB_PASSWORD_TEST'),
        'unix_socket' => $this->_sysConfig('DB_UNIX_SOCKET_TEST')
    ]
];
?>
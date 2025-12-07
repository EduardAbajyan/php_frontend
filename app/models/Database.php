<?php

use Core\Session;

class Database {
    private static $instance = null; 
    private $pdo;
    public function __construct()
    {
        $_CONFIG = require APP_ROOT . '/config/database.php';
        $host = $_CONFIG['host'];
        $username = $_CONFIG['username'];
        $password = $_CONFIG['password'];
        $dbname = $_CONFIG['dbname'];
        $port = $_CONFIG['port'];
        $charset = $_CONFIG['charset'];
        $options = $_CONFIG['options'];
        try {
            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";
            $this->pdo = new PDO($dsn, $username, $password, $options);
            Session::flash('db_connection', 'Database connection established');
        } catch (PDOException $e) {
            throw new RuntimeException('Database connection failed: ' . $e->getMessage());
        }
    }
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function getConnection()
    {
        return $this->pdo;
    }
    private function __clone() {}
    public function __wakeup() {}
}

?>
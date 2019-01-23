<?php
require_once("Mocks.php");

class Conexion {

    public $connector;
    private static $instance;

    //Private constructor to avoid uncontrolled instances
    private function __construct($connector) {
        $this->connector = $connector;
    }
    
    public static function get_instance($connector) {
        if(self::$instance == null) self::$instance = new Conexion($connector);
        return self::$instance;
    }

    //@[params] ColumnName => value for where
    public function select($query, $params = array()) {
        $stmt = $this->connector->prepare($query);     
        foreach($params as $param => &$param_value) $stmt->bindParam($param, $param_value);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    //@params ColumnName => value to insert
    public function insert($table, $params) {
        $cols = implode(',',array_keys($params));
        $vals = ':'.implode(',:',array_keys($params));
        $query = "INSERT INTO $table ( $cols ) VALUES ( $vals )";
        $stmt = $this->connector->prepare($query);
        foreach($params as $param => &$value) {
            $stmt->bindParam(":$param", $value);
        }
        $stmt->execute();
    }

    public function update($query, $params) {
        $stmt = $this->connector->prepare($query);     
        foreach($params as $param => &$param_value) $stmt->bindParam($param, $param_value);
        $stmt->execute();
    }
}

class ConexionManager {

    const DB_HOST = 'localhost';
    const DB_PORT = '3306';
    const DB_NAME = 'booksjc';
    const DB_USER = 'root';
    const DB_PASS = '';
    const DB_DRIVER = 'mysql';

    private function __construct() {}

    public static function get_conexion($options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")) {

        $db_name = self::DB_NAME;

        try {

            $connector = new PDO(self::DB_DRIVER.':host='.self::DB_HOST.';port='.self::DB_PORT.';dbname='.self::DB_NAME,
            self::DB_USER,
            self::DB_PASS,
            $options);

            return Conexion::get_instance($connector);

        } catch (PDOException $error) {
            $connector = new PDO(self::DB_DRIVER.':host='.self::DB_HOST.';port='.self::DB_PORT,
            self::DB_USER,
            self::DB_PASS,
            $options);
            $query = $connector->prepare("CREATE DATABASE IF NOT EXISTS $db_name COLLATE utf8_spanish_ci");
            $query->execute();

            if($query){
                $use_db = $connector->prepare("USE $db_name");
                $use_db->execute();

                if($use_db) {
                    $create_sql = file_get_contents('sql/books.sql');
                    $create_sql_query = $connector->prepare($create_sql);
                    $create_sql_query->execute();
                    Mocks::populate(21);
                }
            }

            return Conexion::get_instance($connector);
        }

    }
     
}


<?php

namespace App\Db;

use \PDO;

class Conexion
{
    protected static $conexion;

    public function __construct()
    {
        self::setConexion();
    }

    public static function setConexion()
    {
        if (self::$conexion != null) {
            return; //self::$conexion;
        }
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
        $dotenv->load();
        $user = $_ENV['USER'];
        $host = $_ENV['HOST'];
        $db = $_ENV['DB'];
        $password = $_ENV['PASSWORD'];

        $dsn = "mysql:dbname=$db;host=$host;carset=utf8mb4";
        $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        try {
            self::$conexion = new PDO($dsn, $user, $password, $options);
            // return self::$conexion;
        } catch (\PDOException $ex) {
            die("Error al conectar, mensaje: " . $ex->getMessage());
        }
    }


    /**
     * Get the value of conexion
     */
    //  public static function getConexion()
    //  {
    //      return self::$conexion;
    //  }
}

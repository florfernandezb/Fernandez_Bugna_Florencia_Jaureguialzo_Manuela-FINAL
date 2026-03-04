<?php

class DatabaseConection
{

    protected const DB_SERVER = '127.0.0.1';
    protected const DB_PORT = '3306';
    protected const DB_USER = 'root';
    protected const DB_PASS = '';
    protected const DB_NAME = 'hecho_por_vicki';

    protected const DB_DSN = 'mysql:host=' . self::DB_SERVER . ';port=' . self::DB_PORT . ';dbname=' . self::DB_NAME . ';charset=utf8mb4';
    
    protected static ?PDO $db = null;

    public static function connect()
    {
        try {
            self::$db = new PDO(self::DB_DSN, self::DB_USER, self::DB_PASS);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Error connecting MySQL: ' . $e->getMessage() . '<br>Verifica que:<br>1. MySQL esté corriendo en XAMPP<br>2. La base de datos "hecho_por_vicki" exista<br>3. Las credenciales sean correctas (usuario: root, contraseña: vacía)');
        }
    }

    /**
     * Function that returns a ready-to-use PDO connection
     * @return PDO
     */
    public static function getConection(): PDO
    {
       if(self::$db === null) {
        self::connect();
       }
       return self::$db;
    }
}

?>
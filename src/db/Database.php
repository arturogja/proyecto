<?php
class Database
{
    private $connection;

    public function __construct()
    {
        // Cargamos la configuración de base de datos
        $config = include __DIR__ . '/../../config/config.php';

        try {
            // Conectamos a la base de datos 
            $this->connection = new PDO(
                'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['dbname'] . ';charset=' . $config['db']['charset'],
                $config['db']['user'],
                $config['db']['password']
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error en la conexión a la base de datos: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}

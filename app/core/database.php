<?php
class Database {
    public $statement;
    public $dbHandler;
    public $error;

    public function __construct() {
        $conn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_DATABASE'];
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        try {
            $this->dbHandler = new PDO($conn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            die($this->error);
            exit;
        }
    }

    //Allows us to write queries
    public function query($sql) {
        try {
            $this->statement = $this->dbHandler->prepare($sql);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            die($this->error);
            exit;
        }
    }

    //Bind values
    public function bind($parameter, $value, $type = null) {
        switch (is_null($type)) {
            case is_int($value):
                $type = PDO::PARAM_INT;
                break;
            case is_bool($value):
                $type = PDO::PARAM_BOOL;
                break;
            case is_null($value):
                $type = PDO::PARAM_NULL;
                break;
            default:
                $type = PDO::PARAM_STR;
        }
        $this->statement->bindValue($parameter, $value, $type);
    }

    //Execute the prepared statement
    public function execute() {
        return $this->statement->execute();
    }

    //Return an array
    public function resultSet() {
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }

    //Return a specific row as an object
    public function single() {
        $this->execute();
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }

    //Get's the row count
    public function rowCount() {
        return $this->statement->rowCount();
    }
}
<?php
  namespace App;
  class Connection {
    public static function getDb() {
      $host = DATABASE_HOST;
      $dbname = DATABASE_NAME;
      $username = DATABASE_USERNAME;
      $password = DATABASE_SENHA;

      try {
        $pdo = new \PDO(
          "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
          $username,
          $password
        );

        return $pdo;
      } catch(\PDOException $e) {
        echo "Ocorreu um erro: {$e->getMessage()}. Código: {$e->getCode()}";
        die;
      }
    }
  }
?>
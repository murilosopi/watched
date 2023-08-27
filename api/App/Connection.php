<?php
  namespace App;
  class Connection {
    public static function getDb() {
      $host = 'localhost';
      $dbname = 'watched';
      $username = 'root';
      $password = '';

      try {
        $pdo = new \PDO(
          "mysql:host=$host;dbname=$dbname;charset=utf8",
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
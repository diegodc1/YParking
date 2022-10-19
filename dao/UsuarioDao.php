<?php
require_once('../models/Usuario.php');

class UsuarioDaoDB implements UsuarioDAO {
  private $pdo;
  public function __construct(PDO $driver) {
    $this->pdo = $driver;
  }

  // Add user no BD.
  public function add(Usuario $u) {
    $sql = $this->pdo->prepare("INSERT INTO users (user_name, user_email, user_function, user_access, user_password) VALUES (:name, :email, :function, :access, :password)");
    $sql->bindValue(':name', $u->getName());
    $sql->bindValue(':email', $u->getEmail());
    $sql->bindValue(':function', $u->getFunction());
    $sql->bindValue(':access', $u->getAccess());
    $sql->bindValue(':password', $u->getPassword());

    $sql->execute();
    
    $u->setId($this->pdo->lastInsertId());
    return $u;
  }
  public function findAll(){}
  public function findByEmail($email){
    $sql = $this->pdo->prepare("SELECT * FROM users WHERE user_email = :email");
    $sql->bindValue(':email', $email);
    $sql->execute();

    if($sql->rowCount() > 0 ){
      $data = $sql->fetch();

      $u = new Usuario;
      $u->setId($data['user_id']);
      $u->setName($data['user_name']);
      $u->setEmail($data['user_email']);
      $u->setFunction($data['user_function']);
      $u->setAccess($data['user_access']);
      $u->setPassword($data['user_password']);

      return $u;
    } else {
      return false;
    }
  }
  public function findById($id){}
  public function update(Usuario $u){}
  public function delete($id){}
}
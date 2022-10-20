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

  public function findAll(){
    $users = [];

    $sql = $this->pdo->query("SELECT * FROM users");
    if ($sql->rowCount() > 0) {
      $data = $sql->fetchAll();

      foreach ($data as $user) {
        $u = new Usuario;
        $u->setId($user['user_id']);
        $u->setName($user['user_name']);
        $u->setEmail($user['user_email']);
        $u->setFunction($user['user_function']);
        $u->setAccess($user['user_access']);
        $u->setPassword($user['user_password']);

        $users[] = $u;
      }
    }
    return $users;
  }

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

  public function findUserLogin($email, $pass){

    $sql = $this->pdo->prepare("SELECT * FROM users WHERE user_email = :email");
    $sql->bindValue(':email', $email);
    $sql->execute();
    $data = $sql->fetch();

    if($sql->rowCount() > 0 && password_verify($pass, $data['user_password'])) {
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

  public function delete($id){
    $sql = $this->pdo->prepare("DELETE FROM users WHERE user_id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();  
  }
}
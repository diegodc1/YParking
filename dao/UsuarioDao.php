<?php
require_once('../models/Usuario.php');

class UsuarioDaoDB implements UsuarioDAO {
  private $pdo;
  public function __construct(PDO $driver) {
    $this->pdo = $driver;
  }

  // Add user no BD.
  public function add(Usuario $u) {
    $sql = $this->pdo->prepare("INSERT INTO users (user_name, user_email, user_function, user_access, user_password, user_staus) VALUES (:name, :email, :function, :access, :password, :status)");
    $sql->bindValue(':name', $u->getName());
    $sql->bindValue(':email', $u->getEmail());
    $sql->bindValue(':function', $u->getFunction());
    $sql->bindValue(':access', $u->getAccess());
    $sql->bindValue(':password', $u->getPassword());
    $sql->bindValue(':status', $u->getStatus());

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
        $u->setStatus($user['user_status']);

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
      $u->setStatus($data['user_status']);

      return $u;
    } else {
      return false;
    }
  }
  
  public function findById($id){
    $sql = $this->pdo->prepare("SELECT * FROM users WHERE user_id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();

    if($sql->rowCount() > 0) {
      $data = $sql->fetch();

      $u = new Usuario;
      $u->setId($data['user_id']);
      $u->setName($data['user_name']);
      $u->setEmail($data['user_email']);
      $u->setFunction($data['user_function']);
      $u->setAccess($data['user_access']);
      $u->setPassword($data['user_password']);
      $u->setStatus($data['user_status']);

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
        $u->setStatus($data['user_status']);

        return $u;
    } else {
      return false;
    }
  }

  public function update(Usuario $u){
    $sql = $this->pdo->prepare("UPDATE users SET user_name = :name, user_email = :email, user_function = :function, user_access = :access WHERE user_id = :id");
    $sql->bindValue(':name', $u->getName());
    $sql->bindValue(':email', $u->getEmail());
    $sql->bindValue(':function', $u->getFunction());
    $sql->bindValue(':access', $u->getAccess());
    $sql->bindValue(':id', $u->getId());
    $sql->execute();

    return true;
  }

  public function updatePerfil(Usuario $u, $pass) {
    if($pass) {
      $sql = $this->pdo->prepare("UPDATE users SET user_name = :name, user_email = :email, user_password = :password WHERE user_id = :id");
      $sql->bindValue(':name', $u->getName());
      $sql->bindValue(':email', $u->getEmail());
      $sql->bindValue(':password', $u->getPassword());
      $sql->bindValue(':id', $u->getId());
    } else {
      $sql = $this->pdo->prepare("UPDATE users SET user_name = :name, user_email = :email WHERE user_id = :id");
      $sql->bindValue(':name', $u->getName());
      $sql->bindValue(':email', $u->getEmail());
      $sql->bindValue(':id', $u->getId());
    }

    $sql->execute();

    return true;
  }

  public function delete($id){
    $sql = $this->pdo->prepare("DELETE FROM users WHERE user_id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();  
  }

  public function disable($id){
    $sql = $this->pdo->prepare("UPDATE users SET user_status = :status WHERE user_id = :id");
    $sql->bindValue(':id', $id);
    $sql->bindValue(':status', 'Desativado');
    $sql->execute();  
  }

  public function reactivate($id){
    $sql = $this->pdo->prepare("UPDATE users SET user_status = :status WHERE user_id = :id");
    $sql->bindValue(':id', $id);
    $sql->bindValue(':status', 'Ativo');
    $sql->execute();  
  }

  public function findTotalByFunction($function) {
    $sql = $this->pdo->prepare("SELECT * FROM users WHERE user_function = :function");
    $sql->bindValue(':function', $function);
    $sql->execute();

    $qtd = $sql->rowCount();

    return $qtd;
  }

  // public function findDistinctData($column) {

  //   $sql = $this->pdo->prepare("SELECT DISTINCT user_function FROM users");
  //   $sql->bindValue(':column', '$column');
  //   $sql->execute();


  //     $data = $sql->fetchAll();
  //     return $data;

  //     // foreach($data as $distinct) {
  //     //   $u = new Usuario;
  //     //   $u->setFunction($distinct['user_function']);
  //     //   $dataDistincts[] = $distinct;
  //     // }


  //   return $data;
  // }
}
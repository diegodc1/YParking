<?php
class Usuario
{
  private $id;
  private $name;
  private $email;
  private $function;
  private $access;
  private $password;

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id; 
  }

  public function getName() {
    return $this->name;
  }

  public function setName($n) {
    $this->name = ucwords(trim($n));
  }

  public function getEmail() {
    return $this->email;
  }

  public function setEmail($e) {
    $this->email = strtolower(trim($e));
  }

  public function getFunction() {
    return $this->function;
  }

  public function setFunction($f) {
    $this->function = $f;
  }

  public function getAccess() {
    return $this->access;
  }

  public function setAccess($a) {
    $this->access = $a;
  }

  public function getPassword() {
    return $this->password;
  }

  public function setPassword($p) {
    $this->password = password_hash($p, PASSWORD_DEFAULT);
  }
}

interface UsuarioDao {
  public function add(Usuario $u);
  public function findAll();
  public function findUserLogin($email, $pass);
  public function findById($id);
  public function update(Usuario $u);
  public function updatePerfil(Usuario $u, $pass);
  public function delete($id);
}

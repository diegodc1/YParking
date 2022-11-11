<?php 

class Company {
  private $id;
  private $name;
  private $email;
  private $phone;
  private $slots;

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
    $this->name = $n;
  }

  public function getEmail() {
    return $this->email;
  }

  public function setEmail($e) {
    $this->email = $e;
  }

  public function getPhone() {
    return $this->phone;
  }

  public function setPhone($p){
    $this->phone = $p;
  }

  public function getSlots() {
    return $this->slots;
  }

  public function setSlots($s){
    $this->slots = $s;
  }
}

interface CompanyDao {
  public function add(Company $u);
  public function findAll();
  public function findById($id);
  public function update(Company $u);
  public function delete($id);
}
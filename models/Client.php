<?php 
class Client {
  private $id;
  private $name;
  private $email;
  private $phone;
  private $cep;
  private $address;
  private $type;
  private $bussinesPlan;
  private $departureTime;
  private $companyId;

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

  public function getPhone() {
    return $this->phone;
  }

  public function setPhone($phone) {
    $this->phone = trim($phone);
  }

  public function getCep() {
    return $this->cep;
  }

  public function setCep($cep) {
    $this->cep = trim($cep);
  }

  public function getAddress() {
    return $this->address;
  }

  public function setAddress($address) {
    $this->address = strtolower(trim($address));
  }
  
  public function getType() {
    return $this->type;
  }

  public function setType($type) {
    $this->type = strtolower(trim($type));
  }

  public function getBussinesPlan() {
    return $this->bussinesPlan;
  }

  public function setBussinesPlan($bussinesPlan) {
    $this->bussinesPlan = strtolower(trim($bussinesPlan));
  }

  public function getDepartureType() {
    return $this->bussinesPlan;
  }

  public function setDepartureType($departureTime) {
    $this->departureTime = strtolower(trim($departureTime));
  }

  public function getCompanyId() {
    return $this->bussinesPlan;
  }

  public function setCompanyId($companyId) {
    $this->companyId = strtolower(trim($companyId));
  }
}

interface ClientDao {
  public function add(Client $u);
  public function findAll();
  public function findById($id);
  public function update(Client $u);
  public function delete($id);
}

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
  private $status;
  private $cadDate;
  private $cadTime;

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
    $this->address = ucwords(trim($address));
  }
  
  public function getType() {
    return $this->type;
  }

  public function setType($type) {
    $this->type = ucwords(trim($type));
  }

  public function getBussinesPlan() {
    return $this->bussinesPlan;
  }

  public function setBussinesPlan($bussinesPlan) {
    $this->bussinesPlan = trim($bussinesPlan);
  }

  public function getDepartureTime() {
    return $this->departureTime;
  }

  public function setDepartureTime($departureTime) {
    $this->departureTime = strtolower(trim($departureTime));
  }

  public function getCompanyId() {
    return $this->companyId;
  }

  public function setCompanyId($companyId) {
    $this->companyId = $companyId;
  }

  public function getStatus() {
    return $this->status;
  }

  public function setStatus($status) {
    $this->status = $status;
  }
  
  public function getCadDate() {
    return $this->cadDate;
  }

  public function setCadDate($cadDate) {
    $this->cadDate = $cadDate;
  }

  public function getCadTime() {
    return $this->cadTime;
  }

  public function setCadTime($cadTime) {
    $this->cadTime = $cadTime;
  }
}

interface ClientDao {
  public function add(Client $u);
  public function findAll();
  public function findAllAtive();
  public function findByIdReturnName($id);
  public function findById($id);
  public function findByClientIdQtd($companyId);
  public function findByType($type);
  public function findByBussinesPlan($plan);
  public function update(Client $u);
  public function delete($id);
  public function disable($id);
  public function reactivate($id);
  public function setTimeAverage($id);
}

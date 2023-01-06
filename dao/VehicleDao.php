<?php
require_once('../models/Vehicle.php');
require_once('../models/Client.php');

class VehicleDaoDB implements VehicleDao {
  private $pdo;
  public function __construct(PDO $driver) {
    $this->pdo = $driver;
  }  
  
  public function add(Vehicle $u){
    $sql = $this->pdo->prepare("INSERT INTO vehicles (vehicle_model, vehicle_plate, vehicle_color, vehicle_category, vehicle_client_id, vehicle_brand, vehicle_status, vehicle_cad_date, vehicle_cad_time) VALUES (:model, :plate, :color, :category, :clientId, :brand, :status, :cadDate, :cadTime)");
    $sql->bindValue(':model', $u->getModel());
    $sql->bindValue(':plate', $u->getPlate());
    $sql->bindValue(':color', $u->getColor());
    $sql->bindValue(':category', $u->getCategory());
    $sql->bindValue(':brand', $u->getBrand());
    $sql->bindValue(':clientId', $u->getClientId());
    $sql->bindValue(':status', $u->getStatus());
    $sql->bindValue(':cadDate', $u->getCadDate());
    $sql->bindValue(':cadTime', $u->getCadTime());

    $sql->execute();

    $u->setId($this->pdo->lastInsertId());
    return $u;
  }

  public function findAll(){
    $vehicles = [];

    $sql= $this->pdo->query("SELECT * FROM vehicles");
    if($sql->rowCount() > 0){
      $data = $sql->fetchAll();

      foreach($data as $vehicle) {
        $u = new Vehicle();
        $u->setId($vehicle['vehicle_id']);
        $u->setModel($vehicle['vehicle_model']);
        $u->setPlate($vehicle['vehicle_plate']);
        $u->setColor($vehicle['vehicle_color']);
        $u->setCategory($vehicle['vehicle_category']);
        $u->setBrand($vehicle['vehicle_brand']);
        $u->setClientId($vehicle['vehicle_client_id']);
        $u->setStatus($vehicle['vehicle_status']);
        $u->setCadDate($vehicle['vehicle_cad_date']);
        $u->setCadTime($vehicle['vehicle_cad_time']);

        $vehicles[] = $u;
      }
    }

    return $vehicles;
  }

  public function findAllVehiClie() {
    $vehicles = [];
    $clients = [];

    $sql= $this->pdo->query("SELECT * FROM vehicles");
    if($sql->rowCount() > 0){
      $data = $sql->fetchAll();

      foreach($data as $vehicle) {
        $u = new Vehicle();
        $u->setId($vehicle['vehicle_id']);
        $u->setModel($vehicle['vehicle_model']);
        $u->setPlate($vehicle['vehicle_plate']);
        $u->setColor($vehicle['vehicle_color']);
        $u->setCategory($vehicle['vehicle_category']);
        $u->setBrand($vehicle['vehicle_brand']);
        $u->setClientId($vehicle['vehicle_client_id']);
        $u->setStatus($vehicle['vehicle_status']);
        $u->setCadDate($vehicle['vehicle_cad_date']);
        $u->setCadTime($vehicle['vehicle_cad_time']);
      }
    }

    return $vehicles;
  }

  public function findByPlate($plate){
    $sql = $this->pdo->prepare("SELECT * FROM vehicles WHERE vehicle_plate = :plate");
    $sql->bindValue(':plate', $plate);
    $sql->execute();
    $data = $sql->fetch();

    if($sql->rowCount() > 0) {
      $u = new Vehicle();
      $u->setId($data['vehicle_id']);
      $u->setModel($data['vehicle_model']);
      $u->setPlate($data['vehicle_plate']);
      $u->setColor($data['vehicle_color']);
      $u->setCategory($data['vehicle_category']);
      $u->setBrand($data['vehicle_brand']);
      $u->setClientId($data['vehicle_client_id']);
      $u->setStatus($data['vehicle_status']);
      $u->setCadDate($data['vehicle_cad_date']);
      $u->setCadTime($data['vehicle_cad_time']);
      return $u;
    } else {
      return false;
    }

  }


  public function findByClientId($clientId) {
    $sql = $this->pdo->prepare("SELECT * FROM vehicles WHERE vehicle_client_id = :clientId");
    $sql->bindValue(':clientId', $clientId);
    $sql->execute();
    
    $vehicles = [];

    if($sql->rowCount() > 0) {
      $data = $sql->fetchAll();

      foreach($data as $vehicle) {
        $u = new Vehicle();
        $u->setId($vehicle['vehicle_id']);
        $u->setModel($vehicle['vehicle_model']);
        $u->setPlate($vehicle['vehicle_plate']);
        $u->setColor($vehicle['vehicle_color']);
        $u->setCategory($vehicle['vehicle_category']);
        $u->setBrand($vehicle['vehicle_brand']);
        $u->setClientId($vehicle['vehicle_client_id']);
        $u->setStatus($vehicle['vehicle_status']);
        $u->setCadDate($vehicle['vehicle_cad_date']);
        $u->setCadTime($vehicle['vehicle_cad_time']);
        $vehicles[] = $u;
      } 
    } 
    return $vehicles;
  }

  public function findByClientIdQtd($clientId) {
    $sql = $this->pdo->prepare("SELECT * FROM vehicles WHERE vehicle_client_id = :clientId");
    $sql->bindValue(':clientId', $clientId);
    $sql->execute();
    $qtd = $sql->rowCount();

    return $qtd;
  } 

  public function findById($id){
    $sql = $this->pdo->query("SELECT * FROM vehicles WHERE vehicle_id = $id");
    if($sql->rowCount() > 0) {
      $data = $sql->fetch();

      $v = new Vehicle();
      $v->setId($data['vehicle_id']);
      $v->setModel($data['vehicle_model']);
      $v->setPlate($data['vehicle_plate']);
      $v->setColor($data['vehicle_color']);
      $v->setCategory($data['vehicle_category']);
      $v->setBrand($data['vehicle_brand']);
      $v->setClientId($data['vehicle_client_id']);
      $v->setStatus($data['vehicle_status']);
      $v->setCadDate($data['vehicle_cad_date']);
      $v->setCadTime($data['vehicle_cad_time']);
    
      return $v;
    } else {
      return false;
    }
  }

  public function update(Vehicle $u){
    $sql = $this->pdo->prepare("UPDATE vehicles SET vehicle_model = :model, vehicle_plate = :plate, vehicle_color = :color, vehicle_category = :category, vehicle_brand = :brand WHERE vehicle_id = :id");
    $sql->bindValue(':model', $u->getModel());
    $sql->bindValue(':plate', $u->getPlate());
    $sql->bindValue(':color', $u->getColor());
    $sql->bindValue(':category', $u->getCategory());
    $sql->bindValue(':brand', $u->getBrand());
    $sql->bindValue(':id', $u->getId());
    $sql->execute();

    return true;
  }

  public function delete($id){
    $sql = $this->pdo->prepare("DELETE FROM vehicles WHERE vehicle_id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();  
  }

  public function disable($id){
    $sql = $this->pdo->prepare("UPDATE vehicles SET vehicle_status = :status WHERE vehicle_id = :id");
    $sql->bindValue(':id', $id);
    $sql->bindValue(':status', 'Desativado');
    $sql->execute();  
  }

  public function reactivate($id){
    $sql = $this->pdo->prepare("UPDATE vehicles SET vehicle_status = :status WHERE vehicle_id = :id");
    $sql->bindValue(':id', $id);
    $sql->bindValue(':status', 'Ativo');
    $sql->execute();  
  }
}

<?php
require_once('../models/Vehicle.php');

class VehicleDaoDB implements VehicleDao {
  private $pdo;
  public function __construct(PDO $driver) {
    $this->pdo = $driver;
  }  
  
  public function add(Vehicle $u){
    $sql = $this->pdo->prepare("INSERT INTO vehicles (vehicle_model, vehicle_plate, vehicle_color, vehicle_category, vehicle_departure_time, vehicle_client_id, vehicle_brand) VALUES (:model, :plate, :color, :category, :depTime, :clientId, :brand)");
    $sql->bindValue(':model', $u->getModel());
    $sql->bindValue(':plate', $u->getPlate());
    $sql->bindValue(':color', $u->getColor());
    $sql->bindValue(':category', $u->getCategory());
    $sql->bindValue(':brand', $u->getBrand());
    $sql->bindValue(':depTime', $u->getDepartureTime());
    $sql->bindValue(':clientId', $u->getClientId());

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
        $u->setDepartureTime($vehicle['vehicle_departure_time']);
        $u->setClientId($vehicle['vehicle_client_id']);

        $vehicles[] = $u;
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
      $u->setDepartureTime($data['vehicle_departure_time']);
      $u->setClientId($data['vehicle_client_id']);

      return $u;
    } else {
      return false;
    }
  }


  public function findByClientId($clientId) {
    $sql = $this->pdo->prepare("SELECT * FROM vehicles WHERE vehicle_client_id = :clientId");
    $sql->bindValue(':clientId', $clientId);
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
      $u->setDepartureTime($data['vehicle_departure_time']);
      $u->setClientId($data['vehicle_client_id']);

      return $u;
    } else {
      return false;
    }
  }

  public function findByClientIdQtd($clientId) {
    $sql = $this->pdo->prepare("SELECT * FROM vehicles WHERE vehicle_client_id = :clientId");
    $sql->bindValue(':clientId', $clientId);
    $sql->execute();

    return $sql->rowCount();
  } 

  public function findById($id){}
  public function update(Vehicle $u){}

  public function delete($id){
    $sql = $this->pdo->prepare("DELETE FROM vehicles WHERE vehicle_id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();  
  }
}

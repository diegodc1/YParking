<?php
require_once('../models/Vehicle.php');

class VehicleDaoDB implements VehicleDao {
  private $pdo;
  public function __construct(PDO $driver) {
    $this->pdo = $driver;
  }  
  
  public function add(Vehicle $u){
    $sql = $this->pdo->prepare("INSERT INTO vehicles (vehicle_model, vehicle_plate, vehicle_color, vehicle_category, vehicle_departure_time, vehicle_client_id) VALUES (:model, :plate, :color, :category, :depTime, :clientId)");
    $sql->bindValue(':model', $u->getModel());
    $sql->bindValue(':plate', $u->getPlate());
    $sql->bindValue(':color', $u->getColor());
    $sql->bindValue(':category', $u->getCategory());
    $sql->bindValue(':depTime', $u->getDepartureTime());
    $sql->bindValue(':clientId', $u->getClientId());

    $sql->execute();

    $u->setId($this->pdo->lastInsertId());
    return $u;

  }
  public function findAll(){}
  public function findById($id){}
  public function update(Vehicle $u){}
  public function delete($id){}
}

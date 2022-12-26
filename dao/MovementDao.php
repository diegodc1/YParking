<?php
require_once('../models/Movement.php');

class MovementDaoDB implements MovementDao {
  private $pdo;

  public function __construct(PDO $driver){
    $this->pdo = $driver;
  }

  public function add(Movement $u){
    $sql = $this->pdo->prepare("INSERT INTO movements (mov_type, mov_date, mov_time, mov_vehicle_id, mov_client_id, mov_user_id, mov_status, mov_ckin_id, mov_ckout_id) VALUES (:type, :date, :time, :vehicleId, :clientId, :userId, :status, :ckinId, :ckoutId)");
    $sql->bindValue(':type', $u->getType());
    $sql->bindValue(':date', $u->getDate());
    $sql->bindValue(':time', $u->getTime());
    $sql->bindValue(':vehicleId', $u->getVehicleId());
    $sql->bindValue(':clientId', $u->getClientId());
    $sql->bindValue(':userId', $u->getUserId());
    $sql->bindValue(':status', $u->getStatus());
    $sql->bindValue(':ckinId', $u->getCkinId());
    $sql->bindValue(':ckoutId', $u->getCkoutId());

    $sql->execute();
    $u->setId($this->pdo->lastInsertId());
    return $u;
  }

  public function findAll(){
    $movements = [];

    $sql = $this->pdo->query("SELECT * FROM movements ORDER BY mov_id DESC");
    if ($sql->rowCount() > 0) {
      $data = $sql->fetchAll();

      foreach ($data as $movement) {
        $u = new Movement;
        $u->setId($movement['mov_id']);
        $u->setType($movement['mov_type']);
        $u->setDate($movement['mov_date']);
        $u->setTime($movement['mov_time']);
        $u->setVehicleId($movement['mov_vehicle_id']);
        $u->setClientId($movement['mov_client_id']);
        $u->setUserId($movement['mov_user_id']);
        $u->setStatus($movement['mov_status']);
        $u->setCkinId($movement['mov_ckin_id']);
        $u->setCkoutId($movement['mov_ckout_id']);

        $movements[] = $u;
      }
    }
    return $movements;
  }

  public function findById($id){
    $sql = $this->pdo->prepare("SELECT * FROM movements WHERE mov_id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();

    if($sql->rowCount() > 0) {
      $data = $sql->fetch();

      $u = new Movement;
      $u->setId($data['mov_id']);
      $u->setType($data['mov_type']);
      $u->setDate($data['mov_date']);
      $u->setTime($data['mov_time']);
      $u->setVehicleId($data['mov_vehicle_id']);
      $u->setClientId($data['mov_client_id']);
      $u->setUserId($data['mov_user_id']);
      $u->setStatus($data['mov_status']);
        $u->setCkinId($data['mov_ckin_id']);
      $u->setCkoutId($data['mov_ckout_id']);
      return $u;
    } else {
      return false;
    }
  }
}

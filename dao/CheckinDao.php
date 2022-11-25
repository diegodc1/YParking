<?php
require_once('../models/Checkin.php');

class CheckinDaoDB implements CheckinDao {
  private $pdo;
   public function __construct(PDO $driver) {
    $this->pdo = $driver;
  }

  public function add(Checkin $u){
    $sql = $this->pdo->prepare("INSERT INTO checkin (ckin_vehicle_id, ckin_client_id, ckin_section_id, ckin_time, ckin_user_id) VALUES (:vehicleId, :clientId, :sectionId, :time, :userId)");
    $sql->bindValue(':vehicleId', $u->getVehicleId());
    $sql->bindValue(':clientId', $u->getClientId());
    $sql->bindValue(':sectionId', $u->getSectionId());
    $sql->bindValue(':time', $u->getTime());
    $sql->bindValue(':userId', $u->getUserId());
    $sql->execute();
    $u->setId($this->pdo->lastInsertId());
    return $u;
  }

  public function findAll(){
    $checkins = [];

    $sql = $this->pdo->query("SELECT * FROM checkin");
    if($sql->rowCount() > 0) {
      $data = $sql->fetchAll();

      foreach($data as $checkin) {
        $u = new Checkin;
        $u->setId($checkin['ckcin_id']);
        $u->setVehicleId($checkin['ckin_vehicle_id']);
        $u->setClientId($checkin['ckin_client_id']);
        $u->setSectionId($checkin['ckin_section_id']);
        $u->setTime($checkin['ckin_time']);
        $u->setUserId($checkin['ckin_user_id']);

        $checkins[] = $u;
      }
    }
    return $checkins;
  }

  public function findById($id){
    $sql = $this->pdo->prepare("SELECT * FROM checkin WHERE ckin_id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();

    if($sql->rowCount() > 0) {
      $data = $sql->fetch();

      $u = new Checkin;;
      $u->setId($data['ckcin_id']);
      $u->setVehicleId($data['ckin_vehicle_id']);
      $u->setClientId($data['ckin_client_id']);
      $u->setSectionId($data['ckin_section_id']);
      $u->setTime($data['ckin_time']);
      $u->setUserId($data['ckin_user_id']);

      return $u;
    } else {
      return false;
    }
  }

  public function update(Checkin $u){
    $sql = $this->pdo->prepare("UPDATE checkin SET ckin_vehicle_id = :vehicleId, ckin_clientId = :clientId, ckin_section_id = :sectionId, ckin_time = :time, ckin_user_id = userId WHERE ckin_id = :id");

    $sql->bindValue(':vehicleId', $u->getVehicleId());
    $sql->bindValue(':clientId', $u->getClientId());
    $sql->bindValue(':sectionId', $u->getSectionId());
    $sql->bindValue(':time', $u->getTime());
    $sql->bindValue(':userId', $u->getUserId());
    $sql->bindValue(':id', $u->getId());

    $sql->execute();
    
    return true;
  }

  public function delete($id){
    $sql = $this->pdo->prepare("DELETE FROM checkin WHERE ckin_id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();  
  }



  //======= Daily Ckeckin Funcions =======// 
  public function addDaily(Checkin $u){

    $sql = $this->pdo->prepare("INSERT INTO checkin_daily (ckdin_vehicle_id, ckdin_client_id, ckdin_section_id, ckdin_time, ckdin_user_id, ckdin_status) VALUES (:vehicleId, :clientId, :sectionId, :time, :userId, 'Ativo')");
    $sql->bindValue(':vehicleId', $u->getVehicleId());
    $sql->bindValue(':clientId', $u->getClientId());
    $sql->bindValue(':sectionId', $u->getSectionId());
    $sql->bindValue(':time', $u->getTime());
    $sql->bindValue(':userId', $u->getUserId());
    $sql->execute();

    return $u;
  }

  public function returnSlotsBySectionId($idSection){
    $sql = $this->pdo->prepare("SELECT * FROM checkin_daily WHERE ckdin_section_id = :idSection");
    $sql->bindValue(':idSection', $idSection);
    $sql->execute();

    return $sql->rowCount();
  }



   public function findAllDaily() {
    $checkinsDaily = [];

    $sql = $this->pdo->query("SELECT * FROM checkin_daily ORDER BY ckdin_time DESC");
    if($sql->rowCount() > 0) {
      $data = $sql->fetchAll();

      foreach($data as $checkin) {
        $u = new Checkin;
        $u->setId($checkin['ckdin_id']);
        $u->setVehicleId($checkin['ckdin_vehicle_id']);
        $u->setClientId($checkin['ckdin_client_id']);
        $u->setSectionId($checkin['ckdin_section_id']);
        $u->setTime($checkin['ckdin_time']);
        $u->setUserId($checkin['ckdin_user_id']);
        $u->setStatus($checkin['ckdin_status']);

        $checkinsDaily[] = $u;
      }
    }
    return $checkinsDaily;
  }
}
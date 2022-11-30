<?php
require_once('../models/Checkin.php');

class CheckinDaoDB implements CheckinDao {
  private $pdo;
   public function __construct(PDO $driver) {
    $this->pdo = $driver;
  }

  public function add(Checkin $u){
    $sql = $this->pdo->prepare("INSERT INTO checkin (ckin_vehicle_id, ckin_client_id, ckin_section_id, ckin_time, ckin_user_id, ckin_date, ckin_status) VALUES (:vehicleId, :clientId, :sectionId, :time, :userId, :date, :status)");
    $sql->bindValue(':vehicleId', $u->getVehicleId());
    $sql->bindValue(':clientId', $u->getClientId());
    $sql->bindValue(':sectionId', $u->getSectionId());
    $sql->bindValue(':time', $u->getTime());
    $sql->bindValue(':userId', $u->getUserId());
    $sql->bindValue(':status', $u->getStatus());
    $sql->bindValue(':date', $u->getDate());
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
        $u->setStatus($checkin['ckin_status']);
        $u->setDate($checkin['ckin_date']);

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
      $u->setId($data['ckin_id']);
      $u->setVehicleId($data['ckin_vehicle_id']);
      $u->setClientId($data['ckin_client_id']);
      $u->setSectionId($data['ckin_section_id']);
      $u->setTime($data['ckin_time']);
      $u->setUserId($data['ckin_user_id']);
      $u->setStatus($data['ckin_status']); 
      $u->setDate($data['ckin_date']);

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

  public function updateStatus($status, $id){
    $sql = $this->pdo->prepare("UPDATE checkin SET ckin_status = :status WHERE ckin_id = :id");
    $sql->bindValue(':status', $status);
    $sql->bindValue(':id', $id);

    $sql->execute();
    
    return true;
  }

  public function cancel($id){
    $sql = $this->pdo->prepare("UPDATE checkin SET ckin_status = :status WHERE ckin_id = :id");
    $sql->bindValue(':id', $id);
    $sql->bindValue(':status', 'Cancelado');
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

  public function returnSlotsByDate($date, $sectionId){
    $sql = $this->pdo->prepare("SELECT * FROM checkin WHERE ckin_date = :date AND ckin_section_id = :sectionId");
    $sql->bindValue(':date', $date);
    $sql->bindValue(':sectionId', $sectionId);
    $sql->execute();

    return $sql->rowCount();
  }

   public function findAllDaily($date) {
    $checkinsDaily = [];

    $sql = $this->pdo->prepare("SELECT * FROM checkin WHERE ckin_date = :date ORDER BY ckin_time DESC");
    $sql->bindValue(':date', $date);
    $sql->execute();
    if($sql->rowCount() > 0) {
      $data = $sql->fetchAll();

      foreach($data as $checkin) {
        $u = new Checkin;
        $u->setId($checkin['ckin_id']);
        $u->setVehicleId($checkin['ckin_vehicle_id']);
        $u->setClientId($checkin['ckin_client_id']);
        $u->setSectionId($checkin['ckin_section_id']);
        $u->setTime($checkin['ckin_time']);
        $u->setUserId($checkin['ckin_user_id']);
        $u->setStatus($checkin['ckin_status']);
        $u->setDate($checkin['ckin_date']);

        $checkinsDaily[] = $u;
      }
    }
    return $checkinsDaily;
  } 

  public function findAllDailyVehicleId($date, $vehicleId) {
    $sql = $this->pdo->prepare("SELECT * FROM checkin WHERE ckin_vehicle_id = :vehicleId AND ckin_status = :status ORDER BY ckin_time DESC");
    $sql->bindValue(':vehicleId', $vehicleId);
    $sql->bindValue(':status', 'Ativo');
    $sql->execute();

    if($sql->rowCount() > 0) {
      $search = true;
    } else {
      $search = false;
    }
    return $search;
  } 

  public function findAllCheckinActive(){
    $checkinsActive = [];

    $sql = $this->pdo->prepare("SELECT * FROM checkin WHERE ckin_status = :status ORDER BY ckin_time ASC");
    $sql->bindValue(':status', 'Ativo');
    $sql->execute();

    if($sql->rowCount() > 0) {
      $data = $sql->fetchAll();

      foreach($data as $checkin) {
        $u = new Checkin;
        $u->setId($checkin['ckin_id']);
        $u->setVehicleId($checkin['ckin_vehicle_id']);
        $u->setClientId($checkin['ckin_client_id']);
        $u->setSectionId($checkin['ckin_section_id']);
        $u->setTime($checkin['ckin_time']);
        $u->setUserId($checkin['ckin_user_id']);
        $u->setStatus($checkin['ckin_status']);
        $u->setDate($checkin['ckin_date']);

        $checkinsActive[] = $u;
      }
    }
    return $checkinsActive;
  } 
}
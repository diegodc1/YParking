<?php
require_once('../models/Checkout.php');
// session_start();

class CheckoutDaoDB implements CheckoutDao {
  private $pdo;
   public function __construct(PDO $driver) {
    $this->pdo = $driver;
  }

  public function add(Checkout $u){
    $sql = $this->pdo->prepare("INSERT INTO checkout (ckout_vehicle_id, ckout_client_id, ckout_section_id, ckout_time, ckout_user_id, ckout_date, ckout_status, ckout_ckin_time, ckout_ckin_date, ckout_ckin_id, ckout_total_value) VALUES (:vehicleId, :clientId, :sectionId, :time, :userId, :date, :status, :ckinTime, :ckinDate, :ckinId, :ckTotalValue)");
    $sql->bindValue(':vehicleId', $u->getVehicleId());
    $sql->bindValue(':clientId', $u->getClientId());
    $sql->bindValue(':sectionId', $u->getSectionId());
    $sql->bindValue(':time', $u->getTime());
    $sql->bindValue(':userId', $u->getUserId());
    $sql->bindValue(':status', $u->getStatus());
    $sql->bindValue(':date', $u->getDate());
    $sql->bindValue(':ckinTime', $u->getCkinTime());
    $sql->bindValue(':ckinDate', $u->getCkinDate());
    $sql->bindValue(':ckinId', $u->getCkinId());
    $sql->bindValue(':ckTotalValue', $u->getTotalValue());
    $sql->execute();
    $_SESSION['lastCkoutId'] = $this->pdo->lastInsertId();
    $u->setId($this->pdo->lastInsertId());

    return $u;
  } 

  public function findAll(){
    $checkouts = [];

    $sql = $this->pdo->query("SELECT * FROM checkout ORDER BY ckout_date DESC,ckout_time DESC");
    if($sql->rowCount() > 0) {
      $data = $sql->fetchAll();

      foreach($data as $checkout) {
        $u = new Checkout;
        $u->setId($checkout['ckout_id']);
        $u->setVehicleId($checkout['ckout_vehicle_id']);
        $u->setClientId($checkout['ckout_client_id']);
        $u->setSectionId($checkout['ckout_section_id']);
        $u->setTime($checkout['ckout_time']);
        $u->setUserId($checkout['ckout_user_id']);
        $u->setStatus($checkout['ckout_status']);
        $u->setDate($checkout['ckout_date']);
        $u->setCkinTime($checkout['ckout_ckin_time']);
        $u->setCkinDate($checkout['ckout_ckin_date']);
        $u->setCkinId($checkout['ckout_ckin_id']);
        $u->setTotalValue($checkout['ckout_total_value']);

        $checkouts[] = $u;
      }
    }
    return $checkouts;
  }

  public function findById($id){
    $sql = $this->pdo->prepare("SELECT * FROM checkout WHERE ckout_id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();

    if($sql->rowCount() > 0) {
      $data = $sql->fetch();

      $u = new Checkout;;
      $u->setId($data['ckout_id']);
      $u->setVehicleId($data['ckout_vehicle_id']);
      $u->setClientId($data['ckout_client_id']);
      $u->setSectionId($data['ckout_section_id']);
      $u->setTime($data['ckout_time']);
      $u->setUserId($data['ckout_user_id']);
      $u->setStatus($data['ckout_status']); 
      $u->setDate($data['ckout_date']);
      $u->setCkinTime($data['ckout_ckin_time']);
      $u->setCkinDate($data['ckout_ckin_date']);
      $u->setCkinId($data['ckout_ckin_id']);
      $u->setTotalValue($data['ckout_total_value']);


      return $u;
    } else {
      return false;
    }
  }


  public function findLastCheckout(){
    $sql = $this->pdo->query("SELECT * FROM checkout ORDER BY ckout_id DESC LIMIT 1");

    if($sql->rowCount() > 0) {
      $data = $sql->fetch();

      $u = new Checkout;;
      $u->setId($data['ckout_id']);
      $u->setVehicleId($data['ckout_vehicle_id']);
      $u->setClientId($data['ckout_client_id']);
      $u->setSectionId($data['ckout_section_id']);
      $u->setTime($data['ckout_time']);
      $u->setUserId($data['ckout_user_id']);
      $u->setStatus($data['ckout_status']); 
      $u->setDate($data['ckout_date']);
      $u->setCkinTime($data['ckout_ckin_time']);
      $u->setCkinDate($data['ckout_ckin_date']);
      $u->setCkinId($data['ckout_ckin_id']);
      $u->setTotalValue($data['ckout_total_value']);


      return $u;
    } else {
      return false;
    }
  }

  public function update(Checkout $u){
    $sql = $this->pdo->prepare("UPDATE Checkout SET ckout_vehicle_id = :vehicleId, ckout_clientId = :clientId, ckout_section_id = :sectionId, ckout_time = :time, ckout_user_id = userId WHERE ckout_id = :id");

    $sql->bindValue(':vehicleId', $u->getVehicleId());
    $sql->bindValue(':clientId', $u->getClientId());
    $sql->bindValue(':sectionId', $u->getSectionId());
    $sql->bindValue(':time', $u->getTime());
    $sql->bindValue(':userId', $u->getUserId());
    $sql->bindValue(':ckinTime', $u->getCkinTime());
    $sql->bindValue(':ckinDate', $u->getCkinDate());
    $sql->bindValue(':ckinId', $u->getCkinId());
    $sql->bindValue(':id', $u->getId());

    $sql->execute();
    
    return true;
  }

  public function cancel($id, $reason, $userId, $ckinId){
    $sql = $this->pdo->prepare("UPDATE checkout SET ckout_status = :status, ckout_cancel_reason = :reason, ckout_cancel_user = :userId WHERE ckout_id = :id");
    $sql->bindValue(':id', $id);
    $sql->bindValue(':status', 'Cancelado');
    $sql->bindValue(':reason', $reason);
    $sql->bindValue(':userId', $userId);
    $sql->execute();  

    $sql = $this->pdo->prepare("UPDATE checkin SET ckin_status = :statusCkin WHERE ckin_id = :idCkin");
    $sql->bindValue(':statusCkin', 'Ativo');
    $sql->bindValue(':idCkin', $ckinId);
    $sql->execute();
  }


  //======= Daily Ckeckout Funcions =======// 
  public function addDaily(Checkout $u){

    $sql = $this->pdo->prepare("INSERT INTO checkout_daily (ckout_vehicle_id, ckout_client_id, ckout_section_id, ckout_time, ckout_user_id, ckout_status) VALUES (:vehicleId, :clientId, :sectionId, :time, :userId, 'Ativo')");
    $sql->bindValue(':vehicleId', $u->getVehicleId());
    $sql->bindValue(':clientId', $u->getClientId());
    $sql->bindValue(':sectionId', $u->getSectionId());
    $sql->bindValue(':time', $u->getTime());
    $sql->bindValue(':userId', $u->getUserId());
    $sql->bindValue(':ckinTime', $u->getCkinTime());
    $sql->bindValue(':ckinDate', $u->getCkinDate());
    $sql->bindValue(':ckinId', $u->getCkinId());
    $sql->execute();

    return $u;
  }

  public function returnSlotsByDate($date, $sectionId){
    $sql = $this->pdo->prepare("SELECT * FROM checkout WHERE ckout_date = :date AND ckout_section_id = :sectionId");
    $sql->bindValue(':date', $date);
    $sql->bindValue(':sectionId', $sectionId);
    $sql->execute();

    return $sql->rowCount();
  }

  public function returnTotalValueDate($date){
    $sql = $this->pdo->prepare("SELECT sum(ckout_total_value) as value FROM checkout WHERE ckout_date = :date");
    $sql->bindValue(':date', $date);
    $sql->execute();
    $data = $sql->fetch();

    return $data['value'];
  }

  public function findMonthlyToday($date){
    $sql = $this->pdo->prepare("SELECT count(ckout_total_value) as qtd FROM checkout WHERE ckout_total_value = 'R$ 0,00' AND ckout_date = :date");
    $sql->bindValue(':date', $date);
    $sql->execute();
    $data = $sql->fetch();

    return $data['qtd'];
  }

   public function findAllDaily($date) {
    $checkoutsDaily = [];

    $sql = $this->pdo->prepare("SELECT * FROM checkout WHERE ckout_date = :date ORDER BY ckout_time DESC");
    $sql->bindValue(':date', $date);
    $sql->execute();
    if($sql->rowCount() > 0) {
      $data = $sql->fetchAll();

      foreach($data as $checkout) {
        $u = new Checkout;
        $u->setId($checkout['ckout_id']);
        $u->setVehicleId($checkout['ckout_vehicle_id']);
        $u->setClientId($checkout['ckout_client_id']);
        $u->setSectionId($checkout['ckout_section_id']);
        $u->setTime($checkout['ckout_time']);
        $u->setUserId($checkout['ckout_user_id']);
        $u->setStatus($checkout['ckout_status']);
        $u->setDate($checkout['ckout_date']);
        $u->setCkinTime($checkout['ckout_ckin_time']);
        $u->setCkinDate($checkout['ckout_ckin_date']);
        $u->setCkinId($checkout['ckout_ckin_id']);
        $u->setTotalValue($checkout['ckout_total_value']);
        $u->setCancelReason($checkout['ckout_cancel_reason']);
        $u->setCancelUser($checkout['ckout_cancel_user']);


        $checkoutsDaily[] = $u;
      }
    }
    return $checkoutsDaily;
  } 

  public function findAllDailyVehicleId($date, $vehicleId) {
    $sql = $this->pdo->prepare("SELECT * FROM checkout WHERE ckout_vehicle_id = :vehicleId AND ckout_status = :status ORDER BY ckout_time DESC");
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

  // public function findAllCheckoutActive(){
  //   $checkoutsActive = [];

  //   $sql = $this->pdo->prepare("SELECT * FROM checkout WHERE ckout_status = :status ORDER BY ckout_time ASC");
  //   $sql->bindValue(':status', 'Ativo');
  //   $sql->execute();

  //   if($sql->rowCount() > 0) {
  //     $data = $sql->fetchAll();

  //     foreach($data as $checkout) {
  //       $u = new Checkout;
  //       $u->setId($checkout['ckout_id']);
  //       $u->setVehicleId($checkout['ckout_vehicle_id']);
  //       $u->setClientId($checkout['ckout_client_id']);
  //       $u->setSectionId($checkout['ckout_section_id']);
  //       $u->setTime($checkout['ckout_time']);
  //       $u->setUserId($checkout['ckout_user_id']);
  //       $u->setStatus($checkout['ckout_status']);
  //       $u->setDate($checkout['ckout_date']);

  //       $checkoutsActive[] = $u;
  //     }
  //   }
  //   return $checkoutsActive;
  // } 
}
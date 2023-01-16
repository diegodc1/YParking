<?php 

class Checkout {
  private $id;
  private $vehicleId;
  private $clientId;
  private $sectionId;
  private $time;
  private $userId;
  private $status;
  private $date;
  private $timeCkin;
  private $dateCkin;
  private $idCkin;
  private $cancelReason;
  private $cancelUser;
  private $totalValue;

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getVehicleId() {
    return $this->vehicleId;
  }

  public function setVehicleId($vehicleId) {
    $this->vehicleId = $vehicleId;
  }

  public function getClientId() {
    return $this->clientId;
  }

  public function setClientId($clientId) {
    $this->clientId = $clientId;
  }

  public function getSectionId() {
    return $this->sectionId;
  }

  public function setSectionId($sectionId) {
    $this->sectionId = $sectionId;
  }

  public function getTime() {
    return $this->time;
  }

  public function setTime($time) {
    $this->time = $time;
  }

  public function getUserId() {
    return $this->userId;
  }

  public function setUserId($userId) {
    $this->userId = $userId;
  }

  public function getStatus() {
    return $this->status;
  }

  public function setStatus($status) {
    $this->status = $status;
  }

  public function getDate() {
    return $this->date;
  }

  public function setDate($date) {
    $this->date = $date;
  }

  public function getCkinTime() {
    return $this->timeCkin;
  }

  public function setCkinTime($timeCkin) {
    $this->timeCkin = $timeCkin;
  }

  public function getCkinDate() {
    return $this->dateCkin;
  }

  public function setCkinDate($dateCkin) {
    $this->dateCkin = $dateCkin;
  }

  public function getCkinId() {
    return $this->idCkin;
  }

  public function setCkinId($idCkin) {
    $this->idCkin = $idCkin;
  }

  public function getTotalValue() {
    return $this->totalValue;
  }

  public function setTotalValue($value) {
    $this->totalValue = $value;
  }

  public function getCancelReason() {
    return $this->cancelReason;
  }

  public function setCancelReason($cancelReason) {
    $this->cancelReason = $cancelReason;
  }

  public function getCancelUser() {
    return $this->cancelUser;
  }

  public function setCancelUser($cancelUser) {
    $this->cancelUser = $cancelUser;
  }
}

interface CheckoutDao {
  public function add(Checkout $u);
  public function findAll();
  public function findById($id);
  public function findByClientId($id);
  public function findLastCheckout();
  public function update(Checkout $u);
  public function cancel($id, $reason, $userId, $ckinId);

  public function addDaily(Checkout $u);
  public function findAllDaily($date);
  public function findAllCheckoutThisMonth($month);
  public function findAllDailyVehicleId($date, $vehicleId);
  public function returnSlotsByDate($date, $sectionId);
  public function returnTotalValueDate($date);
  public function returnTotalValueMonth($date);
  public function findMonthlyToday($date);
  public function diffDatesThisMonth($date);
  public function canceledCkoutsThisMonth($date);
  public function totalValueMonthyClient($date);
  public function totalValueHourClient($date);
}

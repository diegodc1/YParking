<?php 

class Checkin {
  private $id;
  private $vehicleId;
  private $clientId;
  private $sectionId;
  private $time;
  private $userId;
  private $status;
  private $date;
  private $cancelReason;
  private $cancelUser;

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

interface CheckinDao {
  public function add(Checkin $u);
  public function findAll();
  public function findById($id);
  public function findActiveByClientId($id);
  public function findActiveByVehicleId($id);
  public function update(Checkin $u);
  public function updateStatus($status, $id);
  public function cancel($id, $reason, $userId);

  public function addDaily(Checkin $u);
  public function findAllDaily($date);
  public function findAllCheckinActive();
  public function findAllCheckinThisMonth($month);
  public function findAllDailyVehicleId($date, $vehicleId);
  public function findStatusDaily($status, $date);
  public function returnSlotsCkeckin($vehicleId);
  public function returnSlotsByDate($date, $sectionId);
  public function diffDatesThisMonth($date);
  public function canceledCkinsThisMonth($date);
}


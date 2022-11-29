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
}

interface CheckinDao {
  public function add(Checkin $u);
  public function findAll();
  public function findById($id);
  public function update(Checkin $u);
  public function cancel($id);

  public function addDaily(Checkin $u);
  public function findAllDaily($date);
  public function findAllCheckinActive();
  public function findAllDailyVehicleId($date, $vehicleId);
  public function returnSlotsByDate($date, $sectionId);
}

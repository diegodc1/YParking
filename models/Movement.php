<?php 

class Movement {
  private $id;
  private $type;
  private $date;
  private $time;
  private $vehicleId;
  private $clientId;
  private $userId;
  private $status;
  private $ckinId;
  private $ckoutId;

  public function getId(){
    return $this->id;
  }

  public function setId($id){
    $this->id = $id;
  }

  public function getType(){
    return $this->type;
  }

  public function setType($type){
    $this->type = $type;
  }

  public function getDate(){
    return $this->date;
  }

  public function setDate($date){
    $this->date = $date;
  }

  public function getTime(){
    return $this->time;
  }

  public function setTime($time){
    $this->time = $time;
  }

  public function getVehicleId(){
    return $this->vehicleId;
  }

  public function setVehicleId($vehicleId){
    $this->vehicleId = $vehicleId;
  }

  public function getClientId(){
    return $this->clientId;
  }

  public function setClientId($clientId){
    $this->clientId = $clientId;
  }

  public function getUserId(){
    return $this->userId;
  }

  public function setUserId($userId){
    $this->userId = $userId;
  }

  public function getStatus(){
    return $this->status;
  }

  public function setStatus($status){
    $this->status = $status;
  }

  public function getCkinId(){
    return $this->ckinId;
  }

  public function setCkinId($ckinId){
    $this->ckinId = $ckinId;
  }

  public function getCkoutId(){
    return $this->ckoutId;
  }

  public function setCkoutId($ckoutId){
    $this->ckoutId = $ckoutId;
  }
}

interface MovementDao {
  public function add(Movement $u);
  public function findAll();
  public function findById($id);
}
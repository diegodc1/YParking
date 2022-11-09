<?php 

class Vehicle {
  private $id;
  private $model;
  private $plate;
  private $color;
  private $category;
  private $brand;
  private $departureTime;
  private $clientId;
  private $client;

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id; 
  }

  public function getModel() {
    return $this->model;
  }

  public function setModel($model) {
    $this->model = ucwords(trim($model)); 
  }

  public function getPlate() {
    return $this->plate;
  }

  public function setPlate($plate) {
    $this->plate= trim($plate); 
  }

  public function getColor() {
    return $this->color;
  }

  public function setColor($color) {
    $this->color= trim($color); 
  }

  public function getCategory() {
    return $this->category;
  }

  public function setCategory($category) {
    $this->category= $category; 
  }

  public function getBrand() {
    return $this->brand;
  }

  public function setBrand($brand) {
    $this->brand = $brand; 
  }

  public function getDepartureTime() {
    return $this->departureTime;
  }

  public function setDepartureTime($dptime) {
    $this->departureTime= trim($dptime); 
  }

  public function getClientId() {
    return $this->clientId;
  }

  public function setClientId($clientId) {
    $this->clientId= $clientId; 
  }

  public function getClient() {
    return $this->client;
  }

  public function setClient($client) {
    $this->client= $client; 
  }
}

interface VehicleDao {
  public function add(Vehicle $u);
  public function findAll();
  public function findAllVehiClie();
  public function findByPlate($plate);
  public function findByClientId($clientId);
  public function findByClientIdQtd($clientId);
  public function findById($id);
  public function update(Vehicle $u);
  public function delete($id);
}

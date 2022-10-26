<?php
require_once('../models/Client.php');

class ClientDaoDB implements ClientDao {
  private $pdo;
  public function __construct(PDO $driver) {
    $this->pdo = $driver;
  }

  public function add(Client $u){
    $sql = $this->pdo->prepare("INSERT INTO clients (client_name, client_email, client_phone, client_cep, client_address, client_type, client_bussines_plan, client_departure_time, client_company_id) VALUES (:name, :email, :phone, :cep, :address, :type, :bussines, :departureTime, :companyId");
    $sql->bindValue(':name', $u->getName());
    $sql->bindValue(':email', $u->getEmail());
    $sql->bindValue(':phone', $u->getPhone());
    $sql->bindValue(':cep', $u->getCep());
    $sql->bindValue(':address', $u->getAddress());
    $sql->bindValue(':type', $u->getType());
    $sql->bindValue(':bussines', $u->getBussinesPlan());
    $sql->bindValue(':departureTime', $u->getDepartureType());
    $sql->bindValue(':companyId', $u->getCompanyId());

    $sql->execute();
    $u->setId($this->pdo->lastInsertId());
    return $u;
  }

  public function findAll(){}
  public function findById($id){}
  public function update(Client $u){}
  public function delete($id){}
}

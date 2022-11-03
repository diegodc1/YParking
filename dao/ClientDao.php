<?php
require_once('../models/Client.php');

class ClientDaoDB implements ClientDao {
  private $pdo;
  public function __construct(PDO $driver) {
    $this->pdo = $driver;
  }

  public function add(Client $u){
    $sql = $this->pdo->prepare("INSERT INTO clients (client_name, client_email, client_cep, client_phone, client_address, client_type, client_bussines_plan, client_departure_time, client_company_id) VALUES (:name, :email, :cep, :phone, :address, :type, :bussines, :departureTime, :companyId)");
    $sql->bindValue(':name', $u->getName());
    $sql->bindValue(':email', $u->getEmail());
    $sql->bindValue(':phone', $u->getPhone());
    $sql->bindValue(':cep', $u->getCep());
    $sql->bindValue(':address', $u->getAddress());
    $sql->bindValue(':type', $u->getType());
    $sql->bindValue(':bussines', $u->getBussinesPlan());
    $sql->bindValue(':departureTime', $u->getDepartureTime());
    $sql->bindValue(':companyId', $u->getCompanyId());

    $sql->execute();

    $u->setId($this->pdo->lastInsertId());
    return $u;
  }

  public function findAll(){
    $clients = [];

    $sql = $this->pdo->query("SELECT * FROM clients");
    if ($sql->rowCount() > 0) {
      $data = $sql->fetchAll();

      foreach ($data as $client) {
        $u = new Client;
        $u->setId($client['client_id']);
        $u->setName($client['client_name']);
        $u->setEmail($client['client_email']);
        $u->setPhone($client['client_phone']);
        $u->setAddress($client['client_address']);
        $u->setCep($client['client_cep']);
        $u->setType($client['client_type']);
        $u->setBussinesPlan($client['client_bussines_plan']);
        $u->setDepartureTime($client['client_departure_time']);
        $u->setCompanyId($client['client_company_id']);

        $clients[] = $u;
      }
    }
    return $clients;
  }


  public function findById($id){}
  public function update(Client $u){}
  public function delete($id){}
}

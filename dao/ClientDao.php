<?php
require_once('../models/Client.php');


class ClientDaoDB implements ClientDao {
  private $pdo;
  public function __construct(PDO $driver) {
    $this->pdo = $driver;
  }

  public function add(Client $u){
    $sql = $this->pdo->prepare("INSERT INTO clients (client_name, client_email, client_cep, client_phone, client_address, client_type, client_bussines_plan, client_departure_time, client_company_id, client_status) VALUES (:name, :email, :cep, :phone, :address, :type, :bussines, :departureTime, :companyId, :status)");
    $sql->bindValue(':name', $u->getName());
    $sql->bindValue(':email', $u->getEmail());
    $sql->bindValue(':phone', $u->getPhone());
    $sql->bindValue(':cep', $u->getCep());
    $sql->bindValue(':address', $u->getAddress());
    $sql->bindValue(':type', $u->getType());
    $sql->bindValue(':bussines', $u->getBussinesPlan());
    $sql->bindValue(':departureTime', $u->getDepartureTime());
    $sql->bindValue(':companyId', $u->getCompanyId());
    $sql->bindValue(':status', $u->getStatus());

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
        $u->setStatus($client['client_status']);

        $clients[] = $u;
      }
    }
    return $clients;
  }

  public function findAllAtive(){
    $clients = [];

    $sql = $this->pdo->query("SELECT * FROM clients WHERE client_status = 'Ativo'");
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
        $u->setStatus($client['client_status']);

        $clients[] = $u;
      }
    }
    return $clients;
  }

  public function findByIdReturnName($id) {
    $sql = $this->pdo->prepare("SELECT * FROM clients WHERE client_id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();

    if($sql->rowCount() > 0){
      $data = $sql->fetch();

      $u = new Client;
      $u->setId($data['client_id']);
      $u->setName($data['client_name']);

      return $u->getName();;
    } else {
      return false;
    }
  }

  // Busca pelo id de um cliente, e retorna a quantidade de valores encontrados.
  public function findByClientIdQtd($companyId) {
    $sql = $this->pdo->prepare("SELECT * FROM clients WHERE client_company_id = :companyId");
    $sql->bindValue(':companyId', $companyId);
    $sql->execute();
    $qtd = $sql->rowCount();

    return $qtd;
  }


  public function findById($id){
    $sql = $this->pdo->prepare("SELECT * FROM clients WHERE client_id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();

    if($sql->rowCount() > 0) {
      $data = $sql->fetch();

      $u = new Client;
      $u->setId($data['client_id']);
      $u->setName($data['client_name']);
      $u->setEmail($data['client_email']);
      $u->setPhone($data['client_phone']);
      $u->setAddress($data['client_address']);
      $u->setCep($data['client_cep']);
      $u->setType($data['client_type']);
      $u->setBussinesPlan($data['client_bussines_plan']);
      $u->setDepartureTime($data['client_departure_time']);
      $u->setCompanyId($data['client_company_id']);
      $u->setStatus($data['client_status']);

      return $u;
    } else {
      return false;
    }
  }

  public function update(Client $u){
    $sql = $this->pdo->prepare("UPDATE clients SET client_name = :name, client_email = :email, client_address = :address, client_type = :type, client_bussines_plan = :bussinessPlan, client_phone = :phone, client_cep = :cep WHERE client_id = :id");

    $sql->bindValue(':name', $u->getName());
    $sql->bindValue(':email', $u->getEmail());
    $sql->bindValue(':address', $u->getAddress());
    $sql->bindValue(':type', $u->getType());
    $sql->bindValue(':bussinessPlan', $u->getBussinesPlan());
    $sql->bindValue(':phone', $u->getPhone());
    $sql->bindValue(':cep', $u->getCep());
    $sql->bindValue(':id', $u->getId());

    $sql->execute();

    return true;
  }

  public function delete($id){
    $sql = $this->pdo->prepare("DELETE FROM clients WHERE client_id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();  
  }

  public function disable($id){
    $sql = $this->pdo->prepare("UPDATE clients SET client_status = :status WHERE client_id = :id");
    $sql->bindValue(':id', $id);
    $sql->bindValue(':status', 'Desativado');
    $sql->execute();  
  }

  public function reactivate($id){
    $sql = $this->pdo->prepare("UPDATE clients SET client_status = :status WHERE client_id = :id");
    $sql->bindValue(':id', $id);
    $sql->bindValue(':status', 'Ativo');
    $sql->execute();  
  }
}

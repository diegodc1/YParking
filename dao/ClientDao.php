<?php
require_once('../models/Client.php');
require_once('../models/Checkin.php');


class ClientDaoDB implements ClientDao {
  private $pdo;
  public function __construct(PDO $driver) {
    $this->pdo = $driver;
  }

  public function add(Client $u){
    $sql = $this->pdo->prepare("INSERT INTO clients (client_name, client_email, client_cep, client_phone, client_address, client_type, client_bussines_plan, client_departure_time, client_company_id, client_status, client_cad_date, client_cad_time) VALUES (:name, :email, :cep, :phone, :address, :type, :bussines, :departureTime, :companyId, :status, :cadDate, :cadTime)");
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
    $sql->bindValue(':cadDate', $u->getCadDate());
    $sql->bindValue(':cadTime', $u->getCadTime());

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
        $u->setCadDate($client['client_cad_date']);
        $u->setCadTime($client['client_cad_time']);

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
        $u->setCadDate($client['client_cad_date']);
        $u->setCadTime($client['client_cad_time']);

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
      $u->setCadDate($data['client_cad_date']);
      $u->setCadTime($data['client_cad_time']);

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

  public function setTimeAverage($id){
    $sql = $this->pdo->prepare("SELECT ckout_client_id, avg(ckout_time) FROM checkout WHERE ckout_client_id = :id AND ckout_status = 'Finalizado' AND ckout_date::date >= CURRENT_DATE - INTERVAL '4 days' GROUP BY ckout_client_id");
    $sql->bindValue(':id', $id);
    $sql->execute(); 
    $timeAverage = $sql->fetch(); 
    $timeAverage =  substr($timeAverage['avg'], 0, 8);

    $sql = $this->pdo->prepare("UPDATE clients SET client_departure_time = :timeAverage WHERE client_id = :clientId");
    $sql->bindValue(':timeAverage', $timeAverage);
    $sql->bindValue(':clientId', $id);
    $sql->execute();
  }

  public function findAllTimeAvgCkinActive(){
    $activeTimeAvg = [];

    $sql = $this->pdo->query("SELECT client_id, client_departure_time, ckin_id, ckin_status, ckin_vehicle_id FROM clients 
      INNER JOIN checkin ON clients.client_id = checkin.ckin_client_id AND clients.client_departure_time IS NOT NULL
      WHERE checkin.ckin_status = 'Ativo' AND clients.client_departure_time::time >= current_time AND clients.client_departure_time::time < current_time + interval '1 hours' ORDER BY clients.client_departure_time");

    if($sql->rowCount() > 0) {
        $data = $sql->fetchAll();

        foreach($data as $timeAvg) {
          $activeTimeAvg[] = $timeAvg; 
        }
    }

    return $activeTimeAvg;
  }


}

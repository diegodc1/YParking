<?php 

require_once('../models/Company.php');

class CompanyDaoDB implements CompanyDao {
  private $pdo;

  public function __construct(PDO $driver) {
    $this->pdo = $driver;
  }

  public function add(Company $u){
    $sql = $this->pdo->prepare("INSERT INTO companys (company_name, company_email, company_phone, company_slots) VALUES (:name, :email, :phone, :slots)");
    $sql->bindValue(':name', $u->getName());
    $sql->bindValue(':email', $u->getEmail());
    $sql->bindValue(':phone', $u->getPhone());
    $sql->bindValue(':slots', $u->getSlots());

    $sql->execute();

    $u->setId($this->pdo->lastInsertId());
    return $u;
  }

  public function findAll(){
    $companys = [];

    $sql = $this->pdo->query("SELECT * FROM companys");
    if($sql->rowCount() > 0) {
      $data = $sql->fetchAll();

      foreach($data as $company) {
        $u = new Company;
        $u->setId($company['company_id']);
        $u->setName($company['company_name']);
        $u->setEmail($company['company_email']);
        $u->setPhone($company['company_phone']);
        $u->setSlots($company['company_slots']);
        $companys[] = $u;
      }
    }
    return $companys;
  }

  public function findById($id){
    $sql = $this->pdo->prepare("SELECT * FROM companys WHERE company_id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();

    if($sql->rowCount() > 0) {
      $data = $sql->fetch();

      $u = new Company;
      $u->setId($data['company_id']);
      $u->setName($data['company_name']);
      $u->setEmail($data['company_email']);
      $u->setPhone($data['company_phone']);
      $u->setSlots($data['company_slots']);
      return $u;
    } else {
      return false;
    }
  }

  public function update(Company $u){
    $sql = $this->pdo->prepare("UPDATE companys SET company_name = :name, company_email = :email, company_phone = :phone, company_slots = :slots WHERE company_id = :id");

    $sql->bindValue(':name',$u->getName());
    $sql->bindValue(':email',$u->getEmail());
    $sql->bindValue(':phone',$u->getPhone());
    $sql->bindValue(':slots',$u->getSlots());

    $sql->execute();

    return true;
  }

  public function delete($id){
    $sql = $this->pdo->prepare("DELETE FROM companys WHERE company_id = :id");
    $sql->bindValue(':id',$id);
    $sql->execute();
  }
}
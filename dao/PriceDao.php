<?php 
require_once('../models/Price.php');

class PriceDaoDB implements PriceDao {
  private $pdo;

  public function __construct(PDO $driver){
    $this->pdo = $driver;
  }

  public function add(Price $u){
    $sql = $this->pdo->prepare("INSERT INTO prices (prc_car_15, prc_car_30, prc_car_1h, prc_car_2h, prc_car_3h, prc_car_6h, prc_car_day, prc_mtbike_15, prc_mtbike_30, prc_mtbike_1h, prc_mtbike_2h, prc_mtbike_3h, prc_mtbike_6h, prc_mtbike_day, prc_car_additional, prc_mtbike_additional, prc_car_month, prc_mtbike_month, prc_company_slot) VALUES (:car15, :car30, :car1h, :car2h, :car3h, :car6h, :carDay, :mtbike15, :mtbike30, :mtbike1h, :mtbike2h, :mtbike3h, :mtbike6h, :mtbikeDay, :carAddit, :mtbikeAddit, :carMonth, :mtbikeMonth, :companySlot)");
    $sql->bindValue(':car15', $u->getPrcCar15());
    $sql->bindValue(':car30', $u->getPrcCar30());
    $sql->bindValue(':car1h', $u->getPrcCar1h());
    $sql->bindValue(':car2h', $u->getPrcCar2h());
    $sql->bindValue(':car3h', $u->getPrcCar3h());
    $sql->bindValue(':car6h', $u->getPrcCar6h());
    $sql->bindValue(':carDay', $u->getPrcCarDay());
    $sql->bindValue(':mtbike15', $u->getPrcMtbike15());
    $sql->bindValue(':mtbike30', $u->getPrcMtbike30());
    $sql->bindValue(':mtbike1h', $u->getPrcMtbike1h());
    $sql->bindValue(':mtbike2h', $u->getPrcMtbike2h());
    $sql->bindValue(':mtbike3h', $u->getPrcMtbike3h());
    $sql->bindValue(':mtbike6h', $u->getPrcMtbike6h());
    $sql->bindValue(':mtbikeDay', $u->getPrcMtbikeDay());
    $sql->bindValue(':carAddit', $u->getPrcCarAdditional());
    $sql->bindValue(':mtbikeAddit', $u->getPrcMtbikeAdditional());
    $sql->bindValue(':carMonth', $u->getPrcCarMonth());
    $sql->bindValue(':mtbikeMonth', $u->getPrcMtbikeMonth());
    $sql->bindValue(':companySlot', $u->getCompanySlotPrice());

    $sql->execute();
    $u->setId($this->pdo->lastInsertId());
    return $u;
  }

  public function findAll(){
    // $prices;

    $sql = $this->pdo->query("SELECT * FROM prices WHERE prc_id = 1");
    $sql->execute();

    if($sql->rowCount() > 0){
      $data = $sql->fetch();


        $u = new Price;
        $u->setPrcCar15($data['prc_car_15']);
        $u->setPrcCar30($data['prc_car_30']);
        $u->setPrcCar1h($data['prc_car_1h']);
        $u->setPrcCar2h($data['prc_car_2h']);
        $u->setPrcCar3h($data['prc_car_3h']);
        $u->setPrcCar6h($data['prc_car_6h']);
        $u->setPrcCarDay($data['prc_car_day']);
        $u->setPrcMtbike15($data['prc_mtbike_15']);
        $u->setPrcMtbike30($data['prc_mtbike_30']);
        $u->setPrcMtbike1h($data['prc_mtbike_1h']);
        $u->setPrcMtbike2h($data['prc_mtbike_2h']);
        $u->setPrcMtbike3h($data['prc_mtbike_3h']);
        $u->setPrcMtbike6h($data['prc_mtbike_6h']);
        $u->setPrcMtbikeDay($data['prc_mtbike_day']);
        $u->setPrcMtbikeAdditional($data['prc_mtbike_additional']);
        $u->setPrcCarAdditional($data['prc_car_additional']);
        $u->setPrcMtbikeMonth($data['prc_mtbike_month']);
        $u->setPrcCarMonth($data['prc_car_month']);
        $u->setCompanySlotPrice($data['prc_company_slot']);

        return $u;
      
    } else {
      return false;
    }

    
  }

  public function update(Price $u){
    $sql = $this->pdo->prepare("UPDATE prices SET prc_car_15 = :car15, prc_car_30 = :car30, prc_car_1h = :car1h, prc_car_2h = :car2h, prc_car_3h = :car3h, prc_car_6h = :car6h, prc_car_day = :carDay,  prc_mtbike_15 = :mtbike15, prc_mtbike_30 =  :mtbike30, prc_mtbike_1h = :mtbike1h,  prc_mtbike_2h = :mtbike2h, prc_mtbike_3h = :mtbike3h, prc_mtbike_6h =  :mtbike6h, prc_mtbike_day = :mtbikeDay, prc_car_additional = :carAddit, prc_mtbike_additional = :mtbikeAddit, prc_car_month = :carMonth, prc_mtbike_month = :mtbikeMonth, prc_company_slot = :companySlotPrice WHERE prc_id = :id");

    $sql->bindValue(':car15', $u->getPrcCar15());
    $sql->bindValue(':car30', $u->getPrcCar30());
    $sql->bindValue(':car1h', $u->getPrcCar1h());
    $sql->bindValue(':car2h', $u->getPrcCar2h());
    $sql->bindValue(':car3h', $u->getPrcCar3h());
    $sql->bindValue(':car6h', $u->getPrcCar6h());
    $sql->bindValue(':carDay', $u->getPrcCarDay());
    $sql->bindValue(':mtbike15', $u->getPrcMtbike15());
    $sql->bindValue(':mtbike30', $u->getPrcMtbike30());
    $sql->bindValue(':mtbike1h', $u->getPrcMtbike1h());
    $sql->bindValue(':mtbike2h', $u->getPrcMtbike2h());
    $sql->bindValue(':mtbike3h', $u->getPrcMtbike3h());
    $sql->bindValue(':mtbike6h', $u->getPrcMtbike6h());
    $sql->bindValue(':mtbikeDay', $u->getPrcMtbikeDay());
    $sql->bindValue(':carAddit', $u->getPrcCarAdditional());
    $sql->bindValue(':mtbikeAddit', $u->getPrcMtbikeAdditional());
    $sql->bindValue(':carMonth', $u->getPrcCarMonth());
    $sql->bindValue(':mtbikeMonth', $u->getPrcMtbikeMonth());
    $sql->bindValue(':companySlotPrice', $u->getCompanySlotPrice());

    $sql->bindValue(':id', 1);

    $sql->execute();

    return true;
  }
  
}

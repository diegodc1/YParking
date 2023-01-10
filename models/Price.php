<?php 
class Price {
  private $id;
  private $prcCar15;
  private $prcCar30;
  private $prcCar1h;
  private $prcCar2h;
  private $prcCar3h;
  private $prcCar6h;
  private $prcCarDay;
  private $prcMtCarAdditional;
  private $prcCarMonth;
  private $prcMtbike15;
  private $prcMtbike30;
  private $prcMtbike1h;
  private $prcMtbike2h;
  private $prcMtbike3h;
  private $prcMtbike6h;
  private $prcMtbikeDay;
  private $prcMtbikeAdditional;
  private $prcMtbikeMonth;
  private $companySlotPrice;

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }
  
  public function getPrcCar15() {
    return $this->prcCar15;
  }

  public function setPrcCar15($prcCar15) {
    $this->prcCar15 = $prcCar15;
  }

  public function getPrcCar30() {
    return $this->prcCar30;
  }

  public function setPrcCar30($prcCar30) {
    $this->prcCar30 = $prcCar30;
  }

  public function getPrcCar1h() {
    return $this->prcCar1h;
  }

  public function setPrcCar1h($prcCar1h) {
    $this->prcCar1h = $prcCar1h;
  }
  
  public function getPrcCar2h() {
    return $this->prcCar2h;
  }

  public function setPrcCar2h($prcCar2h) {
    $this->prcCar2h = $prcCar2h;
  }

  public function getPrcCar3h() {
    return $this->prcCar3h;
  }

  public function setPrcCar3h($prcCar3h) {
    $this->prcCar3h = $prcCar3h;
  }

  public function getPrcCar6h() {
    return $this->prcCar6h;
  }

  public function setPrcCar6h($prcCar6h) {
    $this->prcCar6h = $prcCar6h;
  }

  public function getPrcCarDay() {
    return $this->prcCarDay;
  }

  public function setPrcCarDay($prcCarDay) {
    $this->prcCarDay = $prcCarDay;
  }

  public function getPrcCarAdditional() {
    return $this->prcMtCarAdditional;
  }

  public function setPrcCarAdditional($prcMtCarAdditional) {
    $this->prcMtCarAdditional = $prcMtCarAdditional;
  }

  public function getPrcCarMonth() {
    return $this->prcCarMonth;
  }

  public function setPrcCarMonth($prcCarMonth) {
    $this->prcCarMonth = $prcCarMonth;
  }

  public function getPrcMtbike15() {
    return $this->prcMtbike15;
  }

  public function setPrcMtbike15($prcMtbike15) {
    $this->prcMtbike15 = $prcMtbike15;
  }

  public function getPrcMtbike30() {
    return $this->prcMtbike30;
  }

  public function setPrcMtbike30($prcMtbike30) {
    $this->prcMtbike30 = $prcMtbike30;
  }

  public function getPrcMtbike1h() {
    return $this->prcMtbike1h;
  }

  public function setPrcMtbike1h($prcMtbike1h) {
    $this->prcMtbike1h = $prcMtbike1h;
  }

  public function getPrcMtbike2h() {
    return $this->prcMtbike2h;
  }

  public function setPrcMtbike2h($prcMtbike2h) {
    $this->prcMtbike2h = $prcMtbike2h;
  }

  public function getPrcMtbike3h() {
    return $this->prcMtbike3h;
  }

  public function setPrcMtbike3h($prcMtbike3h) {
    $this->prcMtbike3h = $prcMtbike3h;
  }

  public function getPrcMtbike6h() {
    return $this->prcMtbike6h;
  }

  public function setPrcMtbike6h($prcMtbike6h) {
    $this->prcMtbike6h = $prcMtbike6h;
  }

  public function getPrcMtbikeDay() {
    return $this->prcMtbikeDay;
  }

  public function setPrcMtbikeDay($prcMtbikeDay) {
    $this->prcMtbikeDay = $prcMtbikeDay;
  }

  public function getPrcMtbikeAdditional() {
    return $this->prcMtbikeAdditional;
  }

  public function setPrcMtbikeAdditional($additional) {
    $this->prcMtbikeAdditional = $additional;
  }

  public function getPrcMtbikeMonth() {
    return $this->prcMtbikeMonth;
  }

  public function setPrcMtbikeMonth($prcMtbikeMonth) {
    $this->prcMtbikeMonth = $prcMtbikeMonth;
  }

  public function getCompanySlotPrice() {
    return $this->companySlotPrice;
  }

  public function setCompanySlotPrice($companySlotPrice) {
    $this->companySlotPrice = $companySlotPrice;
  }
}

interface PriceDao {
  public function add(Price $u);
  public function findAll();
  public function update(Price $u);
}
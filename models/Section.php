<?php 

class Section {
  private $id;
  private $name;
  private $slots;
  private $color;
  private $status;

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getName() {
    return $this->name;
  }

  public function setName($name) {
    $this->name = $name;
  }

  public function getSlots() {
    return $this->slots;
  }

  public function setSlots($slots) {
    $this->slots = $slots;
  }

  public function getColor() {
    return $this->color;
  }

  public function setColor($color) {
    $this->color = $color;
  }

  public function getStatus() {
    return $this->status;
  }

  public function setStatus($status) {
    $this->status = $status;
  }
}

interface SectionDao {
  public function add(Section $u);
  public function findAll();
  public function findAllActive();
  public function findById($id);
  public function update(Section $u);
  public function disable($id);
  public function reactivate($id);
  public function totalSlots();
}
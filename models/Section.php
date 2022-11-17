<?php 

class Section {
  private $id;
  private $name;
  private $slots;
  private $color;

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
}

interface SectionDao {
  public function add(Section $u);
  public function findAll();
  public function findById($id);
  public function update(Section $u);
  public function delete($id);
}
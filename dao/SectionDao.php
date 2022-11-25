<?php
require_once('../models/Section.php');

class SectionDaoDB implements SectionDao {
  private $pdo;
  public function __construct(PDO $driver){
    $this->pdo = $driver;
  }

  public function add(Section $u){
    $sql = $this->pdo->prepare("INSERT INTO parking_sections (prk_sect_name, prk_sect_slots, prk_sect_color) VALUES (:prkName, :prkSlots, :prkColor)");
    $sql->bindValue(':prkName', $u->getName());
    $sql->bindValue(':prkSlots', $u->getSlots());
    $sql->bindValue(':prkColor', $u->getColor());
    $sql->execute();

    $u->setId($this->pdo->lastInsertId());
    return $u;
  }

  public function findAll(){
    $sections = [];
    $sql = $this->pdo->query("SELECT * FROM parking_sections ORDER BY prk_sect_name");

    if($sql->rowCount() > 0) {
      $data = $sql->fetchAll();

      foreach($data as $section) {
        $s = new Section;
        $s->setName($section['prk_sect_name']);
        $s->setSlots($section['prk_sect_slots']);
        $s->setColor($section['prk_sect_color']);
        $s->setId($section['prk_sect_id']);

        $sections[] = $s;
      }
    }

    return $sections;
  }

  public function findById($id){
    $sql = $this->pdo->prepare("SELECT * FROM parking_sections WHERE prk_sect_id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();

    if($sql->rowCount() > 0) {
      $data = $sql->fetch();

      $s = new Section;
      $s->setId($data['prk_sect_id']);
      $s->setName($data['prk_sect_name']);
      $s->setSlots($data['prk_sect_slots']);
      $s->setColor($data['prk_sect_color']);

      return $s;
    } else {
      return false;
    }
  }

  public function update(Section $u){
    $sql = $this->pdo->prepare("UPDATE parking_sections SET prk_sect_name = :name, prk_sect_slots = :slots, prk_sect_color = :color WHERE prk_sect_id = :id");

    $sql->bindValue(':name', $u->getName());
    $sql->bindValue(':slots', $u->getSlots());
    $sql->bindValue(':color', $u->getColor());

    $sql->execute();

    return true;
  }

  public function delete($id){
    $sql = $this->pdo->prepare("DELETE FROM parking_sections WHERE prk_sect_id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();  
  }
}
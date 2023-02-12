<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of TournamnetType
 *
 * @author 16981925
 */
class TournamnetType {

    private $id, $description, $isActive;

    public function __construct($id, $description, $isActive) {
        $this->id = $id;
        $this->description = $description;
        $this->isActive = $isActive;
    }

    public function getId() {
        return $this->id;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getIsActive() {
        return $this->isActive;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

}

<?php

class Mode {

    private $id, $description, $image_link;

    public function __construct($id, $description, $image_link) {
        $this->id = $id;
        $this->description = $description;
        $this->image_link = $image_link;
    }

    public function getId() {
        return $this->id;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getImageLink() {
        return $this->image_link;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setImageLink($image_link) {
        $this->image_link = $image_link;
    }
}

<?php
declare(strict_types=1);

class Contact
{
    //Declare private properties
    private int $id;
    private string $title;
    private string $name;
    private string $surname;
    private string $birthdate;
    private string $phone;
    private string $email;
    private bool $favourite;
    private bool $important;
    private bool $archived;


    // get methods
    public function getId() : int { return $this->id; }
    public function getTitle() : string { return $this->title; }
    public function getName() : string { return $this->name; }
    public function getSurname() : string { return $this->surname; }
    public function getBirthdate() : string { return $this->birthdate; }
    public function getPhone() : string { return $this->phone; }
    public function getEmail() : string { return $this->email; }
    public function getFavourite() : bool { return $this->favourite; }
    public function getImportant() : bool { return $this->important; }
    public function getArchived() : bool { return $this->archived; }


    // set methods
    public function setId(int $id) : void { $this->id = $id; }
    public function setTitle(string $title)  : void { $this->title = $title; }
    public function setName(string $name) : void { $this->name = $name; }
    public function setSurname(string $surname) : void { $this->surname = $surname; }
    public function setBirthdate(string $birthdate) : void { $this->birthdate = $birthdate; }
    public function setPhone(string $phone) : void { $this->phone = $phone; }
    public function setEmail(string $email) : void { $this->email = $email; }
    public function setFavourite(bool $favourite) : void { $this->favourite = $favourite; }
    public function setImportant(bool $important) : void { $this->important = $important; }
    public function setArchived(bool $archived) : void { $this->archived = $archived; }


    //Constructor
    public function __construct(array $contact = array(
        "id" => 0,
        "title" => "Mr.",
        "name" => "",
        "surname" => "",
        "birthdate" => "",
        "phone" => "",
        "email" => "",
        "favourite" => false,
        "important" => false,
        "archived" => false
    )) {
        $this->id = $contact["id"];
        $this->title = $contact["title"];
        $this->name = $contact["name"];
        $this->surname = $contact["surname"];
        $this->birthdate = $contact["birthdate"];
        $this->phone = $contact["phone"];
        $this->email = $contact["email"];
        $this->favourite = $contact["favourite"];
        $this->important = $contact["important"];
        $this->archived = $contact["archived"];
    }


    //Override __toString()
    public function __toString() : string {
        return
            "Id: " . $this->id . "\n" .
            "Contact: " . $this->title . " " . $this->name . " " . $this->surname . "\n" .
            "Birth Date" . $this->birthdate . "\n" .
            "Phone: " . $this->phone . "\n" .
            "E-mail: " . $this->email . "\n" .
            "Type: " . ($this->favourite ? '[Favourite] ' : '') .  ($this->important ? '[Important] ' : '') . ($this->archived ? '[Archived]' : '');
    }

}




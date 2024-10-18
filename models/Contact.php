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
            "Id: " . $this->id . "<br>" .
            "Contact: " . $this->title . " " . $this->name . " " . $this->surname . "<br>" .
            "Birth Date" . $this->birthdate . "<br>" .
            "Phone: " . $this->phone . "<br>" .
            "E-mail: " . $this->email . "<br>" .
            "Type: " . ($this->favourite ? '[Favourite] ' : '') .  ($this->important ? '[Important] ' : '') . ($this->archived ? '[Archived]' : '') . "<br>";
    }



    //Exercise 2 => Move the functions checkContactDate and checkBirthday from the file functions.php from the Unit 3 to the class

    // ***********************
    // * Unit 3 - Exercise 1 *
    // ***********************

    public function checkContactDate() : bool {
        // YYYY-MM-DD
        // The len must be = 10, the value of year,month and day must be numeric and be in the valid range and separator characters must be "-"
        return  strlen($this->birthdate) == 10 && 
                $this->isValidYear($this->getYear($this->birthdate)) && 
                substr($this->birthdate,4,1) == "-" && 
                $this->isValidMonth($this->getMonth($this->birthdate)) &&
                substr($this->birthdate,7,1) == "-" && 
                $this->isValidDay($this->getYear($this->birthdate),$this->getMonth($this->birthdate),$this->getDay($this->birthdate));
    }


    private function getYear(string $date) : string {
        return substr($date,0,4);
    }


    private function isValidYear(string $year) : bool {
        // The year must be between 1900 and 2100
        return is_numeric($year) && $year >= 1900 && $year <= 2100;
    }


    private function getMonth(string $date) : string {
        return substr($date,5,2);
    }


    private function isValidMonth(string $month) : bool {
        // The month must be between 1 and 12
        return is_numeric($month) && $month >= 1 && $month <= 12;
    }


    private function getDay(string $date) : string {
        return substr($date,8,2);
    }


    private function isValidDay(string $year,string $month,string $day) : bool {
        // 1 and 31 if the month is 1, 3, 5, 7, 8, 10, 12
        // 1 and 30 if the month is 4, 6, 9, 11
        // 28 if the month is 2 and the year is not leap year
        // 29 if the month is 2 and the year is a leap year

        if (is_numeric($year) && is_numeric($month) && is_numeric($day)) {
            switch ($month) {
                case 1: $daysOfMonth = 31; break;
                case 2: $daysOfMonth = $this->yearIsLeap($year)? 29 : 28; break;
                case 3: $daysOfMonth = 31; break;
                case 4: $daysOfMonth = 30; break;
                case 5: $daysOfMonth = 31; break;
                case 6: $daysOfMonth = 30; break;
                case 7: $daysOfMonth = 31; break;
                case 8: $daysOfMonth = 31; break;
                case 9: $daysOfMonth = 30; break;
                case 10: $daysOfMonth = 31; break;
                case 11: $daysOfMonth = 30; break;
                case 12: $daysOfMonth = 31; break;
                default: $daysOfMonth = 00;
            }
            return $day > 0 && $day <= $daysOfMonth;
        } else {
            return false;
        }
    }


    private function yearIsLeap(string $year) : bool {
        // A year is a leap year if it is divisible by 4
        // But it is not a leap year if it is divisible by 100, unless it is also divisible by 400.
        if (is_numeric($year) && (($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0))) {
            return true;
        } else {
            return false;
        }
    }



    // ***********************
    // * Unit 3 - Exercise 2 *
    // ***********************

    public function checkBirthday() : ?int {
        if ($this->checkContactDate()) {

            // Create DateTime objects only with de date values
            $dateToday = new DateTime(date("Y-m-d"));
            $dateBirthday = $this->nextBirthday(new DateTime($this->birthdate));

            //Calculate de difference 
            $difference=date_diff($dateToday,$dateBirthday);

            return (int) $difference->format("%a");
        
        } else {
            return null;
        }
    }

    private function nextBirthday(DateTime $date) : DateTime {
        // We look the next birthday date after the current date
        $dateToday = new DateTime(date('Y-m-d'));
        $dateBirthday = $date;

        // We set the year of $dateBirthday with the current year
        $dateBirthday->setDate((int)$dateToday->format('Y'),(int)$date->format('m'),(int)$date->format('d'));

        // If the $dateBirthday has already passed, we add a year
        if ($dateBirthday < $dateToday) {
            $dateBirthday->add(new DateInterval('P1Y')); // adds 1 year
        } 

        return $dateBirthday;
    }



    // ***********************
    // * Unit 4 - Exercise 1 *
    // ***********************

    public function validate(): array {
        $errors = [];
    
        //name, surname and birthdate: required.
        //as the date input must be of type date, we don’t need validation
        if (empty($this->name)) {
            $errors["name"] = "* First name is required";
        }
    
        if (empty($this->surname)) {
            $errors["surname"] = "* Surname is required";
        }
    
        if (empty($this->birthdate)) {
            $errors["birthdate"] = "* Birth date is required";
        } elseif (!$this->checkContactDate()){
            $errors["birthdate"] = "* Birth date has not a valid format ";
        }
    
        //phone: required and must be a valid phone number(use preg_match() and regular expressions).
        if (empty($this->phone)) {
            $errors["phone"] = "* Phone is required";
        } elseif (!preg_match("/^[0-9]{9}$/", $this->phone)) { //Validates 9-digit phone numbers
            $errors["phone"] = "* Phone has not a valid format => 9-digit phone number";
        }
    
        //email: required and must be a valid email(use filter_var()).
        if (empty($this->email)) {
            $errors["email"] = "* E-mail is required";
        } elseif (!filter_var($this->email,FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "* E-mail has not a valid format => pattern name@domain.ext";
        }
    
        return $errors;
    }


}




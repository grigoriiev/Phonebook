<?php

class ContactController
{

    public $page;

    public $auth;

    public $querybuilder;

    public $user;

    
    public $phoneBook;

    public function __construct($phoneBook)
    {

        $this->page = "Добавление контакта";
        $this->phoneBook=$phoneBook;
    }

    public function index()
    {

        $page = $this->page;

        include 'views/create-contact.php';
    }

    public function createContact()
    {
        $name = htmlspecialchars($_POST['name']);

        $tel = htmlspecialchars($_POST['tel']);



      $validate = $this->phoneBook->validateContact($name,$tel);


        if ($validate['error'] && !$validate['success']) {

             throw new Exception(json_encode($validate), 400);

        }

        $phoneBook = $this->phoneBook->create($name,$tel);

        if ($phoneBook['error'] && !$phoneBook['success']) {

             throw new Exception(json_encode($phoneBook), 400);

        } else {
            echo json_encode($phoneBook);

        }

        return;
    }



}
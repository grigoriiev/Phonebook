<?php

class ListContactsController
{
    public $page;

    public $auth;

    public $querybuilder;

    public $user;

    public $phoneBook;

    public function __construct($phoneBook)
    {

        $this->page = "Список контактов";
        $this->phoneBook=$phoneBook;


    }

    public function index()
    {

        $page = $this->page;
        $phoneBooks=$this->list();

        include 'views/list-contacts.php';
    }

    public function list()
    {

        $phoneBooks = $this->phoneBook->getContacts();

        if(isset($phoneBooks['error'])){
            throw new Exception(json_encode($phoneBooks), 400);
        }
        return $phoneBooks;
    }


    public function deleteContact()
    {

        $name = htmlspecialchars($_POST['name']);
        $tel = htmlspecialchars($_POST['tel']);

        $delete = $this->phoneBook->deleteContact($name, $tel);

        if(isset( $delete['error'])){
            throw new Exception(json_encode( $delete), 400);
        }
        echo json_encode($delete);
    }








}
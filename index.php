<?php
require_once "./autoload.php";


try {



    $url_array = explode("/", $_SERVER['REQUEST_URI']);

    function getService()
    {
        $qerybuilder = new PhoneBookBuilder();
        return new Phonebook($qerybuilder);
    }


    if (isset($url_array[1]) && isset($url_array[2])) {

        $controller = ucfirst(trim($url_array[1])) . 'Controller';
        $phonebook = getService();
        $controller = (new $controller($phonebook))->{$url_array[2]}();
    } else if (isset($url_array[1]) && $_SERVER['REQUEST_URI'] !== "/") {

        $controller = ucfirst(trim($url_array[1])) . 'Controller';
        $phonebook = getService();
        (new $controller($phonebook))->index();

    } else {

        $phonebook = getService();
        if ($_SERVER['REQUEST_URI'] == "/") {
            (new ListContactsController($phonebook))->index();
        }
    }


} catch (Exception $e) {
    echo $e->getMessage();


}
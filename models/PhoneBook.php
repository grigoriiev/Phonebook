<?php
class Phonebook
{


    public $phoneBookBuilder;
    public function __construct($phoneBookBuilder)
    {

        $this->phoneBookBuilder = $phoneBookBuilder;
    }

    public function validateContact($name, $tel)
    {

        if (!$name && iconv_strlen($name) < 5) {

            return ['success' => false, 'error' => true, 'message' => 'Ведите имя миннимум 5 симболов'];

        }

        if (!$tel) {

            return ['success' => false, 'error' => true, 'message' => 'Введите телефон'];

        }
        $regexp = '~' .
            '^(?:\+7|8)\d{10}$|' .
            '^8[\s-]\d{3}-\d(?:-\d{3})+$|' .
            '^\s?8\s?\(\d{4}\)\s?\d{2}(?:-\d{2}){2}$|' .
            '^8-\d{3}-\d{7}$|' .
            '^8\s?\(\d{3}\)\s?\d{2}\s?\d{3}\s?\d{2}$|' .
            '^8-\d{3}\s?\d{2}\s?\d{3}\s?\d{2}$|' .
            '^8\s?\(\d{3}\)\s?-\s?\d{3}(?:\s?-\s?\d{2}){2}$|' .
            '^\+\s?7(?:\s?\d{3}){2}\s?\d{4}$|' .
            '^8\s?\(\s?\d{3}\s?\)\s?\d{7}$|' .
            '^8(?:\s?\d{3}){2}\s?\d{4}$' .
            '~';
        if (!preg_match($regexp, $tel)) {

            return ['success' => false, 'error' => true, 'message' => 'Введите корректный телефон из РФ'];

        }

        if ($this->phoneBookBuilder->getTel($tel)) {

            return ['success' => false, 'error' => true, 'message' => 'Данный телефон уже используется'];

        }
        return ['success' => true, 'error' => false];
    }

    public function create($name, $tel)
    {


        try {

            $phonebook = $this->phoneBookBuilder->create($name, $tel);

        } catch (Exception $e) {

            return ['success' => false, 'error' => true, 'message' => 'Ошибка!'];

        }

        return ['success' => true, 'error' => false, 'message' => 'Контакт добавлен!', 'tel' => $phonebook[0]['tel'], 'name' => $phonebook[0]['name']];


    }



    public function getContact($name, $tel)
    {
        try {

            $phonebook = $this->phoneBookBuilder->getOne($name, $tel);


        } catch (Exception $e) {

            return ['name' => false, 'tel' => false];

        }
        return $phonebook;
    }


    public function getContacts()
    {
        try {

            $phonebooks = $this->phoneBookBuilder->getAll();

        } catch (Exception $e) {

            return ['error' => true, 'success' => false, 'message' => 'Ошибка!'];



        }
        return $phonebooks;
    }

    public function deleteContact($name, $tel)
    {

        try {

            $this->phoneBookBuilder->delete($name, $tel);

        } catch (Exception $e) {

            return ['error' => true, 'success' => false, 'message' => 'Ошибка!'];

        }
        return ['error' => false, 'success' => true, 'message' => 'Контакт успешно удален!'];

    }

}
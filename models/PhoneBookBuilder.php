<?php

class PhoneBookBuilder
{

    public $taskList;

    public function __construct()
    {

        $file = file_get_contents('models/db/data.json');
        $this->taskList = json_decode($file, TRUE);
    }


    public function getAll()
    {
        return $this->taskList;
    }

    public function getOne($name, $tel)
    {

        foreach ($this->taskList as $key => $value) {
            if ($tel === $value['tel'] && $name === $value['name']) {
                $phoneBook = $this->taskList[$key];
            }
        }
        return $phoneBook;
    }

    public function getTel($tel)
    {

        $phone = false;
        foreach ($this->taskList as $key => $value) {
            if ($tel === $value['tel']) {
                $phone = true;
            }
        }
        return $phone;

    }



    public function create($name, $tel)
    {

        $this->taskList[] = array('name' => $name, 'tel' => $tel);
        file_put_contents('models/db/data.json', json_encode($this->taskList));
        return $this->taskList;

    }

    public function delete($name, $tel)
    {
        foreach ($this->taskList as $key => $value) {
            if ($tel === $value['tel'] && $name === $value['name']) {
                unset($this->taskList[$key]);
            }
        }
        file_put_contents('models/db/data.json', json_encode($this->taskList));
        unset($this->taskList);
    }
}
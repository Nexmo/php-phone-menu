<?php
namespace NexmoDemo;

/**
 * Represents access to order data.
 */
class Orders
{
    private $database;

    public function __construct($database)
    {
        $this->database = [];
        foreach($database as $row){
            if(!isset($header)){
                $header = $row;
                continue;
            }

            $this->database[] = array_combine($header, $row);
        }
    }

    public function findAllByNumber($number)
    {
        return array_filter($this->database, function($row) use ($number){
            if($row['number'] == $number){
                return true;
            }
        });
    }

    public function findOneByNumber($number)
    {
        return array_reduce($this->database, function($carry, $item) use ($number){
            if($item['number'] != $number){
                return $carry;
            }

            if(empty($carry) AND ($item['number'] == $number)){
                return $item;
            }

            if(empty($carry)){
                return;
            }

            if($carry['date'] > $item['date']){
                return $carry;
            }

            return $item;
        });
    }

    public function findOneById($id)
    {
        foreach($this->database as $row){
            if($id == $row['id']){
                return $row;
            }
        }
    }
}
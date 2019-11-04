<?php

include_once 'config.php';

class Transactions {

    private $mysql;
    
    public $types;

    public function __construct() {
		
		$this->types = ['deposit','withdraw','bet','win'];

        $this->mysql = new \mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if ($this->mysql->connect_errno) {
            echo "Connection failed\n";
            echo "Error: {$this->mysql->connect_error}\n";
            die();
        }

    }

    public function getCount() {

        $result = $this->mysql->query("SELECT count(*) AS Transactions FROM testdata");
        $row = $result->fetch_assoc();
        return $row['Transactions'];

    }

    public function getList($limit, $offset) {

        $result = $this->mysql->query("SELECT * FROM testdata LIMIT {$offset},{$limit}");
        return $result->fetch_all(MYSQLI_ASSOC);

    }

    public function getSummary() {

        $query = "SELECT 
                type, SUM(amount) as amount
            FROM
                testdata
            GROUP BY type
            ORDER BY type";
        $result = $this->mysql->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);

    }

    public function getTop() {

        $query = "SELECT 
                user, amount
            FROM
                testdata
            ORDER BY amount desc
            limit 10";
        $result = $this->mysql->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);

    }
    
    public function addTransaction($user, $type, $amount){
		if(!in_array($type, $this->types)){
			return "Type incorrect";	
		}
		if(!is_numeric($amount)){
			return "Amount incorrect";
		}
		$query = "INSERT into testdata (user,type,amount) VALUES ('".$this->mysql->real_escape_string($user)."','".$type."','".intval($amount)."')";
		$this->mysql->query($query);
		return "Ready";
	}

}

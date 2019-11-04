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
		if(file_exists("cache.txt")){
			$cache = file_get_contents("cache.txt");
			$cache = json_decode($cache, true);
			if(time() - filemtime("cache.txt") > CACHE_TIME || !isset($cache['Transactions'])){
				$result = $this->mysql->query("SELECT count(id) AS Transactions FROM testdata");
				$row = $result->fetch_assoc();
				$cache['Transactions'] = $row['Transactions'];
				file_put_contents("cache.txt", json_encode($cache));
			}
			$row['Transactions'] = $cache['Transactions'];
		}else{			
			$result = $this->mysql->query("SELECT count(id) AS Transactions FROM testdata");
			$row = $result->fetch_assoc();
			$cache['Transactions'] = $row['Transactions'];
			file_put_contents("cache.txt", json_encode($cache));
		}
        return $row['Transactions'];

    }

    public function getList($limit, $offset) {
		if(file_exists("cache.txt")){
			$cache = file_get_contents("cache.txt");
			$cache = json_decode($cache, true);
			if(time() - filemtime("cache.txt") > CACHE_TIME || !isset($cache['list'][$limit."-".$offset])){
				$result = $this->mysql->query("SELECT id, user, type, amount FROM testdata LIMIT {$offset},{$limit}");
				$ret = $result->fetch_all(MYSQLI_ASSOC);
				$cache['list'][$limit."-".$offset] = $ret;
				file_put_contents("cache.txt", json_encode($cache));
			}
			$ret = $cache['list'][$limit."-".$offset];
		}else{
			$result = $this->mysql->query("SELECT id, user, type, amount FROM testdata LIMIT {$offset},{$limit}");
			$ret = $result->fetch_all(MYSQLI_ASSOC);
			$cache['list'][$limit."-".$offset] = $ret;
			file_put_contents("cache.txt", json_encode($cache));
		}
		return $ret;
    }

    public function getSummary() {

        $query = "SELECT 
                type, SUM(amount) as amount
            FROM
                testdata
            GROUP BY type
            ORDER BY type";
        if(file_exists("cache.txt")){
			$cache = file_get_contents("cache.txt");
			$cache = json_decode($cache, true);
			if(time() - filemtime("cache.txt") > CACHE_TIME || !isset($cache['summary'])){
				$result = $this->mysql->query($query);
				$ret = $result->fetch_all(MYSQLI_ASSOC);
				$cache['summary'] = $ret;
				file_put_contents("cache.txt", json_encode($cache));
			}
			$ret = $cache['summary'];
		}else{    
			$result = $this->mysql->query($query);
			$ret = $result->fetch_all(MYSQLI_ASSOC);
			$cache['summary'] = $ret;
			file_put_contents("cache.txt", json_encode($cache));
        }
        return $ret;

    }

    public function getTop() {

        $query = "SELECT 
                user, amount
            FROM
                testdata
            ORDER BY amount desc
            limit 10";
            
        if(file_exists("cache.txt")){
			$cache = file_get_contents("cache.txt");
			$cache = json_decode($cache, true);
			if(time() - filemtime("cache.txt") > CACHE_TIME || !isset($cache['top'])){
				$result = $this->mysql->query($query);
				$ret = $result->fetch_all(MYSQLI_ASSOC);
				$cache['top'] = $ret;
				file_put_contents("cache.txt", json_encode($cache));
			}
			$ret = $cache['top'];
		}else{
			$result = $this->mysql->query($query);
			$ret = $result->fetch_all(MYSQLI_ASSOC);
			$cache['top'] = $ret;
			file_put_contents("cache.txt", json_encode($cache));
		}
        
        return $ret;

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
		unlink("cache.txt");
		return "Ready";
	}

}

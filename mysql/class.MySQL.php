<?php
class MySQL {
	
	// Base variables
    var $lastError;         // Holds the last error
	var $lastQuery;         // Holds the last query
	var $result;            // Holds the MySQL query result
	var $records;           // Holds the total number of records returned
	var $affected;          // Holds the total number of records affected
	var $rawResults;        // Holds raw 'arrayed' results
	var $arrayedResult;     // Holds an array of the result
	
	var $hostname;          // MySQL Hostname
	var $username;          // MySQL Username
	var $password;          // MySQL Password
	var $database;          // MySQL Database
	
	var $databaseLink;      // Database Connection Link
	


	/* *******************
	 * Class Constructor *
	 * *******************/
	
	function __construct($database, $username, $password, $hostname='localhost', $port=3306){
		$this->database = $database;
		$this->username = $username;
		$this->password = $password;
		$this->hostname = $hostname.':'.$port;
		
		$this->Connect();
	}
	
	
	
	/* *******************
	 * Private Functions *
	 * *******************/
	
	// Connects class to database
	// $persistant (boolean) - Use persistant connection?
	private function Connect($persistant = false){
		$this->CloseConnection();
		
		if($persistant){
			$this->databaseLink = mysql_pconnect($this->hostname, $this->username, $this->password);
		}else{
			$this->databaseLink = mysql_connect($this->hostname, $this->username, $this->password);
		}
		
		if(!$this->databaseLink){
   		$this->lastError = 'Could not connect to server: ' . mysql_error($this->databaseLink);
			return false;
		}
		
		if(!$this->UseDB()){
			$this->lastError = 'Could not connect to database: ' . mysql_error($this->databaseLink);
			return false;
		}
		return true;
	}
	
	
	// Select database to use
	private function UseDB(){
		if(!mysql_select_db($this->database, $this->databaseLink)){
			$this->lastError = 'Cannot select database: ' . mysql_error($this->databaseLink);
			return false;
		}else{
			return true;
		}
	}
	
	
	// Performs a 'mysql_real_escape_string' on the entire array/string
	private function SecureData($data, $types){
		if(is_array($data)){
//            $i = 0;
			foreach($data as $key=>$val){
				if(!is_array($data[$key])){
//                    $data[$key] = $this->CleanData($data[$key], $types[$i]);
					$data[$key] = mysql_real_escape_string($data[$key], $this->databaseLink);
//                    $i++;
				}
			}
		}else{
            $data = $this->CleanData($data, $types);
			$data = mysql_real_escape_string($data, $this->databaseLink);
		}
		return $data;
	}
    
    // clean the variable with given types
    // possible types: none, str, int, float, bool, datetime, ts2dt (given timestamp convert to mysql datetime)
    // bonus types: hexcolor, email
    private function CleanData($data, $type = ''){
        switch($type) {
            case 'none':
                $data = $data;
                break;
            case 'str':
                $data = settype( $data, 'string');
                break;
            case 'int':
                $data = settype( $data, 'integer');
                break;
            case 'float':
                $data = settype( $data, 'float');
                break;
            case 'bool':
                $data = settype( $data, 'boolean');
                break;
            // Y-m-d H:i:s
            // 2014-01-01 12:30:30
            case 'datetime':
                $data = trim( $data );
                $data = preg_replace('/[^\d\-: ]/i', '', $data);
                preg_match( '/^([\d]{4}-[\d]{2}-[\d]{2} [\d]{2}:[\d]{2}:[\d]{2})$/', $data, $matches );
                $data = $matches[1];
                break;
            case 'ts2dt':
                $data = settype( $data, 'integer');
                $data = date('Y-m-d H:i:s', $data);
                break;

            // bonus types
            case 'hexcolor':
                preg_match( '/(#[0-9abcdef]{6})/i', $data, $matches );
                $data = $matches[1];
                break;
            case 'email':
                $data = filter_var($data, FILTER_VALIDATE_EMAIL);
                break;
            default:
                $data = '';
                break;
        }
        return $data;
    }



    /* ******************
     * Public Functions *
     * ******************/

    // Executes MySQL query
    public function executeSQL($query){
        $this->lastQuery = $query;
        if($this->result = mysql_query($query, $this->databaseLink)){
            if (gettype($this->result) === 'resource') {
                $this->records  = @mysql_num_rows($this->result);
                $this->affected = @mysql_affected_rows($this->databaseLink);
            } else {
               $this->records  = 0;
               $this->affected = 0;
            }

            if($this->records > 0){
                $this->arrayResults();
                return $this->arrayedResult;
            }else{
                return true;
            }

        }else{
            $this->lastError = mysql_error($this->databaseLink);
            return false;
        }
    }


    // Adds a record to the database based on the array key names
    public function insert($table, $vars, $exclude = '', $datatypes){

        // Catch Exclusions
        if($exclude == ''){
            $exclude = array();
        }

        array_push($exclude, 'MAX_FILE_SIZE'); // Automatically exclude this one

        // Prepare Variables
        $vars = $this->SecureData($vars, $datatypes);

        $query = "INSERT INTO `{$table}` SET ";
        foreach($vars as $key=>$value){
            if(in_array($key, $exclude)){
                continue;
            }
            $query .= "`{$key}` = '{$value}', ";
        }

        $query = trim($query, ', ');
//var_dump($query);
        return $this->executeSQL($query);
    }

    // Deletes a record from the database
    public function delete($table, $where='', $limit='', $like=false, $wheretypes){
        $query = "DELETE FROM `{$table}` WHERE ";
        if(is_array($where) && $where != ''){
            // Prepare Variables
            $where = $this->SecureData($where, $wheretypes);

            foreach($where as $key=>$value){
                if($like){
                    $query .= "`{$key}` LIKE '%{$value}%' AND ";
                }else{
                    $query .= "`{$key}` = '{$value}' AND ";
                }
            }

            $query = substr($query, 0, -5);
        }

        if($limit != ''){
            $query .= ' LIMIT ' . $limit;
        }

        return $this->executeSQL($query);
    }


    // Gets a single row from $from where $where is true
    public function select($from, $where='', $orderBy='', $limit='', $like=false, $operand='AND',$cols='*', $wheretypes){
        // Catch Exceptions
        if(trim($from) == ''){
            return false;
        }

        $query = "SELECT {$cols} FROM `{$from}` WHERE ";

        if(is_array($where) && $where != ''){
            // Prepare Variables
            $where = $this->SecureData($where, $wheretypes);

            foreach($where as $key=>$value){
                if($like){
                    $query .= "`{$key}` LIKE '%{$value}%' {$operand} ";
                }else{
                    $query .= "`{$key}` = '{$value}' {$operand} ";
                }
            }

            $query = substr($query, 0, -(strlen($operand)+2));

        }else{
            $query = substr($query, 0, -6);
        }

        if($orderBy != ''){
            $query .= ' ORDER BY ' . $orderBy;
        }

        if($limit != ''){
            $query .= ' LIMIT ' . $limit;
        }

        return $this->executeSQL($query);

    }

    // Updates a record in the database based on WHERE
    public function update($table, $set, $where, $exclude = '', $datatypes, $wheretypes){
        // Catch Exceptions
        if(trim($table) == '' || !is_array($set) || !is_array($where)){
            return false;
        }
        if($exclude == ''){
            $exclude = array();
        }

        array_push($exclude, 'MAX_FILE_SIZE'); // Automatically exclude this one

        $set 	= $this->SecureData($set, $datatypes);
        $where 	= $this->SecureData($where,$wheretypes);

        // SET

        $query = "UPDATE `{$table}` SET ";

        foreach($set as $key=>$value){
            if(in_array($key, $exclude)){
                continue;
            }
            $query .= "`{$key}` = '{$value}', ";
        }

        $query = substr($query, 0, -2);

        // WHERE

        $query .= ' WHERE ';

        foreach($where as $key=>$value){
            $query .= "`{$key}` = '{$value}' AND ";
        }

        $query = substr($query, 0, -5);

        return $this->executeSQL($query);
    }

    // 'Arrays' a single result
    public function arrayResult(){
        $this->arrayedResult = mysql_fetch_assoc($this->result) or die (mysql_error($this->databaseLink));
        return $this->arrayedResult;
    }

    // 'Arrays' multiple result
    public function arrayResults(){

        if($this->records == 1){
            return $this->arrayResult();
        }

        $this->arrayedResult = array();
        while ($data = mysql_fetch_assoc($this->result)){
            $this->arrayedResult[] = $data;
        }
        return $this->arrayedResult;
    }

    // 'Arrays' multiple results with a key
    public function arrayResultsWithKey($key='id'){
        if(isset($this->arrayedResult)){
            unset($this->arrayedResult);
        }
        $this->arrayedResult = array();
        while($row = mysql_fetch_assoc($this->result)){
            foreach($row as $theKey => $theValue){
                $this->arrayedResult[$row[$key]][$theKey] = $theValue;
            }
        }
        return $this->arrayedResult;
    }

    // Returns last insert ID
    public function lastInsertID(){
        return mysql_insert_id();
    }

    // Return number of rows
    public function countRows($from, $where=''){
        $result = $this->select($from, $where, '', '', false, 'AND','count(*)');
        return $result["count(*)"];
    }

    // Closes the connections
    public function closeConnection(){
        if($this->databaseLink){
            mysql_close($this->databaseLink);
        }
    }
}
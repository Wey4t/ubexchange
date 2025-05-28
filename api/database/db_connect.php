<?php
    header("Access-Control-Allow-Methods: *");
    header("Access-Control-Allow-Origin: http://localhost:3000");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: Content-Type, Authorization,access-control-allow-origin");
    
    class DbConnect {
        ########## docker #############
        private $hn = 'db';
        private $un = 'root';
        private $pw = 'Password123#@!';
        private $db = "cse442_2023_spring_team_m_db";
        public $conn;
        
        function __destruct(){
            if ($this->conn) {
                $this->conn->close();
            }
        }
        
        public function connect() {
            try{
                $conn = new mysqli($this->hn, $this->un, $this->pw, $this->db);
                if ($conn->connect_error) {
                    throw new Exception("Connection failed: " . $conn->connect_error);
                }
                $this->conn = $conn;
                return $conn;
            } catch (Exception $e) {
                error_log("Database connection error: " . $e->getMessage());
                throw $e;
            }
        }
    }

    function check_user_password($username, $password){
        if($username == "" || $password == ""){
            return false;
        }
        if(!have_username($username)){
            return false;
        }else{
            $row = get_by_username($username);
            if($password == $row['hash']){
                return true;
            }
            if(password_verify($password, $row['hash'])){
                return true;
            }
            return false;
        }
    }
    
    function get_id_by_uid($uid){
        // Implementation needed
    }
    
    function check_auth_cookie($auth_cookie){
        $row = get_tb_col_value("cookies","auth_id",$auth_cookie);
        // Implementation needed
    }
    
    function escape_string($string){
        $objDb = new DbConnect;
        $conn = $objDb->connect();
        return $conn->real_escape_string($string);
    }
    
    function saveuid($uid,$id){
        if(!check_tb_col_value_exist("cookies","id",$id)){
            $sql = "INSERT INTO cookies (id, uid) VALUES (?,?)";
            get($sql,array($id,$uid));
        }else{
            $sql = "UPDATE cookies SET uid = ? WHERE id = ?";
            get($sql,array($uid,$id));
        }
    }
    
    function randomStr($len){
        if($len<=0) return "";
        $set = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $setlen = strlen($set);
        $str = '';
        for ($i = 0; $i < $len; $i++) {
            $str = $str.$set[rand(0, $setlen-1)];
        }
        return $str;
    }
    
    function have_username($username){
        return check_tb_col_value_exist("users","username",$username);
    }
    
    function have_id_in_cookies($id){
        return check_tb_col_value_exist("cookies","id",$id);
    }
    
    function get_by_username($username){
        return get_tb_col_value("users","username",$username);
    }
    
    function get_by_id($id){
        return get_tb_col_value("users","id",$id);
    }
    
    function get_by_uid($uid){
        return get_tb_col_value("cookies","uid",$uid);
    }
    
    ################## basic function ########################
    function get_tb_col_value($tb,$col,$value, $muti=false){
        $sql = "SELECT * FROM $tb WHERE $col = ?";
        $args = array($value);
        return get($sql,$args,$muti);
    }
    
    function get($sql,$params,$muti=false){
        $objDb = new DbConnect;
        $conn = $objDb->connect();
        
        if ($conn->error){
            error_log("Database connection error: " . $conn->error);
            die("Database connection failed");
        }
        
        // Debug: Log the SQL query
        error_log("Executing SQL: " . $sql);
        error_log("Parameters: " . print_r($params, true));
        
        $stmt = $conn->prepare($sql);
        
        // Check if prepare failed
        if (!$stmt) {
            error_log("SQL prepare failed: " . $conn->error);
            error_log("Failed SQL: " . $sql);
            die("SQL prepare failed: " . $conn->error);
        }
        
        // Only bind parameters if there are any
        if(count($params) > 0){
            $ss = str_repeat('s', count($params));
            $stmt->bind_param($ss, ...$params);
        }
        
        if (!$stmt->execute()) {
            error_log("SQL execute failed: " . $stmt->error);
            $stmt->close();
            die("SQL execute failed: " . $stmt->error);
        }
        
        $result = $stmt->get_result();
        $stmt->close();
        
        if(!$result){
            return array();
        }
        
        if(!$muti) {
            return $result->fetch_assoc();
        } else {
            $ans = array();
            while($row = $result->fetch_assoc()){
                array_push($ans,$row);
            }
            return $ans;
        }
    }
    
    function check_tb_condition_exist($sql, $condition){
        $result = get($sql,$condition,true);
        $rows = count($result);
        return $rows > 0;
    }
    
    function check_tb_col_value_exist($tb,$col,$value){
        if($value == "" || $tb == "" || $col == ""){
            error_log("Empty arguments in check_tb_col_value_exist");
            return false;
        }
        
        $sql = "SELECT * FROM $tb WHERE $col = ?";
        $result = get($sql,array($value),true);
        $rows = count($result);
        return $rows > 0;
    }
    
    function update_tb_col_value_where($tb,$col,$value,$where){
        $objDb = new DbConnect;
        $conn = $objDb->connect();
        $sql = "UPDATE $tb SET $col = $value WHERE $where";
        $conn->query($sql);
        
        if ($conn->error){
            error_log("Update query failed: " . $conn->error);
            die("Error: " . $conn->error);
        }
        return $conn->error;
    }
    
    function insert_tb_cols_values($tb, $cols ,$values){
        $objDb = new DbConnect;
        $conn = $objDb->connect();
        $sql = "INSERT INTO $tb $cols VALUES $values";
        $conn->query($sql);
        
        if ($conn->error){
            error_log("Insert query failed: " . $conn->error);
            die("Error: " . $conn->error);
        }
    }
?>
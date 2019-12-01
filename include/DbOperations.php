<?php

class DbOperation
{
    //Database connection link
    private $con;

    //Class constructor
    function __construct()
    {
        //Getting the DbConnect.php file
        require_once dirname(__FILE__) . '/DbConnect.php';

        //Creating a DbConnect object to connect to the database
        $db = new DbConnect();

        //Initializing our connection link of this class
        //by calling the method connect of DbConnect class
        $this->con = $db->connect();
    }

    //Method for user  login
    public function userLogin($userId ,$pass){
        

        //Generating password hash
        $password = md5($pass);
        //print_r($password."\n");
        //Creating query
        $stmt = $this->con->prepare("SELECT name from LOTTY_USERS WHERE phone = ? or email = ? and password = ? and type =2");
        //binding the parameters
        //print_r($stmt);
        $stmt->bind_param("sss", $userId,$userId,$password);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    //This method will return user detail
    public function getUserDetails($username){
        $stmt = $this->con->prepare("SELECT * FROM LOTTY_USERS WHERE PHONE=? or EMAIL=?  and type=2");
        $stmt->bind_param("ss",$username,$username);
        $stmt->execute();
        
        //Getting the student result array
        $stmt->store_result();
        
        $student = $this->get_result($stmt);
        //print_r($student);
        $stmt->close();
        //returning the student
        return $student[0];
    }
     //Method will create a new user
    public function createLottyUser($phone,$name,$email,$password){
        //First we will check whether the student is already registered or not
        if (!$this->isUserExists($phone,$email)) {
            //Encrypting the password
            $password = md5($password);
            //Generating an API Key
            //$apikey = $this->generateApiKey();
            $prefix = "LTT";
            $dd =date("Y");
            $type = 2;
            //2 means user level
            //Crating an statement
            $stmt = $this->con->prepare("INSERT INTO LOTTY_USERS(name,phone,password,type,email,prefix,year) values(?, ?, ?, ?,?,?,?)");
            //print_r($stmt);
            //Binding the parameters
            $stmt->bind_param("ssssssi", $name,$phone,$password,$type,$email,$prefix,$dd);
            
            //Executing the statment
            $result = $stmt->execute();

            //Closing the statment
            $stmt->close();

            //If statment executed successfully
            if ($result) {
                //Returning 0 means student created successfully
                return 0;
            } else {
                //Returning 1 means failed to create student
                return 1;
            }
        } else {
            //returning 2 means user already exist in the database
            return 2;
        }
    }

    //Method will create a new user
    public function createLottyRoom($room_name,$room_description,$room_time_length,$room_ticket_price){
        //First we will check whether the student is already registered or not
        if (!$this->isRoomExists($room_name)) {
            //Crating an statement
            $stmt = $this->con->prepare("INSERT INTO LOTTY_ROOMS(room_name,room_description,room_time_length,room_ticket_price) values(?, ?, ?, ?)");
            //print_r($stmt);
            //Binding the parameters
            $stmt->bind_param("sssd", $room_name,$room_description,$room_time_length,$room_ticket_price);
            
            //Executing the statment
            $result = $stmt->execute();

            //Closing the statment
            $stmt->close();

            //If statment executed successfully
            if ($result) {
                //Returning 0 means room created successfully
                return 0;
            } else {
                //Returning 1 means failed to create room
                return 1;
            }
        } else {
            //returning 2 means room already exist in the database
            return 2;
        }
    }

     //Method will create a new user
     public function updateLottyRoom($room_id,$room_description,$room_time_length,$room_ticket_price){
        //First we will check whether the student is already registered or not
        if (!$this->isRoomActive($room_id)) {
            //Crating an statement
            $stmt = $this->con->prepare("update LOTTY_ROOMS set room_description=?,room_time_length=?,room_ticket_price=? where room_id =?");
            //print_r($stmt);
            //Binding the parameters
            $stmt->bind_param("ssds", $room_description,$room_time_length,$room_ticket_price,$room_id);
            
            //Executing the statment
            $result = $stmt->execute();
            $affRows=mysqli_affected_rows($this->con);///->affectedRows();
            //print_r($affRows);
            //Closing the statment
            $stmt->close();
            
            //If statment executed successfully
            if ($affRows) {
                //Returning 0 means room created successfully
                return 0;
            } else {
                //Returning 1 means failed to update room
                return 1;
            }
        }else{
            return 2;
        }
        
    }

     //Method will create a new user
     public function startGame($room_id){
        //First we will check whether the student is already registered or not
        //print_r($check_update);
        if (!$this->isGameAleadyStarted($room_id)) {
            //Crating an statement
            $stmt = $this->con->prepare("insert into  LOTTY_GAME_START (game_time_length ,game_room_id )values((select room_time_length from LOTTY_ROOMS where room_id = ?),? )");
            //print_r($stmt);
            //Binding the parameters
            $stmt->bind_param("ss", $room_id,$room_id);
            
            //Executing the statment
            $result = $stmt->execute();
           // $affRows=mysqli_affected_rows($this->con);///->affectedRows();
            //print_r($affRows);
            //Closing the statment
            $stmt->close();
            
            //If statment executed successfully
            if ($result) {
                //Returning 0 means room created successfully
                $check_update = $this -> updateLottyRoomStatus($room_id);

                return 0;
            } else {
                //Returning 1 means failed to update room
                return 1;
            }
        }else{
            return 2;
        }
        
    }
    //Method will create a new user
    public function updateLottyRoomStatus($room_id){
        //First we will check whether the student is already registered or not
        if ($this->isRoomActive($room_id)) {
            //Crating an statement
            $stmt = $this->con->prepare("update LOTTY_ROOMS set game_started=1 where room_id =?");
            //print_r($stmt);
            //Binding the parameters
            $stmt->bind_param("i", $room_id);
            
            //Executing the statment
            $result = $stmt->execute();
            $affRows=mysqli_affected_rows($this->con);///->affectedRows();
           // print_r($stmt);
            //Closing the statment
            $stmt->close();
            
            //If statment executed successfully
            if ($affRows) {
                //Returning 0 means room created successfully
                return 0;
            } else {
                //Returning 1 means failed to update room
                return 1;
            }
        }else{
            return 2;
        }
        
    }

    //Method will save user transaction details here
    public function saveTransaction($room_id,$user_id,$online_trans_id,$game_id,$trans_amt){
        //First we will check whether the student is already registered or not
        //print_r($check_update);
       
            //Crating an statement
            $stmt = $this->con->prepare("insert into  LOTTY_TICKETS_TRANSACTION (user_id ,online_trans_id,room_id,game_id,trans_amt )values(?,?,?,?,?)");
            //print_r($stmt);
            //Binding the parameters
            $stmt->bind_param("sssss", $user_id,$online_trans_id,$room_id,$game_id,$trans_amt);
            
            //Executing the statment
            $result = $stmt->execute();
           // $affRows=mysqli_affected_rows($this->con);///->affectedRows();
            
            //Closing the statment
            $stmt->close();
            //print_r($result);
            //If statment executed successfully
            if ($result) {

                return 0;
            } else {
                //Returning 1 means failed to save transaction room
                return 1;
            }
        
        
    }

    function getRoomList(){
        $stmt = $this->con->prepare("SELECT * FROM LOTTY_ROOMS where room_active = 1");
        //$stmt->bind_param("ss",$username,$username);
        $stmt->execute();
        
        //Getting the student result array
        $stmt->store_result();
        
        $rooms = $this->get_result($stmt);
        //print_r($rooms);
        $stmt->close();
        //returning the student
        return $rooms;
    }
    
    function get_result( $Statement ) {
        $RESULT = array();
        $Statement->store_result();
        for ( $i = 0; $i < $Statement->num_rows; $i++ ) {
            $Metadata = $Statement->result_metadata();
            $PARAMS = array();
            while ( $Field = $Metadata->fetch_field() ) {
                $PARAMS[] = &$RESULT[ $i ][ $Field->name ];
            }
            call_user_func_array( array( $Statement, 'bind_result' ), $PARAMS );
            $Statement->fetch();
        }
        return $RESULT;
    }
    //Checking whether a user already exist
    private function isUserExists($phone,$email) {
        $stmt = $this->con->prepare("SELECT name from LOTTY_USERS WHERE phone = ? or email = ?");
        $stmt->bind_param("ss", $phone,$email);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
    //Checking whether a room already exist
    private function isRoomExists($room_name) {
        $stmt = $this->con->prepare("SELECT room_name from LOTTY_ROOMS WHERE room_name = ?");
        $stmt->bind_param("s", $room_name);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    //Checking whether a room active exist
    private function isRoomActive($room_id) {
        $stmt = $this->con->prepare("SELECT room_name from LOTTY_ROOMS WHERE room_id = ? and room_active = 1");
        $stmt->bind_param("s", $room_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

     //Checking whether a game already started
     private function isGameAleadyStarted($room_id) {
         //some comment odo add check for max id while checking the data no need as there will be only 1 game status only 
        $stmt = $this->con->prepare("SELECT game_id from LOTTY_GAME_START WHERE game_room_id = ? and game_status = 1");
        $stmt->bind_param("s", $room_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
    //This method will generate a unique api key
    private function generateApiKey(){
        return md5(uniqid(rand(), true));
    }
}
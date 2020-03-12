<?php

//including the required files
require_once '../include/DbOperations.php';


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require '../vendor/autoload.php';


//Creating a slim instance
$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$c = new \Slim\Container($configuration);
$app = new \Slim\App($c);
//$app = new \Slim\App;
//transaction start

 //transaction status
 $app->get('/transactionStatus', function (Request $req,  Response $res, $args = [])  {
 
    //Creating a response array
    $response = array();
    if(!verifyRequiredParams(array('room_id','user_id','online_trans_id','game_id','trans_amt'),$req)){
        return;
    }
    //reading post parameters
    $room_id = $req->getParam('room_id');
    $user_id = $req->getParam('user_id');
    $online_trans_id = $req->getParam('online_trans_id');
    $game_id = $req->getParam('game_id');
    $trans_amt = $req->getParam('trans_amt');
    
    //Creating a DbOperation object
    $db = new DbOperation();
    //Calling the method createStudent to add student to the database
    $res = $db->transactionStatus($user_id,$room_id,$online_trans_id,$game_id,$trans_amt);
   // echoResponse(201, $res);
    //If the result returned is 0 means success
    if ($res == 0) {
        //Making the response error false
        $response["error"] = false;
        //Adding a success message
        $response["message"] = "Transaction initiated successfully";
        $response["status"] = $res;

        //Displaying response
        echoResponse(201, $response);
    //If the result returned is 1 means failure
    }else if ($res == -1) {
        //Making the response error false
        $response["error"] = true;
        //Adding a success message
        $response["message"] = "No Rows found";
        //Displaying response
        echoResponse(201, $response);
    //If the result returned is 1 means failure
    } else if ($res == 1) {
        $response["error"] = true;
        $response["message"] = "There is some error";
        echoResponse(200, $response);
    //If the result returned is 2 means user already exist
    } else if ($res == 2) {
        $response["error"] = true;
        $response["message"] = "Sorry,  There is some error";
        echoResponse(200, $response);
    }
});
//transaction status end

//initiate transaction 
$app->get('/initiateTransaction', function (Request $req,  Response $res, $args = [])  {
 
    //Creating a response array
    $response = array();
    if(!verifyRequiredParams(array('room_id','user_id','online_trans_id','game_id','trans_amt'),$req)){
        return;
    }
    //reading post parameters
    $room_id = $req->getParam('room_id');
    $user_id = $req->getParam('user_id');
    $online_trans_id = $req->getParam('online_trans_id');
    $game_id = $req->getParam('game_id');
    $trans_amt = $req->getParam('trans_amt');
    
    //Creating a DbOperation object
    $db = new DbOperation();
    //Calling the method createStudent to add student to the database
    $res = $db->initiateTransaction($user_id,$room_id,$online_trans_id,$game_id,$trans_amt);
    //If the result returned is 0 means success
    if ($res == 0) {
        //Making the response error false
        $response["error"] = false;
        //Adding a success message
        $response["message"] = "Transaction initiated successfully";
        //Displaying response
        echoResponse(201, $response);
    //If the result returned is 1 means failure
    } else if ($res == 1) {
        $response["error"] = true;
        $response["message"] = "There is some error";
        echoResponse(200, $response);
    //If the result returned is 2 means user already exist
    } else if ($res == 2) {
        $response["error"] = true;
        $response["message"] = "Sorry,  There is some error";
        echoResponse(200, $response);
    }
});

$app->get('/saveTransaction', function (Request $req,  Response $res, $args = [])  {
 
    //Creating a response array
    $response = array();
    if(!verifyRequiredParams(array('room_id','user_id','online_trans_id','game_id','trans_amt'),$req)){
        return;
    }
    //reading post parameters
    $room_id = $req->getParam('room_id');
    $user_id = $req->getParam('user_id');
    $online_trans_id = $req->getParam('online_trans_id');
    $game_id = $req->getParam('game_id');
    $trans_amt = $req->getParam('trans_amt');
    
    //Creating a DbOperation object
    $db = new DbOperation();
    //Calling the method createStudent to add student to the database
    $res = $db->saveTransaction($room_id,$user_id,$online_trans_id,$game_id,$trans_amt);
    //If the result returned is 0 means success
    if ($res == 0) {
        //Making the response error false
        $response["error"] = false;
        //Adding a success message
        $response["message"] = "Transaction added successfully";
        //Displaying response
        echoResponse(201, $response);
    //If the result returned is 1 means failure
    } else if ($res == 1) {
        $response["error"] = true;
        $response["message"] = "There is some error";
        echoResponse(200, $response);
    //If the result returned is 2 means user already exist
    } else if ($res == 2) {
        $response["error"] = true;
        $response["message"] = "Sorry,  There is some error";
        echoResponse(200, $response);
    }
});

//transaction end here 


//create new user if not created in this function
$app->get('/addUser', function (Request $req,  Response $res, $args = [])  {
 
   
    //Verifying the required parameters
    //echoResponse(200,'sd');
    //verifyRequiredParams(array('myvar'),$req);
    //$myvar = $req->getParam('myvar');
    //echo $myvar;


    //Creating a response array
    $response = array();
    if(!verifyRequiredParams(array('phone','name','pass','email'),$req)){
        return;
    }
    //reading post parameters
    $phone = $req->getParam('phone');
    $name = $req->getParam('name');
    $pass = $req->getParam('pass');
    $email = $req->getParam('email');

    //Creating a DbOperation object
    $db = new DbOperation();
 
    //Calling the method createStudent to add student to the database
    $res = $db->createLottyUser($phone,$name,$email,$pass);
 
    //If the result returned is 0 means success
    if ($res == 0) {
        //Making the response error false
        $response["error"] = false;
        //Adding a success message
        $response["message"] = "User Registered successfully";
        //Displaying response
        echoResponse(201, $response);
 
    //If the result returned is 1 means failure
    } else if ($res == 1) {
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while adding User";
        echoResponse(200, $response);
 
    //If the result returned is 2 means user already exist
    } else if ($res == 2) {
        $response["error"] = true;
        $response["message"] = "Sorry,  user  already registered with this phone or email";
        echoResponse(200, $response);
    }
   
});

//user login request
$app->get('/userLogin',function(Request $req,  Response $res, $args = []) {
    //verifying required parameters
    if(!verifyRequiredParams(array('username','pass'),$req)){
        return;
    }
    
    //getting post values
    $username = $req->getParam('username');
    $pass = $req->getParam('pass');

 
    //Creating DbOperation object
    $db = new DbOperation();
 
    //Creating a response array
    $response = array();
 
    //If username password is correct
    if($db->userLogin($username,$pass)){
        //Getting user detail
        $student = $db->getUserDetails($username);
        //echoResponse(200,$student);
        //Generating response
        $response['error'] = false;
        $response['id'] = $student['id'];
        $response['name'] = $student['name'];
        $response['phone'] = $student['phone'];
        $response['email'] = $student['email'];
    }else{
        //Generating response
        $response['error'] = true;
        $response['message'] = "Invalid username or password";
    }
 
    //Displaying the response
    echoResponse(200,$response);
});

//create new user if not created in this function
$app->get('/createRoom', function (Request $req,  Response $res, $args = [])  {
 
   
    //Verifying the required parameters
    //echoResponse(200,'sd');
    //verifyRequiredParams(array('myvar'),$req);
    //$myvar = $req->getParam('myvar');
    //echo $myvar;


    //Creating a response array
    $response = array();
    if(!verifyRequiredParams(array('room_name','room_description','room_time_length','room_ticket_price'),$req)){
        return;
    }
    //reading post parameters
    $room_name = $req->getParam('room_name');
    $room_description = $req->getParam('room_description');
    $room_time_length = $req->getParam('room_time_length');
    $room_ticket_price = $req->getParam('room_ticket_price');

    //Creating a DbOperation object
    $db = new DbOperation();
 
    //Calling the method createStudent to add student to the database
    $res = $db->createLottyRoom($room_name,$room_description,$room_time_length,$room_ticket_price);
 
    //If the result returned is 0 means success
    if ($res == 0) {
        //Making the response error false
        $response["error"] = false;
        //Adding a success message
        $response["message"] = "Room successfully created";
        //Displaying response
        echoResponse(201, $response);
 
    //If the result returned is 1 means failure
    } else if ($res == 1) {
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while adding User";
        echoResponse(200, $response);
 
    //If the result returned is 2 means user already exist
    } else if ($res == 2) {
        $response["error"] = true;
        $response["message"] = "Sorry,  room  already registered with this rooma name";
        echoResponse(200, $response);
    }
   
});

//update room details
$app->get('/updateRoom', function (Request $req,  Response $res, $args = [])  {
 
    //Creating a response array
    $response = array();
    if(!verifyRequiredParams(array('room_id','room_description','room_time_length','room_ticket_price'),$req)){
        return;
    }
    //reading post parameters
    $room_id = $req->getParam('room_id');
    $room_description = $req->getParam('room_description');
    $room_time_length = $req->getParam('room_time_length');
    $room_ticket_price = $req->getParam('room_ticket_price');

    //Creating a DbOperation object
    $db = new DbOperation();
    //Calling the method createStudent to add student to the database
    $res = $db->updateLottyRoom($room_id,$room_description,$room_time_length,$room_ticket_price);
    //If the result returned is 0 means success
    if ($res == 0) {
        //Making the response error false
        $response["error"] = false;
        //Adding a success message
        $response["message"] = "Room updated successfully";
        //Displaying response
        echoResponse(201, $response);
    //If the result returned is 1 means failure
    } else if ($res == 1) {
        $response["error"] = true;
        $response["message"] = "Room already updated";
        echoResponse(200, $response);
    //If the result returned is 2 means user already exist
    } else if ($res == 2) {
        $response["error"] = true;
        $response["message"] = "Sorry,  room  is in active state kindly inactive the room then update the room details";
        echoResponse(200, $response);
    }
});

$app->get('/startGame', function (Request $req,  Response $res, $args = [])  {
 
    //Creating a response array
    $response = array();
    if(!verifyRequiredParams(array('room_id'),$req)){
        return;
    }
    //reading post parameters
    $room_id = $req->getParam('room_id');
    //Creating a DbOperation object
    $db = new DbOperation();
    //Calling the method createStudent to add student to the database
    $res = $db->startGame($room_id);
    //If the result returned is 0 means success
    if ($res == 0) {
        //Making the response error false
        $response["error"] = false;
        //Adding a success message
        $response["message"] = "Game started successfully";
        //Displaying response
        echoResponse(201, $response);
    //If the result returned is 1 means failure
    } else if ($res == 1) {
        $response["error"] = true;
        $response["message"] = "Game already started";
        echoResponse(200, $response);
    //If the result returned is 2 means user already exist
    } else if ($res == 2) {
        $response["error"] = true;
        $response["message"] = "Sorry,  game is already started";
        echoResponse(200, $response);
    }
});

//game_id + room_id + user_id
//find winner room details
$app->get('/findWinner', function (Request $req,  Response $res, $args = [])  {
 
    //Creating a response array
    $response = array();
    if(!verifyRequiredParams(array('room_id','game_id'),$req)){
        return;
    }
    //reading post parameters
    $room_id = $req->getParam('room_id');
    $game_id = $req->getParam('game_id');
    //Creating a DbOperation object
    $db = new DbOperation();
    //Calling the method createStudent to add student to the database
    $res = $db->findWinner($room_id,$game_id);
    //If the result returned is 0 means success
    if ($res == 0) {
        //Making the response error false
        $response["error"] = false;
        //Adding a success message
        $response["message"] = "Found The Winner";
        $response["data"] =  $res;
        //Displaying response
        echoResponse(201, $response);
    //If the result returned is 1 means failure
    } else if ($res == 1) {
        $response["error"] = true;
        $response["message"] = "Some Thing Wrong Happened";
        echoResponse(200, $response);
    //If the result returned is 2 means user already exist
    } else if ($res == 2) {
        $response["error"] = true;
        $response["message"] = "Sorry,  game is already started";
        echoResponse(200, $response);
    }
});

//helper api here start
//game_id + room_id + user_id
//find winner room details
$app->get('/roomList', function (Request $req,  Response $res, $args = [])  {
 
    //Creating a response array
    $response = array();
    
    
    //Creating a DbOperation object
    $db = new DbOperation();
    //Calling the method createStudent to add student to the database
    $res = $db->getRoomList();
    //If the result returned is 0 means success
    //if ($res == 0) {
        //Making the response error false
        $response["error"] = false;
        //Adding a success message
        $response["message"] = "Room List";
        $response["data"] =  $res;
        //Displaying response
        echoResponse(201, $response);
        //If the result returned is 1 means failure
    /*} else if ($res == 1) {
        $response["error"] = true;
        $response["message"] = "Some Thing Wrong Happened";
        echoResponse(200, $response);
        //If the result returned is 2 means user already exist
    } else if ($res == 2) {
        $response["error"] = true;
        $response["message"] = "Sorry,  some error";
        echoResponse(200, $response);
    }*/
});
//helper api end here
//Method to display response
function echoResponse($status_code, $response)
{
    //Getting app instance
    //echo $status_code;
    echo json_encode($response);
}

function verifyRequiredParams($required_fields,$req)
{
    //Assuming there is no error
    $error = false;

    //Error fields are blank
    $error_fields = "";

    //Looping through all the parameters
    foreach ($required_fields as $field) {
       // echo "ok ".isset($request_params[$field]);
        //if any requred parameter is missing
        if (strlen(trim($req->getParam($field))) <= 0) {
            //error is true
            $error = true;
            //Concatnating the missing parameters in error fields
            $error_fields .= $field . ', ';
        }
    }

    //if there is a parameter missing then error is true
    if ($error) {
        //Creating response array
        $response = array();

        //Getting app instance
        

        //Adding values to response array
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';

        //Displaying response with error code 400
        echoResponse(400, $response);

        //Stopping the app
        //$app->stop();
        return false;
    }
    return true;
}

$app->run();
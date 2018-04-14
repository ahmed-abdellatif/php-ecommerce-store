<?php
// check if value was posted
if($_POST){
 
    // include classes
    include_once '../config/database.php';
    include_once '../objects/user.php';
 
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
 
    // prepare user object
    $user = new User($db);
 
    // set user id to be deleted
    $user->id = $_POST['object_id'];
 
    // delete the user
    if($user->delete()){
        echo "Object was deleted.";
    }

    // if unable to delete the user
    else{
        echo "Unable to delete object.";
    }
}
?>
<?php // File lives in classes/update_user_info.php

class UpdateUserInfo {
  
  // Expects a connection object and a user id string/integer
  function __construct($connection, $user){
    $this->connection = $connection;
    $this->user = $user;
  }

  function updateAddress($new_address){
    $connection->query("UPDATE users SET address = {$new_address} WHERE id = {$user} LIMIT 1");
  }
  
  function updatePhone($new_phone){
    $connection->query("UPDATE users SET phone = {$new_phone} WHERE id = {$user} LIMIT 1");
  }
  
}

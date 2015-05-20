<?php  // File lives in services/update_user_address.php

include 'connection.php';
include '../classes/update_user_info.php';

// Connection object can be included, user id and new address can be sent through ajax

$service = new UpdateUserInfo($c, $u);
$address = $service->escape_string($_POST['address']);

$service->updateAddress($address);
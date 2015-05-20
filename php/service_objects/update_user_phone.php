<?php  // File lives in services/update_user_phone.php

include 'connection.php';
include '../classes/update_user_info.php';

// Again, Connection object can be included, user id and new phone can be sent through ajax

$service = new UpdateUserInfo($c, $u);
$phone = $service->escape_string($_POST['phone']);

$service->updatePhone($phone);
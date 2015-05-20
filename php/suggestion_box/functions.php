<?php
/* Suggestion box functions  */

$id = $_POST["id"];
$admin_response = !empty($_POST["admin_response"]) ? $_POST["admin_response"] : "";
$status = !empty($_POST["status"]) ? $_POST["status"] : "";
$type = $_POST["type"];

/* Connect and check the connection */
$mysqli = new mysqli("host6.camerondunlap.com", "camerond_Cheryl", "piercecl79", "camerond_dashboard");
if ($mysqli->connect_errno){
  echo "Error: Failed to connect to MySQL: ( { $mysqli->connect_errno } ) { $mysqli->connect_error }";
}

/*  Type of function sent from Ajax call */

switch ($type) {
  case "vote":
    $query = "UPDATE `suggestions_testing` SET `votes` = votes + 1 WHERE `id` = '$id'";
    $result = $mysqli->query($query);
    $returnquery = "SELECT * FROM `suggestions_testing` WHERE `id` = $id LIMIT 1";
    $result2 = $mysqli->query($returnquery);
    while ($row2 = $result2->fetch_object()) {
      echo $row2->votes;
    }
    break;

  case "admin response":
    $query = "UPDATE `suggestions_testing` SET `admin_response` = '$admin_response' WHERE `id` = '$id'";
    $result = $mysqli->query($query);

    /* Not necessary to return any data in this case */
    //
    // $returnquery = "SELECT * FROM `suggestions_testing` WHERE `id` = $id LIMIT 1";
    // $result2 = $mysqli->query($returnquery);
    // while ($row2 = $result2->fetch_object()) {
    //  echo $row2->admin_response;
    // }
    break;

  case "status":
    $query = "UPDATE `suggestions_testing` SET `status` = '$status' WHERE `id` = '$id'";
    $result = $mysqli->query($query);

    /* Not necessary to return any data in this case */
    //
    // $returnquery = "SELECT * FROM `suggestions_testing` WHERE `id` = $id LIMIT 1";
    // $result2 = $mysqli->query($returnquery);
    // while ($row2 = $result2->fetch_object()) {
    //  echo $row2->status;
    // }
    break;
}

/* Close the connection */
$mysqli->close();

?>
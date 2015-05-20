<?php 

$species = $_POST["species"];

mysqli_query("INSERT INTO `database` (`species`) VALUES ('$species') "); // assume we have already set up a connection

?>
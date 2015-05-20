<?php
/* ------------------------ */
//
// Suggestion box AJAX functions 1
// This page is only used by suggestion-box[][user][admin].php
//
/* ------------------------ */

/* Set variables */
$id = $_POST["id"];
$userid = !empty($_POST["userid"]) ? $_POST["userid"] : 0;
$admin_response = !empty($_POST["admin_response"]) ? $_POST["admin_response"] : false;
$status = !empty($_POST["status"]) ? $_POST["status"] : false;
$type = $_POST["type"];
$comment = !empty($_POST["comment"]) ? $_POST["comment"] : "";
$email = !empty($_POST["email"]) ? $_POST["email"] : "none given";
$commentname = !empty($_POST["commentname"]) ? $_POST ["commentname"] : "none given";
$comment_id = !empty($_POST["comment_id"]) ? $_POST["comment_id"]: "" ;
$suggestion = !empty($_POST["suggestion"]) ? $_POST["suggestion"]: "" ;
$suggestiontitle = !empty($_POST["suggestiontitle"]) ? $_POST["suggestiontitle"]: "" ;
$kind = !empty($_POST["kind"]) ? $_POST["kind"]: "" ;

/* Connect and check the connection */
$mysqli = new mysqli("localhost", "ifliprea_cheryl", "piercecl79", "ifliprea_iFlip");
if ($mysqli->connect_errno){
	echo "Error: Failed to connect to MySQL: ( { $mysqli->connect_errno } ) { $mysqli->connect_error }";
}

/*  Type of function sent from Ajax call */

switch ($type) {
	case "upvote":
		/* Checks if the user has already voted */
		$check = "SELECT * FROM `suggestion_box` WHERE `suggestion_id` = '$id' AND (`suggestion_upvotes_check` LIKE '%,$userid,%' OR `suggestion_downvotes_check` LIKE '%,$userid,%' OR `suggestion_undecidedvotes_check` LIKE '%,$userid,%')";
		$checkres = $mysqli->query($check);
		$checkrow = $checkres->fetch_object();
		if ($checkrow->suggestion_id == $id) { /* If this gets executed, they already voted */
			echo "already";
		} else {
			echo "go";
		}
		break;

	case "downvote":
		/* Checks if the user has already voted */
		$check = "SELECT * FROM `suggestion_box` WHERE `suggestion_id` = '$id' AND (`suggestion_upvotes_check` LIKE '%,$userid,%' OR `suggestion_downvotes_check` LIKE '%,$userid,%' OR `suggestion_undecidedvotes_check` LIKE '%,$userid,%')";
		$checkres = $mysqli->query($check);
		$checkrow = $checkres->fetch_object();
		if ($checkrow->suggestion_id == $id) { /* If this gets executed, they already voted */
			echo "already";
		} else {
			echo "go";
		}
		break;

	case "undecidedvote":
		/* Checks if the user has already voted */
		$check = "SELECT * FROM `suggestion_box` WHERE `suggestion_id` = '$id' AND (`suggestion_upvotes_check` LIKE '%,$userid,%' OR `suggestion_downvotes_check` LIKE '%,$userid,%' OR `suggestion_undecidedvotes_check` LIKE '%,$userid,%')";
		$checkres = $mysqli->query($check);
		$checkrow = $checkres->fetch_object();
		if ($checkrow->suggestion_id == $id) { /* If this gets executed, they already voted */
			echo "already";
		} else {
			echo "go";
		}
		break;

	case "status":
		$query = "UPDATE `suggestion_box` SET `suggestion_status` = '$status' WHERE `suggestion_id` = '$id'";
		$mysqli->query($query);

		/* Not necessary to return any data in this case */
		break;

	case "updatesuggestion":
		$query = "UPDATE `suggestion_box` SET `suggestion_text` = '$suggestion' WHERE `suggestion_id` = '$id'";
		$mysqli->query($query);

		/* Not necessary to return any data in this case */
		break;

	case "updatesuggestiontitle":
		$query = "UPDATE `suggestion_box` SET `suggestion_title` = '$suggestiontitle' WHERE `suggestion_id` = '$id'";
		$mysqli->query($query);

		/* Not necessary to return any data in this case */
		break;

	case "suggestionallow":
		$query = "UPDATE `suggestion_box` SET `suggestion_admin_allow` = '$status' WHERE `suggestion_id` = '$id'";
		$mysqli->query($query);

		/* Not necessary to return any data in this case */
		break;

	case "newcomment":
		$query = "INSERT INTO `suggestion_box_comments` (`comment_suggestion_id`, `comment_text`, `comment_user_name`, `comment_user_email`, `comment_suggestion_type`) VALUES ('$id', '$comment', '$commentname', '$email', '$kind' )";
		$mysqli->query($query);

		include ("../script-email.php");
		$to 		= "info@camerondirect.com";
		$from 		= "noreply@realestatewealthnetwork.com";
		$from_name 	= "$commentname";

		$subject 	= "iFlip Suggestion Box Entry ($commentname)";
		$message 	= "$commentname ($email) submitted a comment on suggestion $id via the iFlip Suggestion Box.<br><br><i>$comment</i>";

		send_email($to, $from, $from_name, $subject, $message);


		/* Not necessary to return any data in this case */
		break;

	case "updatecomment":
		$query = "UPDATE `suggestion_box_comments` SET `comment_text` = '$comment' where `comment_id` = '$id'";
		$mysqli->query($query);

		/* Not necessary to return any data in this case */
		break;

	case "updatecommentstatus":
		$query = "UPDATE `suggestion_box_comments` SET `comment_admin_allow` = '$status' WHERE `comment_id` = '$id'";
		$mysqli->query($query);

		/* Not necessary to return any data in this case */
		break;


	default:
		echo "Nothing sent.";
}

/* Close the connection */
$mysqli->close();
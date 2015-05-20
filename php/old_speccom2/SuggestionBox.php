<?php
/* Suggestion box script! Enjoy! */

include("../includes/session_set.php");

?>

<!DOCTYPE html>
<html>
<head>
  <title>Suggestion Box</title>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.4.33/jquery.colorbox-min.js"></script>
  <link type="text/css" rel="stylesheet" href="//normalize-css.googlecode.com/svn/trunk/normalize.css" />
  <link type="text/css" rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" />
  <link type="text/css" rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.4.33/example1/colorbox.min.css" />
  <link type="text/css" rel="stylesheet" href="suggestionbox.css">
</head>
<body>
<div class="key-buttons">
  <div class="key">
    <button class="votebutton btn btn-success"><span class="glyphicon glyphicon-thumbs-up"></span> Yes</button>
    <button class="votebutton btn btn-warning"><span class="glyphicon glyphicon-question-sign"></span> Maybe</button>
    <button class="votebutton btn btn-danger"><span class="glyphicon glyphicon-thumbs-down"></span> No</button>
  </div>
  <div class="panels" style="<?php if ($_SESSION['ifre_user_id'] != 32 ) { echo "display: none;"; } ?>">
    <button class="btn btn-normal" id="showsuggestions">Show Suggestions</button>
    <button class="btn btn-info" id="showdevelopment">Show Features In Development</button>
  </div>
</div>
<?php
$mysqli = new mysqli("localhost", "ifliprea_cheryl", "piercecl79", "ifliprea_iFlip");

if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$query = "SELECT * FROM `suggestion_box` WHERE `suggestion_admin_allow` = '1' AND `suggestion_status` = 2 ORDER BY `suggestion_id` DESC";
$query2 = "SELECT * FROM `suggestion_box_comments` WHERE `comment_admin_allow` = '1'";

$result = $mysqli->query($query);
$result2 = $mysqli->query($query2);
$num_rows = $result->num_rows;

?>
<div id="suggestionsdisplay">
  <table class="table suggestion-box table-condensed" summary="Table of suggestions for iFlip">
    <thead>
      <tr class="columntitles">
        <th>Number<?php /* Not visible, necessary for proper voting selection */ ?></th>
        <th>Would You Use This Feature?</th>
        <th class="left">Suggestion</th>
      </tr>
    </thead>
    <tbody>
  <?php

  if ($result) {
    while ($row = $result->fetch_assoc()) {
    ?>
    <tr class="entry" id="<?php echo $row["suggestion_id"] ?>">
      <td class="votecontainer" id="votecontainer-<?php echo $row["suggestion_id"] ?>">
        <table class="upvotetable">
          <tr>
            <td class="number">
              <?php echo $row["suggestion_id"] ?>
            </td>
            <?php /* Votes cell */ ?>
            <td class="upvote" id="upvote-<?php echo $row["suggestion_id"] ?>" >
              <input type="hidden" name="id" value="<?php echo $row["suggestion_id"] ?>">
              <p class="upcount">
                <?php echo $row["suggestion_upvotes"] ?>
              </p>
              <?php
                $uvc = $row["suggestion_upvotes_check"];
                $found = strpos($uvc, ",$_SESSION[ifre_user_id],");
              ?>
              <button class="votebutton btn btn-success <?php if ($found) {echo 'disabled';} ?>" id="upvotebutton-<?php echo $row["suggestion_id"] ?> ">
                <span class="glyphicon glyphicon-thumbs-up"></span>
              </button>
            </td>
          </tr>
        </table>
        <table class="undecidedvotetable">
          <tr>
            <td class="number">
              <?php echo $row["suggestion_id"] ?>
            </td>
            <?php /* Votes cell */ ?>
            <td class="undecidedvote" id="undecidedvote-<?php echo $row["suggestion_id"] ?>" >
              <input type="hidden" name="id" value="<?php echo $row["suggestion_id"] ?>">
              <p class="undecidedcount">
                <?php echo $row["suggestion_undecidedvotes"] ?>
              </p>
              <?php
                $udvc = $row["suggestion_undecidedvotes_check"];
                $found = strpos($udvc, ",$_SESSION[ifre_user_id],");
              ?>
              <button class="votebutton btn btn-warning <?php if ($found) {echo 'disabled';} ?>" id="undecidedvotebutton-<?php echo $row["suggestion_id"] ?>">
                <span class="glyphicon glyphicon-question-sign"></span>
              </button>
            </td>
          </tr>
        </table>
        <table class="downvotetable">
          <tr>
            <td class="number">
              <?php echo $row["suggestion_id"] ?>
            </td>
            <?php /* Votes cell */ ?>
            <td class="downvote" id="downvote-<?php echo $row["suggestion_id"] ?>" >
              <input type="hidden" name="id" value="<?php echo $row["suggestion_id"] ?>">
              <p class="downcount">
                <?php echo $row["suggestion_downvotes"] ?>
              </p>
              <?php
                $dvc = $row["suggestion_downvotes_check"];
                $found = strpos($dvc, ",$_SESSION[ifre_user_id],");
              ?>
              <button class="votebutton btn btn-danger <?php if ($found) {echo 'disabled';} ?>" id="downvotebutton-<?php echo $row["suggestion_id"] ?>">
                <span class="glyphicon glyphicon-thumbs-down"></span>
              </button>
            </td>
          </tr>
        </table>
      </td>
      <td class="suggestion">
        <h3><?php echo $row["suggestion_title"] ?><span class="suggestiontitle btn btn-default" id="suggestiontitle<?php echo $row["suggestion_id"] ?>">More Info</span></h3>
        <div class="condensed-s">
          <p>
            <span class="suggestiontext" id="suggestioncondensed<?php echo $row["suggestion_id"] ?>">"<?php echo substr($row["suggestion_text"], 0, 120); ?>...</span>
            <span class="suggestiontext-full" id="suggestionfull<?php echo $row["suggestion_id"] ?>">"<?php echo $row["suggestion_text"]; ?>"</span>
          </p>
          <?php /* Comments input and subtable */ ?>
          <table class="comments condensed-c" id="commentscondensed<?php echo $row["suggestion_id"] ?>">
            <?php $count = 0;
            while ($row2 = $result2->fetch_assoc()) {
                if ($row["suggestion_id"] !== $row2["comment_suggestion_id"]) {
                  continue;
                  } else {
                if ($count == 0) { ?>
              <thead>
                <th>ID<?php /* Not visible, check CSS file */ ?></th>
                <th>Name</th>
                <th>Comment</th>
              </thead>
              <?php $count++ ;
              } ?>
              <tbody>
                <tr id="comment<?php echo $row2["comment_id"]; ?>">
                  <td class="comment-user-name">
                    <?php echo $row2["comment_user_name"]; ?>
                  </td>
                  <td class="comment-text">
                    <?php echo $row2["comment_text"]; ?>
                  </td>
                </tr>
              </tbody>
              <?php } } $result2->data_seek(0); ?>
          </table>
          <?php if ($count == 0) { ?>
            <script type="text/javascript">
            $(document).ready(function(){
              $("#commentsdisplay<?php echo $row[suggestion_id] ?>").css("display", "none");
              $("#commentscondensed<?php echo $row[suggestion_id] ?>").css("display", "none");
            });
            </script>
          <?php } ?>
        </div>
      </td>
    </tr>
      <?php }
      } ?>
    </tbody>
  </table>
</div>
<div id="developmentdisplay">
</div>
<?php require ("functions2.php") ?>
</body>
</html>
<?php

  /* Free the result set */
  $result->close();

/* Close the connection */
$mysqli->close();

?>
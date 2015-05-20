<!DOCTYPE html>
<html>
<head>
  <title>Suggestion Box</title>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <link rel="stylesheet" src="//normalize-css.googlecode.com/svn/trunk/normalize.css" />
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="suggestionbox.css">
</head>
<body>

<?php

/* Used to control visibility of features, will probably remove this */
$admin = 0;

/* Nifty new MySQLi interface */
$mysqli = new mysqli("host6.camerondunlap.com", "camerond_Cheryl", "piercecl79", "camerond_dashboard");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

?>

<table class="table suggestion-box table-condensed">
  <caption><h1>Table of suggestions for iFlip</h1></caption>
  <thead>
    <tr>
      <th>Number<?php /* Not visible, necessary for proper voting selection */ ?></th>
      <th>Votes</th>
      <th>Suggestion</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
<?php

if ($admin) {
  $query = "SELECT * FROM `suggestions_testing` ORDER BY `id` DESC";
} else {
  $query = "SELECT * FROM `suggestions_testing` WHERE `admin_allow` = '1' ORDER BY `id` DESC";
}

$result = $mysqli->query($query);
$num_rows = $result->num_rows;


if ($result) {

    /* Fetch results */
    while ($row = $result->fetch_object()) {
      /*
        List of columns:

        id
        email
        name
        suggestion
        submitted
        votes
        status
        admin_allow
        admin_response

      */
      /* Each row is its own <tr> */
      switch ($row->status) {
        case 1:
          $status = "Under Consideration";
          break;

        case 2:
          $status = "Voting";
          break;

        case 3:
          $status = "Pending Development";
          break;

        case 4:
          $status = "In Progress";
          break;

        case 5:
          $status = "Complete";
          break;
      } ?>
    <tr class="entry" id="<?= $row->id ?>">
      <td class="number">
        <?= $row->id ?>
      </td>
      <td class="vote">
        <form action="post">
        <input type="hidden" name="id" value="<?= $row->id ?>">
        <div class="votebutton btn btn-primary">
          <p class="count">
            <?= $row->votes ?>
          </p>
          <p class="votetext">
            Vote
          </p>
        </div>
        </form>
      </td>
      <td class="suggestion">
        <p>
          <?= $row->suggestion ?>
        </p>
      </td>
      <td class="status">
        <? if ($admin) { ?>
          <select id="status-<?= $row->id ?>">
            <option <?php if ($row->status == "1") { echo "selected"; } ?> value="1">Under Consideration</option>
            <option <?php if ($row->status == "2") { echo "selected"; } ?> value="2">Voting</option>
            <option <?php if ($row->status == "3") { echo "selected"; } ?> value="3">Pending Development</option>
            <option <?php if ($row->status == "4") { echo "selected"; } ?> value="4">In Progress</option>
            <option <?php if ($row->status == "5") { echo "selected"; } ?> value="5">Complete</option>
          </select>
        <? ;} else { echo $status; } ?>
      </td>
    </tr>
    <tr class="response" id="admin-<?= $row->id ?>">
      <td>
        Admin Response
      </td>
      <td>
        <? if ($admin) { ?>
          <input type="text" class="admin_response" name="admin_response" value="<?= $row->admin_response ?>">
        <? ;} else { echo $row->admin_response; }; ?>
      </td>
      <td>
      <? if ($admin) { ?>
        <input type="hidden" name="admin_response_id" value="<?= $row->id ?>">
        <input type="button" class="admin_response_submit" value="Submit">
        <? } ?>
      </td>
    </tr>
    <? } ?>
    <?php } ?>
  </tbody>
</table>
<script type="text/javascript">
  $(document).ready(function(){

    /* Vote checking array */
    votecheck = [];
    for (var i = 0; i < <?= $num_rows ?>; i++) {
      votecheck.push([i + 1, false]);
    };

    /* Voting script */
    $(".vote").click(function(){
      var suggestionid = $(this).parents("tr").prop("id");

      /* Checks if a user has already voted */
      if (votecheck[suggestionid - 1][1]) {
        alert("Already voted!");
      } else {

          /* Changes check value in array to true */
          votecheck[suggestionid - 1][1] = true;
          $.ajax ({
            url: "functions.php",
            type: "POST",
            data: {
              type: "vote",
              id: suggestionid
            },
            success: function(data){

              /* Updates display and disables button */
              var result = $("#" + suggestionid);
              result.find("div[class='votebutton btn btn-primary']").attr("disabled", true);
              result.find("p[class='count']").html(data);
              result.find("p[class='votetext']").html("<span class='thanksvote'>Thanks for voting!<span>");
            }
        });
      };
    });

    /* Update admin response script */
    $(".admin_response_submit").click(function(){
      /* This is dirty and could probably be cleaned up */

      var sugg = $(this).parents("tr").prop("id");
      var suggestionid = sugg.replace("admin-","");
      var result = $("tr#admin-" + suggestionid);
      $.ajax ({
        url: "functions.php",
        type: "POST",
        data: {
          type: "admin response",
          id: suggestionid,
          admin_response: result.find("input[class='admin_response']").val()
        },
        success: function(data){
          alert("Response recorded!");
          /* Not necessary to return any data in this case */
          // result.find("input[class='admin_response']").val(data);
        }
      });
    });

    /* Status change script */
    $("select").change(function(){
      var stat = $(this).prop("id");
      var statusid = stat.replace("status-","");
      $.ajax ({
        url: "functions.php",
        type: "POST",
        data: {
          type: "status",
          id: statusid,
          status: $("#" + stat).val()
        },
        success: function(data){
          alert("Status changed!");
        }
      });
    });
  });
</script>
</body>
</html>

<?php

    /* Free the result set */
    $result->close();

/* Close the connection */
$mysqli->close();

?>
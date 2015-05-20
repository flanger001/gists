<!DOCTYPE html>
<html>
  <head>
    <title>SimpleBlog v0.001</title>
    <link type="text/css" rel="stylesheet" href="stylelogin.css"/>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
  </head>
  <body>
    <div class="masthead">
      <p>SimpleBlog v0.001</p>
    </div>
    <div class="divider"></div>
    <div class="menu">
    <ul>
      <li>Home</li>
      <li>Entries</li>
      <li>Post</li>
    </ul>
    </div>
    <div class="divider"></div>
    <div class="blogs">
    <?php
      /* connection */
      $mysqli = new mysqli("localhost", "test", "test", "blog");
      if ($mysqli->connect_errno){
      echo "Error: Failed to connect to database: { $mysqli->connect_error }";
      }

      function showPost($blogSubject,$blogBody,$blogDate){
        echo  "<div class='posts'>";
        echo  "<p>" . $blogSubject . "</p>";
        echo  "<div class='postDivider'></div>";
        echo  "<p class='blogBody'>" . $blogBody . "</p>";
        echo  "<p class='dateFooter'>" . $blogDate . "</p>";
        echo  "</div>";
      }

      $query = "SELECT * FROM blog";
      if (isset($_GET['postid'])){
        $postid = $_GET['postid'];
        $query .= " WHERE blog_id = '$postid'";
      } else {
        $query .= " ORDER BY blog_id DESC LIMIT 10";
      }

      $result =  $mysqli->query($query);
      while ($row = mysqli_fetch_array($result)){
        showPost($row['blog_subject'], $row['blog_text'], $row['blog_date']);
      }

      ?>

    </div>
  </body>
</html>
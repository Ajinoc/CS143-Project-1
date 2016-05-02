<!DOCTYPE html>
<html>
<head>
    <title>Movie Information</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <h3>Movie Information</h3>

    <hr>

    <?php

        $db_connection = mysql_connect("localhost", "cs143", "");

        if(!$db_connection) {
            $errmsg = mysql_error($db_connection);
            print "Connection failed: $errmsg <br />";
            exit(1);
        }

        mysql_select_db("CS143", $db_connection);

        $id = $_GET["id"];

        $query = "SELECT * FROM Movie WHERE Movie.id='$id'";
        $rs = mysql_query($query, $db_connection);
        $row = mysql_fetch_array($rs);

        print "<b>Title</b>: $row[1]<br/>
        <b>Year</b>: $row[2]<br/>
        <b>Rating</b>: $row[3]<br/>
        <b>Company</b>: $row[4]<br/>";

        $query = "SELECT * FROM MovieGenre WHERE MovieGenre.mid='$id'";
        $rs = mysql_query($query, $db_connection);

        $genre="";

        if ($row = mysql_fetch_row($rs)) {
            $genre = $row[1];
        }

        while ($row = mysql_fetch_row($rs)) {
            $genre = $genre.', '.$row[1];
        }

        print "<b>Genre</b>: ".$genre."<br/>";

        $query = "SELECT * FROM Sales WHERE Sales.mid='$id'";
        $rs = mysql_query($query, $db_connection);
        $row = mysql_fetch_array($rs);

        if ($row[1] != "") {
            $row[1] = "\$$row[1]";
        }

        print "<b>Tickets Sold</b>: $row[0]<br/>
               <b>Total Income</b>: $row[1]<br/>";

        $query = "SELECT * FROM MovieRating WHERE MovieRating.mid='$id'";
        $rs = mysql_query($query, $db_connection);
        $row = mysql_fetch_array($rs);

        print "<b>IMDb Rating</b>: $row[1]<br/>
               <b>Rotten Tomatoes Rating</b>: $row[2]<br/><hr/>";

        /* Grab actors in movie */
        $query = "SELECT * FROM MovieActor WHERE MovieActor.mid=$id";
        $rs = mysql_query($query, $db_connection);
        while($row = mysql_fetch_row($rs)) {
            $sub_query = "SELECT * FROM Actor WHERE Actor.id='$row[1]'";
            $sub_rs = mysql_query($sub_query, $db_connection);
            $sub_row = mysql_fetch_array($sub_rs);
            print 'Starring <a href="B1.php?id='.$sub_row[0].'" target="iframe">'.$sub_row[2]. ' '.$sub_row[1].'</a> as "'.$row[2].'"<br/>';
        }

        echo '<hr/>';



        mysql_close($db_connection);
    ?>
    
   <form action="<?php $_PHP_SELF ?>" method="GET">
        Search for Actor/Movie: <input type="text" name="query">
        <input type="submit" name="submit" value="Search"/>
    </form>

   <?php
    
    $query = $_GET["query"];

    if(isset($_GET["submit"]) && $query != "") {
        header("Location: S1.php?query=$query&submit=Search");
    }
        
     ?>


</body>
</html>

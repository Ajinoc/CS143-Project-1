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
        $row = mysql_fetch_row($rs);

        print "<b>Title</b>: $row[1]<br/>
        <b>Year</b>: $row[2]<br/>
        <b>Rating</b>: $row[3]<br/>
        <b>Company</b>: $row[4]<br/>";

        $query = "SELECT * FROM MovieDirector WHERE MovieDirector.mid='$id'";
        $rs = mysql_query($query, $db_connection);

        $directors="";

        if ($row = mysql_fetch_row($rs)) {
            $sub_query = "SELECT * FROM Director WHERE Director.id=$row[1]";
            $sub_rs = mysql_query($sub_query, $db_connection);
            $sub_row = mysql_fetch_row($sub_rs);
            $directors = $sub_row[2].' '.$sub_row[1].'('.$sub_row[3].')';
        }

        while ($row = mysql_fetch_row($rs)) {
            $sub_query = "SELECT * FROM Director WHERE Director.id=$row[1]";
            $sub_rs = mysql_query($sub_query, $db_connection);
            $sub_row = mysql_fetch_row($sub_rs);
            $directors = $directors.', '.$sub_row[2].' '.$sub_row[1].'('.$sub_row[3].')';
        }

        print "<b>Director</b>: ".$directors."<br/>";

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
        $row = mysql_fetch_row($rs);

        if ($row[1] != "") {
            $row[1] = "\$$row[1]";
        }

        print "<b>Tickets Sold</b>: $row[0]<br/>
               <b>Total Income</b>: $row[1]<br/>";

        $query = "SELECT * FROM MovieRating WHERE MovieRating.mid='$id'";
        $rs = mysql_query($query, $db_connection);
        $row = mysql_fetch_row($rs);

        print "<b>IMDb Rating</b>: $row[1]<br/>
               <b>Rotten Tomatoes Rating</b>: $row[2]<br/><hr/>";

        /* Grab actors in movie */
        $query = "SELECT * FROM MovieActor WHERE MovieActor.mid=$id";
        $rs = mysql_query($query, $db_connection);
        while($row = mysql_fetch_row($rs)) {
            $sub_query = "SELECT * FROM Actor WHERE Actor.id='$row[1]'";
            $sub_rs = mysql_query($sub_query, $db_connection);
            $sub_row = mysql_fetch_row($sub_rs);
            print 'Starring <a href="B1.php?id='.$sub_row[0].'" target="iframe">'.$sub_row[2]. ' '.$sub_row[1].'</a> as "'.$row[2].'".<br/>';
        }

        print '<hr/><h3>Movie Reviews</h3>';
        /* Grab average score */
        $query = "SELECT AVG(rating), COUNT(*) FROM Review GROUP BY mid HAVING mid=$id";
        $rs = mysql_query($query, $db_connection);
        $row = mysql_fetch_row($rs);

        print 'Average Score: ';
        if($row[1] > 0)
            print $row[0].'/5 (5.0 is a perfect score) out of '.$row[1].' review(s). ';
        else
            print '(Sorry, no reviews are available for this movie!) ';

        print '<a href="I3.php?id='.$id.'" target="iframe">
        Add your own review now!</a>
        <br/>All comments can be seen below (if any):<br/><br/>';

        /* Grab all comments for the movie */
        $query = "SELECT name, time, rating, comment FROM Review WHERE mid=$id";
        $rs = mysql_query($query, $db_connection);
        while($row = mysql_fetch_row($rs)) {
            print 'On <font color="#55487E">'
                .$row[1].'</font>, <font color="#763936">'
                .$row[0].'</font> gave this movie a score of 
                <font color="386E6E">'
                .$row[2].'/5</font> and left the review: <br/>'
                .$row[3].'<br/><br/>';
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

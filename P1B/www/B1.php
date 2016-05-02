<!DOCTYPE html>
<html>
<head>
    <title>Actor Information</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <h3>Actor Information</h3><hr/>
    <?php

        $db_connection = mysql_connect("localhost", "cs143", "");

        if(!$db_connection) {
            $errmsg = mysql_error($db_connection);
            print "Connection failed: $errmsg <br />";
            exit(1);
        }

        mysql_select_db("CS143", $db_connection);

        /* Grab ID from URL */
        $aid = $_GET["id"];

        /* Grab actor information */
        $query = "SELECT CONCAT(first, ' ', last) as name, sex, dob, dod FROM Actor WHERE id=$aid";
        $rs = mysql_query($query, $db_connection);
        $row = mysql_fetch_array($rs);

        /* Check for NULL dod */
        if(empty($row[3]) && !empty($aid))
            $row[3] = "Still Kickin'!";

        print "<b>Name</b>: $row[0]<br/>
        <b>Sex</b>: $row[1]<br/>
        <b>Date of Birth</b>: $row[2]<br/>
        <b>Date Of Death</b>: $row[3]<br/><hr/>";

        /* Grab movies actor was in */
        $query = "SELECT role, mid FROM MovieActor WHERE aid=$aid";
        $rs = mysql_query($query, $db_connection);
        while($row = mysql_fetch_row($rs)) {
            print 'Acted as "'.$row[0].'" in the movie "';
            $sub_query = "SELECT title FROM Movie WHERE id=$row[1]";
            $rs_s = mysql_query($sub_query, $db_connection);
            $title = mysql_fetch_array($rs_s);
            print '<a href="B2.php?id='.$row[1].'" target="iframe">';                    
            print $title[0].'</a>".<br/>';
        }

        mysql_close($db_connection);
    ?>
    <hr/>
    
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

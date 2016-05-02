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
            print '<b>Acted as</b> "'.$row[0].'" in the <b>movie</b> "';
            $sub_query = "SELECT title FROM Movie WHERE id=$row[1]";
            $rs_s = mysql_query($sub_query, $db_connection);
            $title = mysql_fetch_array($rs_s);
            print '<a href="B2.php?id='.$row[1].'" target="iframe">';                    
            print $title[0].'</a>".<br/>';
        }
    ?>
    <hr/>
    
    <form action="<?php $_PHP_SELF ?>" method="GET">
        Search for Actor/Movie: <input type="text" name="query">
        <input type="submit" name="submit" value="Search"/>
    </form>

    <?php
        
        $query = $_GET["query"];

        if(isset($_GET["submit"]) && $query != "") {
            $db_connection = mysql_connect("localhost", "cs143", "");

            if(!$db_connection) {
                    $errmsg = mysql_error($db_connection);
                    print "Connection failed: $errmsg <br />";
                    exit(1);
            }

            mysql_select_db("CS143", $db_connection);

            $values = explode(" ", $query);
            $numVals = count($values);

            // Perform actor search only for firstName, lastName
            if ($numVals <= 2) {
                if ($numVals == 1) {
                    // Single Name Query
                    $name = $values[0];
                    $query = "SELECT * FROM Actor WHERE Actor.first='$name' OR Actor.last='$name'";
                    $rows = mysql_query($query, $db_connection);
                } else {
                    // FirstLast Query
                    $first = $values[0];
                    $last = $values[1];
                    $query = "SELECT * FROM Actor WHERE Actor.first='$first' AND Actor.last='$last'";
                    $rows = mysql_query($query, $db_connection);
                }

                echo '<h4>---Actor Results---</h4>';

                while ($row = mysql_fetch_row($rows)) {
                    $id = $row[0];
                    $last = $row[1];
                    $first = $row[2];
                    $dob = $row[4];
                    echo '<a href="B1.php?id='.$id.'" target="iframe">';
                    echo $first, ' ', $last, ' (', $dob, ')';
                    echo '</a>';
                    echo '<br>';
                }
            }

            // Movie query
            echo '<h4>---Movie Results---</h4>';
            $string = $_GET["query"];
            $query = "SELECT * FROM Movie WHERE Movie.title LIKE '%{$string}%'";
            $rows = mysql_query($query, $db_connection);

            while ($row = mysql_fetch_row($rows)) {
                $id = $row[0];
                $title = $row[1];
                $year = $row[2];
                echo '<a href="B2.php?id='.$id.'" target="iframe">';
                echo $title, ' (', $year, ')';
                echo '</a>';
                echo '<br>';
            }

            mysql_close($db_connection);
        }

    ?>
    </body>
</html>

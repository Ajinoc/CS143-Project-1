<!DOCTYPE html>
<html>
<head>
    <title>Search for Actor/Movie</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <h3>Search for Actor/Movie</h3>

    <hr>
    
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
                    $query = "SELECT * FROM Actor WHERE Actor.first LIKE '%{$name}%' OR Actor.last LIKE '%{$name}%'";
                    $rows = mysql_query($query, $db_connection);
                } else {
                    // FirstLast Query
                    $first = $values[0];
                    $last = $values[1];
                    $query = "SELECT * FROM Actor WHERE Actor.first LIKE '%{$first}%' AND Actor.last LIKE '%{$last}%'";
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

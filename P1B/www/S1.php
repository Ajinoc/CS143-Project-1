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
                    $query = "SELECT * FROM Actor WHERE Actor.first='$name' OR Actor.last='$name'";
                    $rows = mysql_query($query, $db_connection);

                    echo '<h4>---Actor Results---</h4>';

                    while ($row = mysql_fetch_row($rows)) {
                        $last = $row[1];
                        $first = $row[2];
                        $dob = $row[4];
                        echo '<a href="B1'
                        echo $first, ' ', $last, ' (', $dob, ')';
                        echo '<br>';
                    }
                } else {
                    // FirstLast Query

                }
            }

            // Movie query
            echo '<h4>---Movie Results---</h4>';




            mysql_close($db_connection);
        }

    ?>


</body>
</html>

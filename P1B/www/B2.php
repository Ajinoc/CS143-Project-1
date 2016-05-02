<!DOCTYPE html>
<html>
<head>
    <title>Movie Information</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <h3>Movie Information</h3>

    <hr>
    
    <form action="<?php $_PHP_SELF ?>" method="GET">
        Search for Actor/Actress/Movie: <input type="text" name="query">
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

            $values = explode(" ", $query);
            $numVals = count($values);

            $seachWords = "";

            for ($i = 0; $i < $numVals; $i++) {
                
            }



            mysql_close($db_connection);
        }

    ?>


</body>
</html>

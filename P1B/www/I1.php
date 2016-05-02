<!DOCTYPE html>
	<head>
		<title>Add Actor/Director</title>
		<link rel="stylesheet" href="style.css" />
	</head>	
	<body>
		<h3>Add new actor/director: </h3>

		<form action="<?php $_PHP_SELF ?>" method="GET">
			
			Identity:	<input type="radio" name="identity" value="Actor"checked="true">Actor
						<input type="radio" name="identity" value="Director">Director<br/>
			<hr/>
			First Name:	<input type="text" name="first" maxlength="20"><br/>
			Last Name:	<input type="text" name="last" maxlength="20"><br/>
			Sex:		<input type="radio" name="sex" value="Male" checked="true">Male
						<input type="radio" name="sex" value="Female">Female
                        (if Director, sex doesn't matter)<br/>
						
			Date of Birth (yyyy-mm-dd):	<input type="text" name="dob"><br/>
			Date of Death (yyyy-mm-dd):	<input type="text" name="dod"> (If still alive, leave blank.)<br/><hr/>
			<input type="submit" name="submit" value="Add to the database!"/>
		</form>


        <?php

        	/* Gather info */
        	$fname = $_GET["first"];
        	$lname = $_GET["last"];
        	$sex = $_GET["sex"];
        	$dob = $_GET["dob"];
        	$dod = $_GET["dod"];
        	$identity = $_GET["identity"];


        	/* Check for empty fields */
        	if(isset($_GET['submit']) && ($fname == "" || $lname == ""))
        		print "Go back and check first or last name fields please. <br />";
        	if(isset($_GET['submit']) && $dob == "")
        		print "Go back and check date of birth field please. <br />";

        	/* Proceed to add to database */
        	if($fname != "" && $lname != "" && $dob != ""){
        		$db_connection = mysql_connect("localhost", "cs143", "");

	        	if(!$db_connection) {
    	        	$errmsg = mysql_error($db_connection);
        	    	print "Connection failed: $errmsg <br />";
            		exit(1);
        		}

        		mysql_select_db("CS143", $db_connection);

        		/* Grab max person ID */
    	    	$query = "SELECT MAX(id)+1 FROM MaxPersonID";
	            $rs = mysql_query($query, $db_connection);
        	    $pid = mysql_fetch_array($rs);

                /* Account for empty dod field */
                $dod = !empty($dod) ? "'$dod'" : "NULL";

                /* Generate query format */
            	if($identity == "Actor") {
            		$query_insert = "INSERT INTO Actor(id,first,last,sex,dob,dod) VALUES ('$pid[0]','$fname','$lname','$sex','$dob', $dod)";
        		}
        
        		if($identity == "Director") {
            		$query_insert = "INSERT INTO Director(id,first,last,dob,dod) VALUES ('$pid','$fname','$lname','$dob',$dod)";
        		}
        		$query_update = "UPDATE MaxPersonID SET id = $pid[0]";

        		/* Perform MySQL INSERT/UPDATE */
        		$ins_q = mysql_query($query_insert, $db_connection);
                if(!$ins_q){
                    $errmsg = mysql_error($db_connection);
                    print "Insert failed: $errmsg <br />";
            	}

            	if($ins_q){
                	$upd_q = mysql_query($query_update, $db_connection);
                    if(!$upd_q){
                        $errmsg = mysql_error($db_connection);
                        print "Update failed: $errmsg <br />";
                    }
           		}
            	if($ins_q && $upd_q){
                	print "Successfully added. <br />";
            	}
        	}   
        	mysql_close($db_connection);
        ?>
    </body>
</html>

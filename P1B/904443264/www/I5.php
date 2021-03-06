<!DOCTYPE html>
	<head>
		<title>Actor/Movie Relation</title>
		<link rel="stylesheet" href="style.css" />
	</head>	
	<body>
		<h3>Add a director to a movie: </h3><hr/>

		<?php

			$db_connection = mysql_connect("localhost", "cs143", "");

	        	if(!$db_connection) {
    	        	$errmsg = mysql_error($db_connection);
        	    	print "Connection failed: $errmsg <br />";
            		exit(1);
        		}

        		mysql_select_db("CS143", $db_connection);
        ?>

		<form action="<?php $_PHP_SELF ?>" method="GET">
			
		<?php
			/* Form queries to creat options for Movie and Director drop-down */
			$query_1 = "SELECT title, year FROM Movie ORDER BY title ASC";
			$rs_1 = mysql_query($query_1, $db_connection);
			$query_2 = "SELECT CONCAT(first, ' ', last) as name, first, last, dob FROM Director ORDER BY name ASC";
			$rs_2 = mysql_query($query_2, $db_connection);
		?>
			Movie: <select name="movie">
				<?php
					while ($row = mysql_fetch_array($rs_1)) {
   						echo '<option value="'.$row[0].'|'.$row[1].'">'.$row[0].' ('.$row[1].')</option>';
					}
				?>
					</select><br/>
			Director: <select name="director">
				<?php
					while ($row = mysql_fetch_array($rs_2)) {
   						echo '<option value="'.$row[1].'|'.$row[2].'|'.$row[3].'">'.$row[0].' ('.$row[3].')</option>';
					}
				?>
					</select><br/><hr/>

			<input type="submit" name="submit" value="Add to the database!"/>
		</form>	

		<?php

        	/* Gather info */
        	list($m_title,$m_year) = explode("|",$_GET['movie']);
        	list($d_first,$d_last,$d_dob) = explode("|",$_GET['director']);

        	/* Proceed to add to database */
        	if(isset($_GET['submit'])){
        		/* Grab movie ID */
    	    	$query = "SELECT id FROM Movie WHERE title='$m_title' AND year=$m_year";
	            $rs = mysql_query($query, $db_connection);
        	    $mid = mysql_fetch_array($rs);

                 /* Grab director ID */
				$query = "SELECT id FROM Director WHERE first='$d_first' AND last='$d_last' AND dob='$d_dob'";
	            $rs = mysql_query($query, $db_connection);
        	    $pid = mysql_fetch_array($rs);
                
                /* Generate query format for Movie INSERT*/
            	$query_insert = "INSERT INTO MovieDirector(mid, did) VALUES ('$mid[0]','$pid[0]')";

        		/* Perform MySQL INSERT */
        		$ins_q = mysql_query($query_insert, $db_connection); 
                if(!$ins_q){
                    $errmsg = mysql_error($db_connection);
                    print "Insert failed: $errmsg <br />";
                }
    			if($ins_q){
                	print "Successfully added. <br />";
            	}
            }
			mysql_close($db_connection);
        ?>	
	</body>
</html>

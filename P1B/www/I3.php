<!DOCTYPE html>
	<head>
		<title>Add a Comment</title>
		<link rel="stylesheet" href="style.css" />
	</head>	
	<body>
		<h3>Add a comment/review to a movie: </h3><hr/>

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
			/* Form queries to creat options for Movie drop-down */
			$id = $_GET["id"];
			if(!empty($id))
				$query_1 = "SELECT title, year FROM Movie WHERE id=$id";
			else
				$query_1 = "SELECT title, year FROM Movie ORDER BY title ASC";
			$rs_1 = mysql_query($query_1, $db_connection);
			
		?>
			Movie: <select name="movie">
				<?php
					while ($row = mysql_fetch_array($rs_1)) {
   						echo '<option value="'.$row[0].'|'.$row[1].'">'.$row[0].' ('.$row[1].')</option>';
					}
				?>
					</select><br/>
			Your Name (Reviewer): <input type="text" name="name" value="Sir Anonymous" maxlength="20"><br/>
				
			Rating: <select name="rating">
					<option value="5">5 - Excellent!!</option>
					<option value="4">4 - Great!</option>
					<option value="3">3 - Okay...</option>
					<option value="2">2 - Subpar.</option>
					<option value="1">1 - Atrocious! D:<</option>
					</select><br/><hr/>

			Comment: <br>
			<textarea class ="FormElement" name ="comment" id="query" style="width: 525px; height: 225px;"></textarea><hr/>

			<input type="submit" name="submit" value="Add to the database!"/>
		</form>	

		<?php

        	/* Gather info */
        	list($m_title,$m_year) = explode("|",$_GET['movie']);
        	$name = $_GET["name"];
        	$rating = $_GET["rating"];
        	$comment = $_GET["comment"];

        	/* Check for empty fields */
        	if(isset($_GET['submit']) && $comment == "")
        		print "Go back and check comment field please. <br />";

        	/* Proceed to add to database */
        	if($comment != ""){
        		/* Grab movie ID */
    	    	$query = "SELECT id FROM Movie WHERE title='$m_title' AND year=$m_year";
	            $rs = mysql_query($query, $db_connection);
        	    $mid = mysql_fetch_array($rs);

        	    /* Grab current timestamp */
        	    $query = "SELECT NOW()";
        	    $rs = mysql_query($query, $db_connection);
        	    $curr_t = mysql_fetch_array($rs);
                
                /* Generate query format for Movie INSERT*/
            	$query_insert = "INSERT INTO Review(name, time, mid, rating, comment) VALUES ('$name','$curr_t[0]','$mid[0]','$rating', '$comment')";

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

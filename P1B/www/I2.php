<!DOCTYPE html>
	<head>
		<title>Add New Movie</title>
		<link rel="stylesheet" href="style.css" />
	</head>	
	<body>
		<h3>Add new movie: </h3>

		<form action="<?php $_PHP_SELF ?>" method="GET">

			Title: <input type="text" name="title" maxlength="20"><br/>
			Company: <input type="text" name="company" maxlength="50"><br/>
			Year: <input type="number" name="year" min="0" max="9999"><br/>	
			MPAA Rating: <select name="mpaarating">
					<option value="G">G</option>
					<option value="NC-17">NC-17</option>
					<option value="PG">PG</option>
					<option value="PG-13">PG-13</option>
					<option value="R">R</option>
					<option value="surrendere">surrendere</option>
					</select><br/><hr/>

			Genre: <br/><table>
				<tr>
					<td><input type="checkbox" name="genre[]" value="Action">Action</input></td>
					<td><input type="checkbox" name="genre[]" value="Adult">Adult</input></td>
					<td><input type="checkbox" name="genre[]" value="Adventure">Adventure</input></td>
					<td><input type="checkbox" name="genre[]" value="Animation">Animation</input></td>
					<td><input type="checkbox" name="genre[]" value="Comedy">Comedy</input></td>
				</tr><tr>
					<td><input type="checkbox" name="genre[]" value="Crime">Crime</input></td>
					<td><input type="checkbox" name="genre[]" value="Documentary">Documentary</input></td>
					<td><input type="checkbox" name="genre[]" value="Drama">Drama</input></td>
					<td><input type="checkbox" name="genre[]" value="Family">Family</input></td>
					<td><input type="checkbox" name="genre[]" value="Fantasy">Fantasy</input></td>
				</tr><tr>
					<td><input type="checkbox" name="genre[]" value="Horror">Horror</input></td>
					<td><input type="checkbox" name="genre[]" value="Musical">Musical</input></td>
					<td><input type="checkbox" name="genre[]" value="Mystery">Mystery</input></td>
					<td><input type="checkbox" name="genre[]" value="Romance">Romance</input></td>
					<td><input type="checkbox" name="genre[]" value="Sci-Fi">Sci-Fi</input></td>
				</tr><tr>
					<td><input type="checkbox" name="genre[]" value="Short">Short</input></td>
					<td><input type="checkbox" name="genre[]" value="Thriller">Thriller</input></td>
					<td><input type="checkbox" name="genre[]" value="War">War</input></td>
					<td><input type="checkbox" name="genre[]" value="Western">Western</input></td>
				</tr></table><br/><hr/>
			
			<input type="submit" name="submit" value="Add to the database!"/>

		<?php

        	/* Gather info */
        	$title = $_GET["title"];
        	$company = $_GET["company"];
        	$year = $_GET["year"];
        	$rating = $_GET["mpaarating"];
        	$genre = $_GET['genre'];

        	/* Check for empty fields */
        	if(isset($_GET['submit']) && $title == "")
        		print "Go back and check title field please. <br />";
        	if(isset($_GET['submit']) && $company == "")
        		print "Go back and check company field please. <br />";
        	if(isset($_GET['submit']) && $year == "")
        		print "Go back and check year field please. <br />";
        	if(isset($_GET['submit']) && $genre[0] == "")
        		print "Go back and check at least one genre field please. <br />";

        	/* Proceed to add to database */
        	if($title != "" && $company != "" && $year != "" && $genre[0] != ""){
        		$db_connection = mysql_connect("localhost", "cs143", "");

	        	if(!$db_connection) {
    	        	$errmsg = mysql_error($db_connection);
        	    	print "Connection failed: $errmsg <br />";
            		exit(1);
        		}

        		mysql_select_db("CS143", $db_connection);

        		/* Grab max movie ID */
    	    	$query = "SELECT MAX(id)+1 FROM MaxMovieID";
	            $rs = mysql_query($query, $db_connection);
        	    $mid = mysql_fetch_array($rs);

                /* Generate query format for Movie INSERT*/
            	$query_insert = "INSERT INTO Movie(id,title,year,rating,company) VALUES ('$mid[0]','$title','$year','$rating','$company')";
        
        		$query_update = "UPDATE MaxMovieID SET id = $mid[0]";

        		/* Perform MySQL INSERT/UPDATE */
        		$ins_q = mysql_query($query_insert, $db_connection); 
                if(!$ins_q){
                    $errmsg = mysql_error($db_connection);
                    print "Insert failed: $errmsg <br />";
                }
            	if($ins_q <> false){
                	$upd_q = mysql_query($query_update, $db_connection);
                    if(!$upd_q){
                        $errmsg = mysql_error($db_connection);
                        print "Update failed: $errmsg <br />";
                    }
           		}

            	/* Generate query for MovieGenre INSERT */
            	for($i = 0; $i < count($genre); $i++)
    			{
        			$query_insert= "INSERT INTO MovieGenre(mid, genre) VALUES ('$pid[0]','".$genre[$i]."')";
        			mysql_query($query_insert, $db_connection); 
                    if(!$ins_q){
                        $errmsg = mysql_error($db_connection);
                        print "Insert failed (but will continue adding other genres): $errmsg <br />";
                    }
    			}

    			if($ins_q && $upd_q){
                	print "Successfully added. <br />";
            	}
        	}   
        	mysql_close($db_connection);
        ?>

		</form>
				
	</body>
</html>

<!DOCTYPE html>
<html>
<head>
	<title>
		CS143 S16
	</title>

	<style>
		table tr:nth-child(even) {
    		background-color: #e2ecf3;
    		color: #193a52;
		}
		table tr:nth-child(odd) {
    		background-color: #ffffff;
    		color: #193a52;
		}
    	table th {
    		background-color: #ffffff;
    		color: black;
		}
	</style>
</head>
<body>

	<?php
		$query = $_GET["query"];
    	if( $query ) {
      		$readout = "Here is your query: ". $query. "<br />";
   		}
	?>

	<form action = "<?php $_PHP_SELF ?>" method = "GET">
		<header><h2>Project 1A Movie Database</h2></header>
        <p>Type an SQL query in the following box:</p>
        Example: 
        <font face="courier new" size="2">SELECT * FROM Actor WHERE id=10;</font><br>

        <textarea class = "FormElement" name = "query" id = "query" style = "width: 400px; height: 100px;"><?php echo $var= isset($_GET['query'])?$_GET['query']: ''; ?></textarea><br>
        <input type = "submit" value = "Submit"/><br>

        <font size="2"><p>Note: tables and fields are case sensitive. Be careful when typing in your queries!</p></font>
    </form>

    
    <?php
    	$db_connection = mysql_connect("localhost", "cs143", "");

    	if(!$db_connection) {
    		$errmsg = mysql_error($db_connection);
    		print "Connection failed: $errmsg <br />";
    		exit(1);
		}

		mysql_select_db("CS143", $db_connection);

    	if( !empty($query) ) {
    		$rs = mysql_query($query, $db_connection);
    		echo "<h3>Results from MySQL: </h3>";

    		print "<table border='1'><tr>";
    		$field_num = mysql_num_fields($rs);
    		for($i = 0; $i < $field_num; $i++) {
				$field_name = mysql_fetch_field($rs, $i);
				print "<th>$field_name->name</th>";
			}
			print "</tr>";
    		
    		while($row = mysql_fetch_row($rs)) {
    			echo '<tr>';
    			foreach($row as $field) {
    				if( empty($field) )
    					$field="N/A";
        			echo '<td>' . htmlspecialchars($field) . '</td>';
    			}
    			echo '</tr>';
			}
			print "</table>";
    	}

    	mysql_close($db_connection);
	?>
    

</body>
</html>

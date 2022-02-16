<?php 
include 'connect.php'
?>
<?php
      
	if (isset($_POST['submit'])) {
	  if (count(array_filter($_POST))!=count($_POST)) {
	    echo "Fill in!";
	  } else {
            $title = $_POST["title"];
         
        $query = "INSERT into posttrial (title) VALUES(?)";

        if($statement = mysqli_prepare($conn, $query))
        {
            mysqli_stmt_bind_param( $statement, 's', $title);
            mysqli_stmt_store_result($statement);
            //bind parameters to question marks
            
            if(mysqli_stmt_execute($statement)) {
                echo "Query executed";
            }
            else
            {
                echo "Error executing query";
                die(mysqli_error($conn));
            }
                echo"<br><br>--------------<br><br>";
            }
            else{
                echo "Prepare error";
                die(mysqli_error($conn));
            }
  }
}

	 
?>
    <div>
    <form method="post">
    <input type="text" title="title" name="title">
    <input type="submit" name="submit" value="Submit">
    </form>
    </div>
</body>
</html>

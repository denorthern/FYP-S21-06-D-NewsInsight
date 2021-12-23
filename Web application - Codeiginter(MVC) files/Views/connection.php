<?php
    $servername='localhost';
    $username='db_user';
    $password='1234';
    $dbname = "db_newsinsight";
    $conn=mysqli_connect($servername,$username,$password,"$dbname");
      if(!$conn){
          die('Could not Connect MySql Server:' .mysql_error());
        }
		else{
			echo "asdsd";
			
		}
?>

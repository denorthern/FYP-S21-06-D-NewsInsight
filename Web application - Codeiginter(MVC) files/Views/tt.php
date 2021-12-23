<?php
require ('config.php');
$return = '';
if(isset($_POST["query"]))
{
	$search = mysqli_real_escape_string($conn, $_POST["query"]);
	$query = "SELECT * FROM sources
	WHERE name LIKE '%".$search."%' 
	OR code LIKE '%".$search."%' 
	";}
else
{
	$query = "SELECT * FROM sources";
}
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0)
{
	$return .='
	<div class="table-responsive">
	<table class="table table bordered">
	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>code</th>
	</tr>';
	while($row1 = mysqli_fetch_array($result))
	{
		$return .= '
		<tr>
		<td>'.$row1["id"].'</td>
		<td>'.$row1["name"].'</td>
		<td>'.$row1["code"].'</td>
		</tr>';
	}
	echo $return;
	}
else
{
	echo 'No results containing all your search terms were found.';
}
?>
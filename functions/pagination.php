
<?php
// include("includes/database.php");
$query = "SELECT * FROM posts";
$result = mysqli_query($con,$query);

$total_records = mysqli_num_rows($result);
$total_pages = ceil($total_records / $per_page);

echo "<center>
	<div id='pagination'>
	<a href='Home.php?page=1'> First Page </a>
	";

for($i=1;$i<$total_pages;$i++)
{
	echo "<a href='Home.php?page=$i'> $i </a>";
}	

echo "<a href='	Home.php?page=$total_pages'> Last Page </a> </center> </div>";
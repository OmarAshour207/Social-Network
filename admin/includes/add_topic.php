<?php
	include("includes/database.php");
?>
	<form action="" method="post" id="f" enctype="multipart/form-data">
		<h2 style="padding:5px;"> Add Topics </h2>
		<textarea cols="70" rows="4" name="content" placeholder="Enter New Topic" ></textarea><br>
		<input type="submit" name="add" value="Add topic">
	</form>

<?php
	if(isset($_POST['add']))
	{
		$content 	= $_POST['content'];	
		if(!empty($content))
		{
			$add = "INSERT INTO `topics` (`topic_title`) VALUES ('$content')";
			$run = mysqli_query($con,$add);

			if($run)
			{
				echo "<script> alert('Added Successfully') </script>";
				echo "<script> window.open('index.php?view_topics','_self') </script>";
			}	
		}
		else
		{
			echo "<script> alert('This Field is required!') </script>";
		}
	}
?>


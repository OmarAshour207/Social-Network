<?php

		$get_id = $_GET['post_id'];
		$get_comments = "SELECT * FROM comment WHERE post_id='$get_id' ORDER BY 1 DESC";
		$run_comments = mysqli_query($con,$get_comments);

		while($row = mysqli_fetch_array($run_comments))
		{
			$com = $row['comment_content'];
			$com_name = $row['comment_author'];
			$date = $row['comment_date'];

			echo "<div id='comments'>
			<h3> $com_name </h3> Said on $date 
			<p> $com </p>
			</div>
			";

		}

		// echo "<script> window.open('single.php?post_id=$get_id','_self') </script>";
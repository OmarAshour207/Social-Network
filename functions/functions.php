<?php

$con = mysqli_connect("localhost","root","","social_network") or die("Connecction Failed!");

function getTopics()
{
	global $con;
	$get_topics = "SELECT * FROM topics";
	$run_topics = mysqli_query($con,$get_topics);

	while($row = mysqli_fetch_array($run_topics))
	{
		$topic_id = $row['topic_id'];
		$topic_title = $row['topic_title'];
		echo "<option value='$topic_id'> $topic_title </option>";
	}
}

function InsertPosts()
{
	global $con;
	global $user_id;	
	if(isset($_POST['post']))
	{
		$title = addslashes($_POST['title']);
		$content_post = addslashes($_POST['content']);
		$topic = $_POST['topic'];

		if($content ='')
		{
			echo "<h2> Please add post content </h2>";
		}
		else
		{
			$insert = " INSERT INTO posts (user_id, topic_id, post_title, post_content, post_date) VALUES ('$user_id','$topic','$title','$content_post',NOW())";
			$run = mysqli_query($con,$insert);

			if($run)
			{
				echo "<h3> Posted to timeline, Looks great </h3>";
				$update = "UPDATE users SET posts = 'YES' WHERE user_id = '$user_id'";
				$run_update = mysqli_query($con,$update);	
			}
		}
	}
}

function get_posts()
{
	global $con;
	$per_page = 5;

	if(isset($_GET['page']))
	{
		$page = $_GET['page'];
	}else
	{
		$page = 1;
	}

	$start_from = ($page-1) * $per_page;
	$get_posts = "SELECT * FROM posts ORDER BY 1 DESC LIMIT $start_from , $per_page";
	$run_posts = mysqli_query($con,$get_posts);

	while($row_posts = mysqli_fetch_array($run_posts))
	{
		$post_id = $row_posts['post_id'];
		$user_id = $row_posts['user_id'];
		$post_title = $row_posts['post_title'];
		$post_content = $row_posts['post_content'];
		$post_date = $row_posts['post_date'];

		$user = "SELECT * FROM users WHERE user_id='$user_id' AND posts='YES'";
		$run_user = mysqli_query($con,$user);
		$row_user = mysqli_fetch_array($run_user);
		$user_name = $row_user['user_name'];
		$user_image = $row_user['user_image'];


		echo "<div id='posts'>
		<p> <img src = 'user/user_images/$user_image' width='50px' height='50px'> </p>
		<h3> <a href='user_profile.php?u_id=$user_id'> $user_name </a> </h3>
		<h3> $post_title </h3>
		<p> $post_date </p>
		<p> $post_content </p>
		<a href = 'single.php?post_id=$post_id' style = 'text-decoration:none;'> <button> See Replies or send replay </buuton> </a>
		</div> <br>
		";

	}
	include("functions/pagination.php");
}

function single_post()
{
	global $con;
	if(isset($_GET['post_id']))
	{
		$get_id = $_GET['post_id'];
		$get_posts = "SELECT * FROM posts WHERE post_id='$get_id'";
		$run_posts = mysqli_query($con,$get_posts);
		$row_posts = mysqli_fetch_array($run_posts);
		
		$post_id = $row_posts['post_id'];
		$user_id = $row_posts['user_id'];
		$post_title = $row_posts['post_title'];
		$content = $row_posts['post_content'];
		$post_date = $row_posts['post_date'];

		$user = "SELECT * FROM users WHERE user_id='$user_id' AND posts='YES'";

		$run_user = mysqli_query($con,$user);
		$row_user = mysqli_fetch_array($run_user);
		$user_name = $row_user['user_name'];
		$user_image = $row_user['user_image'];

		// Refresh The Page 
		$user_com = $_SESSION['user_email'];
		$get_com = "SELECT * FROM users WHERE user_email='$user_com'";
		$run_com = mysqli_query($con,$get_com);
		$row_com = mysqli_fetch_array($run_com);
		$user_com_id = $row_com['user_id'];
		$user_com_name = $row_com['user_name'];


		echo "<div id='posts'>
		<p> <img src = 'user/user_images/$user_image' width='50px' height='50px'> </p>
		<h3> <a href='user_profile.php?u_id=$user_id'> $user_name </a> </h3>
		<h3> $post_title </h3>
		<p> $post_date </p>
		<p> $content </p>
		</div>
		";
		include("comments.php");
		echo "<form action='' method='post' id='reply'>
			<textarea cols='50' row='5' name='comment' placeholder='Write Your Comment'> </textarea><br>
			<input type='submit' name='reply' value='Comment'/>
		</form>
		";

		if(isset($_POST['reply']))
		{
			$comment = $_POST['comment'];

			$insert = "INSERT INTO comment (post_id,user_id,comment_content,comment_author,comment_date) VALUES ('$post_id','$user_com_id','$comment','$user_com_name',NOW())";
			$run = mysqli_query($con,$insert);
			echo "<h2> Your Reply was added </h2>";
		}
	}
}


function get_cats()
{
	global $con;
	$per_page = 5;

	if(isset($_GET['page']))
	{
		$page = $_GET['page'];
	}else
	{
		$page = 1;
	}

	$start_from = ($page-1) * $per_page;

	if(isset($_GET['topic']))
	{
		$topic_id = $_GET['topic'];
	}
	$get_posts = "SELECT * FROM posts WHERE topic_id='$topic_id' ORDER BY 1 DESC LIMIT $start_from , $per_page";
	$run_posts = mysqli_query($con,$get_posts);

	while($row_posts = mysqli_fetch_array($run_posts))
	{
		$post_id = $row_posts['post_id'];
		$user_id = $row_posts['user_id'];
		$post_title = $row_posts['post_title'];
		$post_content = $row_posts['post_content'];
		$post_date = $row_posts['post_date'];

		$user = "SELECT * FROM users WHERE user_id='$user_id' AND posts='YES'";
		$run_user = mysqli_query($con,$user);
		$row_user = mysqli_fetch_array($run_user);
		$user_name = $row_user['user_name'];
		$user_image = $row_user['user_image'];


		echo "<div id='posts'>
		<p> <img src = 'user/user_images/$user_image' width='50px' height='50px'> </p>
		<h3> <a href='user_profile.php?u_id=$user_id'> $user_name </a> </h3>
		<h3> $post_title </h3>
		<p> $post_date </p>
		<p> $post_content </p>
		<a href = 'single.php?post_id=$post_id' style = 'text-decoration:none;'> <button> See Replies or send replay </buuton> </a>
		</div> <br>
		";

	}
	include("functions/pagination.php");
}


function get_results()
{
	global $con;

	if(isset($_GET['search']))
	{
		$search_term = $_GET['user_query'];
	}
	$get_posts = "SELECT * FROM posts WHERE post_title LIKE '%$search_term%' OR post_content LIKE '%$search_term%' ORDER BY 1 DESC LIMIT 5 ";
	$run_posts = mysqli_query($con,$get_posts);

	$count_result = mysqli_num_rows($run_posts);
	if($count_result < 1 )
	{
		echo "<h3 style='background: black; padding: 10px; color: white; '> Try Search another value </h3>";
		exit();
	}
	while($row_posts = mysqli_fetch_array($run_posts))
	{
		$post_id = $row_posts['post_id'];
		$user_id = $row_posts['user_id'];
		$post_title = $row_posts['post_title'];
		$post_content = $row_posts['post_content'];
		$post_date = $row_posts['post_date'];

		$user = "SELECT * FROM users WHERE user_id='$user_id' AND posts='YES'";
		$run_user = mysqli_query($con,$user);
		$row_user = mysqli_fetch_array($run_user);
		$user_name = $row_user['user_name'];
		$user_image = $row_user['user_image'];


		echo "<div id='posts'>
		<p> <img src = 'user/user_images/$user_image' width='50px' height='50px'> </p>
		<h3> <a href='user_profile.php?u_id=$user_id'> $user_name </a> </h3>
		<h3> $post_title </h3>
		<p> $post_date </p>
		<p> $post_content </p>
		<a href = 'single.php?post_id=$post_id' style = 'text-decoration:none;'> <button> See Replies or send replay </buuton> </a>
		</div> <br>
		";

	}
}


function user_posts()
{
	global $con;
	

	if(isset($_GET['u_id']))
	{
		$u_id = $_GET['u_id'];
	}
	$get_posts = "SELECT * FROM posts WHERE user_id='$u_id' ORDER BY 1 DESC LIMIT 5";
	$run_posts = mysqli_query($con,$get_posts);

	while($row_posts = mysqli_fetch_array($run_posts))
	{
		$post_id = $row_posts['post_id'];
		$user_id = $row_posts['user_id'];
		$post_title = $row_posts['post_title'];
		$post_content = $row_posts['post_content'];
		$post_date = $row_posts['post_date'];

		$user = "SELECT * FROM users WHERE user_id='$user_id' AND posts='YES'";
		$run_user = mysqli_query($con,$user);
		$row_user = mysqli_fetch_array($run_user);
		$user_name = $row_user['user_name'];
		$user_image = $row_user['user_image'];


		echo "<div id='posts'>
		<p> <img src = 'user/user_images/$user_image' width='50px' height='50px'> </p>
		<h3> <a href='user_profile.php?u_id=$user_id'> $user_name </a> </h3>
		<h3> $post_title </h3>
		<p> $post_date </p>
		<p> $post_content </p>
		<a href = 'single.php?post_id=$post_id' style = 'text-decoration:none;'> <button> See Replies or send replay </button> </a>
		<a href = 'single.php?post_id=$post_id' style = 'text-decoration:none;'> <button> View </button> </a>
		<a href = 'functions/edit_post.php?post_id=$post_id' style = 'text-decoration:none;'> <button> Edit </button> </a>
		<a href = 'functions/delete_post.php?post_id=$post_id' style = 'text-decoration:none;'> <button> Delete </button> </a>
		</div> <br>
		";
		include("functions/delete_post.php");
	}
}

function update_post()
{
	global $con;
	if(isset($_POST['update_post']))
	{
		$new_title = $_POST['title'];
		$new_con = $_POST['content'];
		$new_topic = $_POST['topic'];

		$new_post = "UPDATE posts SET post_title='$new_title' , post_content='$new_con' , topic_id='$topic' WHERE post_id='$get_id' ";
		$run_update = mysqli_query($con,$new_post);
		
		if($run_update)
		{
			echo "<script> alert('Post has been updated') </script>";
		    echo "<script> window.open('../my_posts.php','_self') </script>";
		}
	}
}

function user_profile()
{
	
	if(isset($_GET['u_id']))
	{
		global $con;
		$user_id = $_GET['u_id'];


		$select = "SELECT * FROM users WHERE user_id='$user_id' ";
		$run = mysqli_query($con,$select);
		$row = mysqli_fetch_array($run);

		$id = $row['user_id'];
		$image = $row['user_image'];
		$name = $row['user_name'];
		$gender = $row['user_gender'];
		$last_login = $row['last_login'];
		$register_date = $row['register_date'];
		$birthday = $row['user_bitrhday'];

		if($gender == 'Male')
		{
			$msg = "Send him a Message ";
		}
		else
		{
			$msg = "Send her a Message ";
		}


		echo "<div id='user_profile'>
		<img src = 'user/user_images/$image' width='150px' height='150px'> <br>

		<p> <strong> Name: </strong> $name </p> <br>
		<p> <strong> Gender: </strong> $gender </p> <br>
		<p> <strong> Last Login:  </strong> $last_login </p> <br>
		<p> <strong> Birthday:  </strong> $birthday </p> <br>
		<p> <strong> Member Since:  </strong> $register_date </p> <br>

		<a href = 'messages.php?u_id=$id'> <button> $msg </button> </a> <br>
		
		";
	}	
	new_members();

	echo "</div>";
}

function new_members()
{
	global $con;
	if(isset($_GET['u_id']))
	{
		$get_members = "SELECT * FROM users LIMIT 0,20";
		$run_members = mysqli_query($con,$get_members);

		echo "<br> <h2> New Members On This Site: </h2> <br>";
		while($row = mysqli_fetch_array($run_members))
		{
			$user_id = $row['user_id'];
			$user_name = $row['user_name'];
			$user_image = $row['user_image'];
			echo "
			<a href='user_profile.php?u_id=$user_id'>
			<img src='user/user_images/$user_image' width='50px' height='50px'
			title='$user_name' style='float:left;'/>
			</a>
			";
		}
	}
}

?>
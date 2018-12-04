<?php

include("db_connect.php"); 

$id = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM comments")) + 1;
$article_id = $_POST["article_id"];
$name = mysqli_real_escape_string($conn, $_POST["leName"]);
$email = mysqli_real_escape_string($conn, $_POST["leEmail"]);
$website = mysqli_real_escape_string($conn, $_POST["leWebsite"]);
$comment = mysqli_real_escape_string($conn, $_POST["comment"]);
$datetime = date("Y-m-d h:i:sa");

if(article_id != 0) {
	$sql = "INSERT INTO `comments` ( `myIndex` , `article_id` , `name` , `email` , `website` , `comment` , `datetime` , `isApproved` , `deleted`)
		VALUES ( '$id', '$article_id', '$name', '$email', '$website', '$comment', '$datetime', '0', '0')";

	if (!mysqli_query($conn, $sql))
	{
	 	die('Error: ' . mysql_error());
	}
}
header("Refresh:3; url=http://www.jakeschweihs.com/article.php?i=" . $article_id);

?>
<html>

<head>
<title>Jake Schweihs - Technical Artist</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

<?php include("nav.php"); ?>

<div id="contentFrame">
	<div id="contentTop"></div>
	<div id="contentMid">
		<div id="innerContentNews">	
		<h1>Thank You</h1>
		<br>
		<p id="reelDesc"><a href="http://www.jakeschweihs.com/article.php?i=<?php echo $article_id;?>">Click here</a> if you don't automatically return.</p>
		<br>
		</div>
	</div>
	<div id="contentBot"> </div>

	
</div>

<?php include("footer.php"); ?>

</body>

</html>

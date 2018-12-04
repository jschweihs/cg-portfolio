<!DOCTYPE html>

<html lang="en-US">

<head>

<?php 

ini_set('magic_quotes_gpc', 'off');

include("db_connect.php"); 
$sql = "SELECT * FROM articles ORDER BY myIndex DESC";
$result = mysqli_query($conn, $sql);
?>

<title>Jake Schweihs - Blog</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Jake Schweihs' 3d rigging and modeling portfolio" />
<meta name="keywords" content="rigging, modeling, maya, technical artist, 3d art, pixel art" />
<meta name="robots" content="all" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">

<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

<?php include("nav.php"); ?>

<div id="contentFrame">
	<div id="contentTop"></div>
	<div id="contentMid">
		<div id="innerContentNews">
		<br>
		<ul>
			<?php if (mysqli_num_rows($result) > 0) { 
				while($row = mysqli_fetch_assoc($result)) { 
					$articleDate = date_create($row['date']);	?>
					<li>
						<h1><a href="/<?php echo $row['urlTitle']; ?>"><?php echo $row['articleTitle']; ?></a></h1>
						<h2><?php echo date_format($articleDate, 'F jS, Y'); ?></h2>
						<div id="newsBlock">
							<p class="previewP">"<?php echo $row['articlePreview']; ?>..."</p>
						</div>
					</li>
				<?php }
			} ?>
		</ul>
		</div>
		<br>
	</div>
	<div id="contentBot"> </div>
</div>

<?php include("footer.php"); ?>

</body>

</html>

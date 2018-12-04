
<!DOCTYPE html>

<html lang="en-US">

<head>

<?php 
ini_set('magic_quotes_gpc', 'off');

include("db_connect.php"); 

$urlTitle = mysqli_real_escape_string($conn, $_GET['url']);
$urlSql = "SELECT * FROM articles WHERE urlTitle='$urlTitle'";

$isReplying = $_POST['isReply'];
$leReplyIndex = $_POST['replyIndex'];

$sql = "SELECT * FROM articles";
$result = mysqli_query($conn, $sql);
$rowCount = mysqli_num_rows($result);

$result = mysqli_query($conn, $urlSql);
$row = mysqli_fetch_assoc($result);

$articleDate = date_create($row['date']);
?>

<title>Jake Schweihs - Technical Artist - <?php echo $row['articleTitle']; ?></title>
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

					<li>
						<h1><?php echo $row['articleTitle']; ?></h1>
						<h2><?php echo date_format($articleDate, 'F jS, Y'); ?></h2>
						<div id="newsBlock">
							<?php echo $row['articleBody']; ?>
						</div>
					</li>
			</ul>

			<div id="articleButtons">
				<ul>
					<?php
					$leIndex = $row['myIndex'];
					if($leIndex > 1) {
						$lastIndex = $leIndex - 1;
						$lastSql = "SELECT * FROM articles WHERE myIndex=$lastIndex";
						$lastResult = mysqli_query($conn, $lastSql);
						$lastRow = mysqli_fetch_assoc($lastResult); ?>
					<li><a href="/<?php echo $lastRow['urlTitle']; ?>">&lt;&lt; Prev</a></li>
					<?php } else { ?>
					<li>&lt;&lt; Prev</li>
					<?php } ?>

					<li><a href="/blog.php">Back</a></li>
				
					<?php if($leIndex < $rowCount) {
						$nextIndex = $leIndex + 1;
						$nextSql = "SELECT * FROM articles WHERE myIndex=$nextIndex";
						$nextResult = mysqli_query($conn, $nextSql);
						$nextRow = mysqli_fetch_assoc($nextResult); ?>
					<li><a href="/<?php echo $nextRow['urlTitle']; ?>">Next &gt;&gt;</a></li>
					<?php } else { ?>
					<li>Next &gt;&gt;</li>
					<?php } ?>

				</ul>
			</div>
			<br>
			<?php if($row['commentsEnabled'] == 1){?>
			<div id="comments">

				<h2>Comments</h2>
				<br>
				<?php if($isReplying == 0) {
 
				$currIndex = 0; 
				?>

				<form id="submit" action="submitComment.php" method="post">
				<input type="text" name="leName" value="Name">
				<input type="text" name="leEmail" value="eMail">
				<input type="text" name="leWebsite" value="Website">
				<input type="hidden" name="article_id" value="<?php echo $leIndex; ?>">
				<br> 
				<textarea rows="6" cols="74" name="comment" form="submit"></textarea>	
				<br>
				<input class="button" type="submit" value="Submit">
				</form>
				<br> <?php } ?>

				<?php 
				$commSql = "SELECT * FROM comments WHERE article_id='$leIndex'";
				$commResult = mysqli_query($conn, $commSql);
				while($commRow = mysqli_fetch_assoc($commResult)) { 
				if($commRow['isApproved'] == 1) {
					$currIndex++;
					$date = date_create($commRow['datetime']); ?>
						<p><?php echo $commRow['comment']; ?></p>
						<div id="commentMenu">
							<span class="commentInfo"><a href="<?php echo $commRow['website']; ?>"><?php echo $commRow['name']; ?></a> on <?php echo date_format($date, 'M jS, Y'); ?></span>
							<form method="post" action="#submit">
								<input type="hidden" name="isReply" value="1">
								<input type="hidden" name="replyIndex" value="<?php echo $currIndex; ?>">
								<input type="submit" value="Reply" class="replyButton">
							</form>
				
						</div>
					<?php } ?>
			
					<?php if($isReplying == 1 && $leReplyIndex == $currIndex) { ?>
						<form id="submit" action="submitReply.php" method="post">
							<input type="text" name="leName" value="Name">
							<input type="text" name="leEmail" value="eMail">
							<input type="text" name="leWebsite" value="Website">
							<input type="hidden" name="parent_id" value="<?php echo $commRow['myIndex']; ?>">
							<input type="hidden" name="article_id" value="<?php echo $leIndex; ?>">
							<br> 
							<textarea rows="6" cols="74" name="comment" form="submit"></textarea>	
							<br>
							<input class="button" type="submit" value="Submit">
						</form>
					<br>
					<?php } ?>

					

					<?php 
					$rplyIndex = $commRow['myIndex'];
					$rplySql = "SELECT * FROM replies WHERE parent_id='$rplyIndex'";
					$rplyResult = mysqli_query($conn, $rplySql);
					while($rplyRow = mysqli_fetch_assoc($rplyResult)) { 
						$currIndex++; 
						$date = date_create($rplyRow['datetime']);?>	

						<p class="commentReply"><?php echo $rplyRow['comment']; ?></p>
						<div class="replyButtonReply">
							<span class="commentInfoReply"><a href="<?php echo $rplyRow['website']; ?>"><?php echo $rplyRow['name']; ?></a> on <?php echo date_format($date, 'M jS, Y'); ?></span>
							<form method="post" action="#submit" >
								<input type="hidden" name="isReply" value="1">
								<input type="hidden" name="replyIndex" value="<?php echo $currIndex; ?>">
								<input type="submit" value="Reply" class="replyButtonReply">
							</form>
				
						</div>
						<br>
						<?php if($isReplying == 1 && $leReplyIndex == $currIndex) { ?>
							<form id="submit" action="submitReply.php" method="post">
								<input type="text" name="leName" value="Name">
								<input type="text" name="leEmail" value="eMail">
								<input type="text" name="leWebsite" value="Website">
								<input type="hidden" name="parent_id" value="<?php echo $commRow['myIndex']; ?>">
								<input type="hidden" name="article_id" value="<?php echo $leIndex; ?>">
								<br> 
								<textarea rows="6" cols="74" name="comment" form="submit">@<?php echo $rplyRow['name']; ?> </textarea>	
								<br>
								<input class="button" type="submit" value="Submit">
								</form>
						<br> <?php } ?>
					<?php } ?>
				<?php } ?>
				<br>
			</div> <?php } ?>
		</div>
	</div>
	<div id="contentBot"> </div>
</div>

<?php include("footer.php"); ?>

</body>

</html>

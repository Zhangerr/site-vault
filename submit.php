<?php
	//http://stackoverflow.com/questions/1975461/file-get-contents-with-https
	$mysqli = new mysqli('localhost', 'root', '');
	if ($mysqli->connect_error) {
	die('Connect Error (' . $mysqli->connect_errno . ') '
			. $mysqli->connect_error);
	}
	$title = $_POST['url'];
	try {
		$urlContents = file_get_contents($_POST['url']);
		preg_match("/<title>(.*)<\/title>/i", $urlContents, $matches);

		//print($matches[1] . "\n"); // "Example Web Page"
		
		if(isset($matches[1])) {
		$title=$matches[1];
		}
	} catch(Exception $e) {}
	$result = $mysqli->query("CREATE SCHEMA IF NOT EXISTS sitedb");
	echo $mysqli->error;
	
	$mysqli->select_db("sitedb");
	echo $mysqli->error;
	$result = $mysqli->query("
CREATE TABLE IF NOT EXISTS `sites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` text NOT NULL,
  `notes` text NOT NULL,
  `site_title` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
	
	$stmt = $mysqli->prepare("INSERT INTO `sites` (url, notes,site_title) values (?,?,?)");
	$stmt->bind_param("sss",$_POST['url'],$_POST['notes'],$title);
	$stmt->execute();
	echo '{"status":"success","title":"'.$title.'"}';
?>
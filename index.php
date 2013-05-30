<?php
	$mysqli = new mysqli('localhost', 'root', '');
	if ($mysqli->connect_error) {
	die('Connect Error (' . $mysqli->connect_errno . ') '
			. $mysqli->connect_error);
	}
	$mysqli->select_db("sitedb");
	?>
<!DOCTYPE html>
<html>
  <head>
    <title>Bootstrap 101 Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet" media="screen">
	<link href="css/font-awesome.css" rel="stylesheet" media="screen">
	<link rel="stylesheet/less" type="text/css" href="css/styles.less" />
	
	<script src="js/less-1.3.3.min.js" type="text/javascript"></script>

  </head>
  <body>
	<div class="container-fluid">
	<div class="row-fluid">
	<div class="span10 offset1">
		<h1>link vault</h1>
		<div class="alert alert-danger">
			<span class="label label-warning">todo</span> add delete/update note for entries, make urls unique
		</div>
		<div class="submit">
		<legend>Submit new url</legend>
	
		<form class="form-horizontal" action="submit.php" method="post">
		
		  <div class="control-group">
			<label class="control-label" for="inputEmail">link</label>
			<div class="controls">
			  <input type="text" id="inputLink" name="url" placeholder="url...">
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="inputPassword">additional notes</label>
			<div class="controls">
				<textarea name="notes" id="notes" cols="30" rows="5" placeholder="notes..."></textarea>
			  
			</div>
		  </div>
		  <div class="control-group">
			<div class="controls">
			  <a href="#" id="submit_b" type="submit" class="btn btn-primary">Submit</a>
			</div>
		  </div>
		</form>
		</div>
 <hr style="margin:0px;border-bottom-style:none;" />
 <a href="#" id="hide" class="btn" style="border-top-style:none;border-radius:0px;background-image:none;"><i class="icon-chevron-up"> </i></a>
	<table id="mytable" class="table table-hover" style="margin-top:50px;">
	<tr class="first">
		<th>Site name</th>
		<th>Notes</th>
		<th>Preview</th>
		<th>Options</th>
	</tr>
	<?php 
	$result=$mysqli->query("SELECT * FROM sites ORDER BY id DESC ");
	
	 while ($row=$result->fetch_assoc()) {
		$title = $row['site_title'];
		$notes = $row['notes'];
		$url= $row['url'];
		//sandbox prevents frame busting, apparently, http://stackoverflow.com/questions/369498/how-to-prevent-iframe-from-redirecting-top-level-window
		echo "<tr><td><a href='$url'>$title</a> - $url</td><td>$notes</td><td><iframe src='$url' width='900' sandbox='allow-forms allow-scripts'></iframe></td><td><a href='' class='btn btn-danger'>Delete</a></td></tr>";
	}
	?>
	</table>

	</div>
	</div>
	</div>		`		

    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
		<script type="text/javascript">
		function startsWith(haystack, needle) {
			return haystack.substring(0, needle.length) === needle;
		}
		$(document).ready(function() {
		$('#hide').click(function(e) {
			e.preventDefault();
			if($(".submit").is(":visible"))
			$(".submit").slideUp();
			else
			$(".submit").slideDown();
			$('#hide i').toggleClass('icon-chevron-down icon-chevron-up');
		});
		$('#submit_b').click(function(e){
			e.preventDefault();
			var url = $("#inputLink").val();
			
			if(!startsWith(url, "http://") && !startsWith(url,"https://")) {
				url = "http://"+url;
			}
			
			$.post("submit.php",{"url":url,"notes":$('#notes').val()},function(e){
				console.log(e);
				var obj = JSON.parse(e);
				$('#mytable .first').after("<tr style=\"display:none;\" class='new' ><td><a href='"+url+"'>" + obj.title + "</a> - " + url +"</td><td>" + $('#notes').val() +"</td><td><iframe src='"+url+"' width='900' sandbox='allow-forms allow-scripts'></iframe></td><td><a href='' class='btn btn-danger'>Delete</a></td></tr>");
				$('.new').fadeIn();
				$("#inputLink").val("");
				$("#notes").val("");
			})}
			);
			
		});
	</script>
  </body>
</html>


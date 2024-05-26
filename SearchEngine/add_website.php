<!DOCTYPE html>
<html>
	<head>
		<script src="add_website.css"></script>
		<title>Add websites</title>
		<link rel="stylesheet" href="add_website.css">
	</head>
	<body class="body">
		<div class="part">
		<font size="7"><p align="center">Add WebSite Mannualy</p></font>
		<form action="" method="POST" enctype="multipart/form-data">
		<table align="center" width="50%">
			<tr>
				<td>website title</td>
				<td><input type="text" name="websitetitle" id="text"></td>
			</tr>
			<tr>
				<td>website link</td>
				<td><input type="text" name="websitelink" id="text"></td>
			</tr>
			<tr>
				<td>website keywords</td>
				<td><input type="text" name="websitekeywords" id="text"></td>
			</tr>
			<tr>
				<td>website description</td>
				<td><textarea name="websitedesc" id="desc"></textarea></td>
			</tr>
		
			<tr>
				<td colspan="2" align="center"><input type="submit" name="addwebsite" id="addbt" value="Submit">
				&nbsp; &nbsp;
				<input type="reset" name="reset" id="resetbt" value="Reset">
				&nbsp; &nbsp;
				<a href='http://localhost/projects/search.html'><input type='Button' value='Home' id="backbt" /></a> </td>
			</tr>
		</table>
		</form>
</div></body>
</html>


<?php 
include("connection.php");
if($_POST['addwebsite']){
	$website_title=$_POST['websitetitle'];
	$website_link=$_POST['websitelink'];
	$website_keywords=$_POST['websitekeywords'];
	$website_desc=$_POST['websitedesc'];

	$filename=$_FILES["websitefile"]["name"];
	$tempname=$_FILES["websitefile"]["tmp_name"];

	$folder="Desktop/".$filename;
	move_uploaded_file($tempname,$folder);

	if($website_title!="" && $website_link!="" && $website_keywords!="" && $website_desc!="" ){
		$query="INSERT INTO add_website VALUES('$website_title','$website_link','$website_keywords','$website_desc','$folder')";
		$data=mysqli_query($conn,$query);
		if($data){
			echo "<script>alert('website inserted')</script>";
		}
		else{
			echo "<script>alert('faild')</script>";
		}

	} 
}
?>
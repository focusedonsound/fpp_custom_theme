<?php
if(isset($_POST['btn-upload']))
{
	$pic = rand(1000,100000)."-".$_FILES['pic']['name'];
    $pic_loc = $_FILES['pic']['tmp_name'];
	$folder="uploaded_files/";
	if(move_uploaded_file($pic_loc,$folder.$pic))
	{
		?><script>alert('successfully uploaded');</script><?php
	}
	else
	{
		?><script>alert('error while uploading file');</script><?php
	}
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Simpel File Uploading With PHP</title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="pic" />
<button type="submit" name="btn-upload">upload</button>
</form>
</body>
</html>
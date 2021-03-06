<?php
include_once("lib/user.php");

session_start();

$target_dir = "assets/img/";
$target_file = $target_dir . basename("profile" . $_POST["id"] . ".jpg");
$uploadOk = true;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
$user=$_SESSION['user'];

// Check if image file is a actual image or fake image
if (isset($_POST["submit"]))
{
	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	if ($check == false)
	{
		$_SESSION["PicErrors"] = "File is not an image.";
		$uploadOk = 0;
	}
}

// Check file size is less than a MB
if ($_FILES["fileToUpload"]["size"] > 1000000)
{
	$_SESSION["PicErrors"] = "Sorry, your image is too large.";
	$uploadOk = 0;
}
// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif"
)
{
	$_SESSION["PicErrors"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	$uploadOk = false;
}
// Check if $uploadOk is set to 0 by an error
if (!$uploadOk)
{
		header('Location: profileEdit.php?user=' . $user->username);

// if everything is ok, try to upload file
}
else
{
    // IF the user already has an image, we need to remove it
    if(file_exists($target_file))
    {
        unlink($target_file);
        echo 'File removed';
    }

	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
	{
		header('Location: profile.php?user=' . $_POST["id"]);
	}

}
?> 
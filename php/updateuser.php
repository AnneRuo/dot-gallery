<?php
include "../html/header.html";
?>

<?php
$target_dir = "../php/uploads/";
$uploadOk = 1;
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mimearray=array('jpg' => 'image/jpg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'jpeg' => 'image/jpeg',
);

$mimeindeksi=array_search($finfo->file($_FILES['fileToUpload']['tmp_name']), $mimearray, true);

if ($mimeindeksi==false){
	print "Check your image, file is not an image.<br>";
	$uploadOk = 0;
}

$filename=basename($_FILES["fileToUpload"]["name"]);
$imageFileNameWithoutExtension = strtolower(pathinfo($filename,PATHINFO_FILENAME));
$target_file=$target_dir.$imageFileNameWithoutExtension.".".$mimeindeksi;

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The new image has been uploaded.<br>";
    } else {
        echo "Sorry, there was an error uploading image";
    }
}

mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
try{
    $yhteys=mysqli_connect("db", "root", "password", "dotgalleria");
}
catch(Exception $e){
    header("Location:../html/yhteysvirhe.html");
    exit;
}

$id=isset($_POST["id"]) ? $_POST["id"] : "";
$firstname=isset($_POST["firstname"]) ? $_POST["firstname"] : "";
$lastname=isset($_POST["lastname"]) ? $_POST["lastname"] : "";
$image=$target_file;

if (empty($firstname) || empty($lastname) || empty($id)){
    header("Location:../html/tietuettaeiloydy.html");
    exit;
}

$sql="update users set firstname=?, lastname=?, image=? where id=?";

$stmt=mysqli_prepare($yhteys, $sql);
mysqli_stmt_bind_param($stmt, 'ssss', $firstname, $lastname, $image, $id);
mysqli_stmt_execute($stmt);
mysqli_close($yhteys);
print "Data updated.<br><br>";
print "<a href='admin.php'>Back to admin page.</a>";
exit;
?>

<?php
include "../html/footer.html";
?>
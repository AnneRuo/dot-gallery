<?php
include "../html/header.html";
?>

<?php
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

if (empty($firstname) || empty($lastname) || empty($id)){
    header("Location:../html/tietuettaeiloydy.html");
    exit;
}

$sql="update users set firstname=?, lastname=? where id=?";

$stmt=mysqli_prepare($yhteys, $sql);
mysqli_stmt_bind_param($stmt, 'sss', $firstname, $lastname, $id);
mysqli_stmt_execute($stmt);
mysqli_close($yhteys);
print "Data updated.<br><br>";
print "<a href='admin.php'>Back to admin page.</a>";
exit;

?>

<?php
include "../html/footer.html";
?>
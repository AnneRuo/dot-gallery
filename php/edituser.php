<?php
include "../html/header.html";
?>

<?php
$muokattava=isset($_GET["muokattava"]) ? $_GET["muokattava"] : "";

//Jos tietoa ei ole annettu, palataan listaukseen
if (empty($muokattava)){
    header("Location:./admin.php");
    exit;
}

mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
try{
    $yhteys=mysqli_connect("db", "root", "password", "dotgalleria");
}
catch(Exception $e){
    header("Location:../html/yhteysvirhe.html");
    exit;
}

$sql="select * from users where id=?";
$stmt=mysqli_prepare($yhteys, $sql);
mysqli_stmt_bind_param($stmt, 'i', $muokattava);
mysqli_stmt_execute($stmt);
$tulos=mysqli_stmt_get_result($stmt);
if (!$rivi=mysqli_fetch_object($tulos)){
    header("Location:../html/tietuettaeiloydy.html");
    exit;
}
?>

<form action='./updateuser.php' method='post'>
id:<input type='text' name='id' value='<?php print $rivi->id;?>' readonly><br>
Firstname:<input type='text' name='firstname' value='<?php print $rivi->firstname;?>'><br>
Lastname:<input type='text' name='lastname' value='<?php print $rivi->lastname;?>'><br>
<button type='submit' name='ok'>Update</button><br>
</form>


<?php
mysqli_close($yhteys);
?>

<?php
include "../html/footer.html";
?>


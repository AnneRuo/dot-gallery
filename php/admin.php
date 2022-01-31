<?php
session_start();
include "../html/header.html";
if (!isset($_SESSION["user"])){
    include "../html/loginform.html";
    include "../html/footer.html";
} else {
    print "<h2>Admin page</h2>";
    mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
    try{
        $yhteys=mysqli_connect("db", "root", "password", "dotgalleria");
    }
    catch(Exception $e){
        header("Location:../html/yhteysvirhe.html");
        exit;
    }
    $yhteys=mysqli_connect("db", "root", "password", "dotgalleria");
    $tulos=mysqli_query($yhteys, "select * from users");
    while ($rivi=mysqli_fetch_object($tulos)){
        print "<p>$rivi->image $rivi->firstname $rivi->lastname ".
            "<button><a href='./edituser.php?muokattava=$rivi->id'>Edit</a></button>".
            "<button><a href='./deleteuser.php?poistettava=$rivi->id'>Delete</a></p></button>";
    }
    mysqli_close($yhteys);
    "<a href='logout.php'>Log out</a>";
}
?>


<?php
include "../html/footer.html";
?>


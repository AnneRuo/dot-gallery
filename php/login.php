<?php
session_start();
$json=isset($_POST["user"]) ? $_POST["user"] : "";

if (!($user=tarkistaJson($json))){
    print "Täytä kaikki kentät";
    exit;
}

mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
try{
    $yhteys=mysqli_connect("db", "root", "password", "dotgalleria");
}
catch(Exception $e){
    print "Yhteysvirhe";
    exit;
}

//Tehdään sql-lause, jossa kysymysmerkeillä osoitetaan paikat joihin laitetaan muuttujien arvoja
$sql="select * from users where username=? and password=SHA2(?, 256)";
try{
    $stmt=mysqli_prepare($yhteys, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $user->username, $user->password);
    mysqli_stmt_execute($stmt);
    $tulos=mysqli_stmt_get_result($stmt);
    if ($rivi=mysqli_fetch_object($tulos)){
        $_SESSION["user"]="$rivi->username";
        print "ok";
        exit;
    }
    mysqli_close($yhteys);
    #print $json;
}
catch(Exception $e){
    print "Jokin virhe!";
}
?>


<?php
function tarkistaJson($json){
    if (empty($json)){
        return false;
    }
    $user=json_decode($json, false);
    if (empty($user->username) || empty($user->password)){
        return false;
    }
    return $user;
}
?>
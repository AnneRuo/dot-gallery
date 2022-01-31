<?php
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
$sql="insert into users (firstname, lastname, image, username, password) values(?, ?, ?, ?, SHA2(?, 256))";
try{
    $stmt=mysqli_prepare($yhteys, $sql);
    mysqli_stmt_bind_param($stmt, 'sssss', $user->firstname, $user->lastname, $user->image, $user->username, $user->password);
    mysqli_stmt_execute($stmt);
    mysqli_close($yhteys);
    print "Thank you for signing up.";
    "<a href='users.php'>To the user gallery</a>";
}
catch(Exception $e){
    print "Tunnus jo olemassa tai muu virhe!";
}
?>

<?php
function tarkistaJson($json){
    if (empty($json)){
        return false;
    }
    $user=json_decode($json, false);
    if (empty($user->username) || empty($user->password) || empty($user->firstname) || empty($user->lastname)){
        return false;
    }
    return $user;
}
?>

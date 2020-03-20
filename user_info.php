<?php
function isUserLogined()
{
    $db = new SQLite3('db.sqlite');
    $cookie_id = $_COOKIE["custom_session"];
    $is_logined = $db->querySingle("SELECT Session from Sessions where Session='".$cookie_id."'");
    if($is_logined)
    {
        $res = true; 
    }
    else
    {
        $res = false;
    }
    return $res;
}
if (!isUserLogined())
{
    header('Location: /login.php');
}

echo '<h1>User info:</h1>';
$db = new SQLite3('db.sqlite');
$username = $_GET['username'];
$info = $db->querySingle("SELECT ID from Users where Login='".$username."'");
echo $info;
?>


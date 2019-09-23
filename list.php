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
$username = $_COOKIE["username"];
if ($handle = opendir('uploads/'.$username.'/')) 
{
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
            $thelist .= '<li><a href=uploads/'.$username.'/'.$file.'>'.$file.'</a></li>';
} }
 closedir($handle);
}
?>
<h1>List of files:</h1>
<ul><?php echo $thelist; ?></ul>
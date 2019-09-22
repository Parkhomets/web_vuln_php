<?php
function getRandomString($length = 16) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';
    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    return $string;
} 

function isUserLogined($cookie_id) {
    $db = new SQLite3('db.sqlite');
    $is_logined = $db->querySingle("SELECT Session from Sessions where Session='".$cookie_id."'");
    if ($is_logined)
        return true;
    else
        return false;
}

function getUserID($username, $password) {
    $db = new SQLite3('db.sqlite');
    $id = $db->querySingle("SELECT ID from Users where Login='".$username."' and Pass='".$password."'");
    return $id;
    //OMG sqli here
}

if (!empty($_POST)) 
{
    
    $db = new SQLite3('db.sqlite');
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user_id = getUserID($username, $password);
    
    if($user_id)
    {
        $session_id = getRandomString();
        $db->exec("INSERT INTO Sessions(User_ID,Session) VALUES ('".$user_id."','".$session_id."')");
        header('Set-Cookie: custom_session='.$session_id.';Path=/;',false);
        header('Set-Cookie: username='.$username.';Path=/;',false);
        header('Location: /upload.php');
        //wtf many long live sessions for 1 user
    }
    else
    {
        echo "Invalid username or password";
    }
}
else
{
    $db = new SQLite3('db.sqlite');
    $cookie_id = $_COOKIE["custom_session"];
    $is_logined = isUserLogined($cookie_id);
    if($is_logined)
    {
        header("Location: /upload.php");
    }
}
?>

<html>
<head>
<title>Login page</title>
</head>
<body>
<div class="header">
      <h2>Login</h2>
</div>
<form method="post" action="login.php">
      <div class="input-group">
        <label>Username</label>
        <input type="text" name="username" value="">
      </div>
        <div class="input-group">
        <label>Password</label>
        <input type="password" name="password">
      </div>
      <div class="input-group">
        <button type="submit" class="btn" name="login">Login</button>
      </div>
</form>
</body>
</html>

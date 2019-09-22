<?PHP
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

if(!empty($_FILES['uploaded_file']))
{
    $cookie_id = $_COOKIE["custom_session"];
    $username = $_COOKIE["username"];
    $path = "uploads/".$username."/";

    
    if (!file_exists($path))
    {
        if (!file_exists('uploads'))
        {
            system('mkdir uploads');
        }
        system('mkdir '.$path);
    }

    $path = $path . basename( $_FILES['uploaded_file']['name']);
    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) 
    {
        echo "The file ".  basename( $_FILES['uploaded_file']['name'])." has been uploaded";
    } 
    else{
        echo "There was an error uploading the file, please try again!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Upload your files</title>
</head>
<body>
  <form enctype="multipart/form-data" action="upload.php" method="POST">
    <p>Upload your file</p>
    <input type="file" name="uploaded_file"></input><br />
    <input type="submit" value="Upload"></input>
  </form>
</body>
</html>

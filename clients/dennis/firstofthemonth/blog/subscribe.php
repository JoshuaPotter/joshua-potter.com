<?php
 
if(isset($_POST["SUBMIT"]))
{
    $email = $_POST["EMAIL"];
      
    if(empty($email))
    {
        echo "ERROR MESSAGE";
        die;
    }
    $cvsData .= "$email".PHP_EOL;
    $fp = fopen("mail.txt", "a");
      
    if($fp)
    {
        fwrite($fp,$cvsData); // Write information to the file
        fclose($fp); // Close the file
    }    
}
 
header("Location: index.html");
exit;
 
?>
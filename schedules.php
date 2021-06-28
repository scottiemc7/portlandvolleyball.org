<?php
$pass = $_POST['pass'];

if($pass == "pvasummer123")
{
    include 'schedules_secure.php';
}
else
{
    if(isset($_POST))
    {?>

            <form method="POST" action="schedules.php">
            Password <input type="password" name="pass"></input><br/>
            <input type="submit" name="submit" value="Submit"></input>
            </form>
    <?}
}
?>
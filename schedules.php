<?php
if(isset($_COOKIE['ScheduleLogin']))
{
    include 'schedules_secure.php';
}
else
{
    $pass = $_POST['pass'];

    if($pass == "pvasummer123")
    {
        setcookie('ScheduleLogin', md5($_POST['pass']));

    }
    else if(isset($_POST))
    {?>
        <form method="POST" action="schedules.php">
        Password <input type="password" name="pass"></input><br/>
        <input type="submit" name="submit" value="Submit"></input>
        </form>
    <?}
}
?>
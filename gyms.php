<?php
//if we need to password protect this again, here is the code.
// if(isset($_COOKIE['ScheduleLoginSummer']))
// {
    include 'gyms_secure.php';
// }
// else
// {
//     $pass = $_POST['pass'];

//     if($pass == "pvasummer123")
//     {
//         setcookie('ScheduleLoginSummer', md5($_POST['pass']));
//         header("Location: $_SERVER[PHP_SELF]");
//     }
//     else if(isset($_POST))
//     {
//   ?>
//         <form method="POST" action="gyms.php">
//         Password <input type="password" name="pass"></input><br/>
//         <input type="submit" name="submit" value="Submit"></input>
//         </form>
//     <?
//}
// }
?>
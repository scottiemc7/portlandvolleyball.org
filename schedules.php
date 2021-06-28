<?php include 'header.html.php'; ?>
<div id="content" class="container">
<?php
$pass = $_POST['pass'];

if($pass == "admin")
{
    include 'schedules_secure.php';
}
else
{
    if(isset($_POST))
    {?>

            <form method="POST" action="schedules.php">
            Password <input type="password" name="pass"></input><br/>
            <input type="submit" name="submit" value="Go"></input>
            </form>
    <?}
}
?>
</div>
<?php include("footer.html.php"); ?>
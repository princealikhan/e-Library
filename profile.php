<?php
include 'config.php';
include 'conn.php';
// Check if the user is logged in

if(!isSet($_SESSION['id']))
{
header("Location: login.php");
exit;
}
else{
$id=$_SESSION['id'];

}



// SQL - Collect username for Recipient 
    $ret = mysql_query("SELECT * FROM member WHERE id='$id' LIMIT 1");
    while($raw = mysql_fetch_array($ret)){ 
	$Rid = $raw['id']; 
	$Rname = $raw['username']; 
    $Email = $raw['email'];}


?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
 <HEAD>
  <TITLE>Private Page</TITLE>
  <META name="Author" Content="Bit Repository">
  <META name="Keywords" Content="private">
  <META name="Description" Content="Private Page">
</HEAD>

 <BODY>

<CENTER>Welcome, <?php echo $_SESSION['username']; ?> | <a href="logout.php">Logout</a><br /><br />

          <form action="home.php" method="get" enctype="multipart/form-data" name="submit">
		      <input type="text" name="username" value="<?php print $Rname?>" id="username" />dsf
    <input type="text" name="email" id="email"value="<?php print $Email?>" />
</form>

This is your private page. You can put specific content here.
</CENTER>
 </BODY>
</HTML>
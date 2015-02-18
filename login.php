<?php 
include "scripts/config.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <script type="text/javascript" src="js/mootools-1.2.1-core-yc.js"></script>
  <script type="text/javascript" src="js/process.js"></script>
  <link rel="stylesheet" type="text/css" href="style/style.css" />
<title>Log In</title>
<style type="text/css">
<!--
body {
	margin-top: 0px;
}
-->
</style></head>
<body>
<p>&nbsp;</p>



<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<div align="center">
<fieldset><legend align="center">Authentication</legend>
<table width="400" align="center" cellpadding="6" style="background-color:#FFF; border:#666 1px solid;">
  <form action="login.php" method="post" enctype="multipart/form-data" name="signinform" id="signinform">
    <tr>
      <td colspan="2" id="error_notification"><?php print "$errorMsg"; ?></font></td>
    </tr>
    <tr>
      <td width="21%"><strong>Username:</strong></td>
      <td width="51%"><input name="username" type="text" id="" style="width:60%;" /></td>
    </tr>
    <tr>
      <td><strong>Password:</strong></td>
      <td><input name="pass" type="password" id="pass" maxlength="24" style="width:60%;"/></td>
    </tr>
   <td>
   <input id="myButton" type="submit" name="myButton" value="Login">
<div id="ajax_loading"><img align="absmiddle" src="images/spinner.gif">&nbsp;Processing...</div></td>
   
    <tr>
      <td colspan="2">Need an Account? <a href="register.php">Click Here</a><br />
        <br /></td>
    </tr>
    <tr>
      <td colspan="2">

    </tr>
  </form>
</table>
</fieldset>
</center><p><br />
  <br />
</p>
</body>
</html>
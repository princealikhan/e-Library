<?php
$from = ""; // Initialize the email from variable
// This code runs only if the username is posted
if (isset ($_POST['username'])){
	 
	 $username = preg_replace('#[^A-Za-z0-9]#i', '', $_POST['username']); // filter everything but letters and numbers
	 $gender = preg_replace('#[^a-z]#i', '', $_POST['gender']); // filter everything but lowercase letters
	 $b_m = preg_replace('#[^0-9]#i', '', $_POST['birth_month']); // filter everything but numbers
     $b_d = preg_replace('#[^0-9]#i', '', $_POST['birth_day']); // filter everything but numbers
	 $b_y = preg_replace('#[^0-9]#i', '', $_POST['birth_year']); // filter everything but numbers
     $email1 = $_POST['email1'];
     $email2 = $_POST['email2'];
     $pass1 = $_POST['pass1'];
     $pass2 = $_POST['pass2'];
	 
     $humancheck = $_POST['humancheck'];

     $email1 = stripslashes($email1); 
     $pass1 = stripslashes($pass1); 
     $email2 = stripslashes($email2);
     $pass2 = stripslashes($pass2); 
	 
     $email1 = strip_tags($email1);
     $pass1 = strip_tags($pass1);
     $email2 = strip_tags($email2);
     $pass2 = strip_tags($pass2);

     // Connect to database
     include_once "scripts/conn.php";
     $emailCHecker = mysql_real_escape_string($email1);
	 $emailCHecker = str_replace("`", "", $emailCHecker);
	 // Database duplicate username check setup for use below in the error handling if else conditionals
	 $sql_uname_check = mysql_query("SELECT username FROM member WHERE username='$username'"); 
     $uname_check = mysql_num_rows($sql_uname_check);
     // Database duplicate e-mail check setup for use below in the error handling if else conditionals
     $sql_email_check = mysql_query("SELECT email FROM member WHERE email='$emailCHecker'");
     $email_check = mysql_num_rows($sql_email_check);

     // Error handling for missing data
     if ((!$username) || (!$gender) || (!$b_m) || (!$b_d) || (!$b_y) || (!$email1) || (!$email2) || (!$pass1) || (!$pass2)) { 

     $errorMsg = 'ERROR: You did not submit the following required information:<br /><br />';
  
     if(!$username){ 
       $errorMsg .= ' * User Name<br />';
     } 
     if(!$gender){ 
       $errorMsg .= ' * Gender: Confirm your sex.<br />';
     } 	
	 if(!$b_m){ 
       $errorMsg .= ' * Birth Month<br />';      
     }
	 if(!$b_d){ 
       $errorMsg .= ' * Birth Day<br />';        
     } 
	 if(!$b_y){ 
       $errorMsg .= ' * Birth year<br />';        
     } 		
	 if(!$email1){ 
       $errorMsg .= ' * Email Address<br />';      
     }
	 if(!$email2){ 
       $errorMsg .= ' * Confirm Email Address<br />';        
     } 	
	 if(!$pass1){ 
       $errorMsg .= ' * Login Password<br />';      
     }
	 if(!$pass2){ 
       $errorMsg .= ' * Confirm Login Password<br />';        
     } 	
	
     } else if ($email1 != $email2) {
              $errorMsg = 'ERROR: Your Email fields below do not match<br />';
     } else if ($pass1 != $pass2) {
              $errorMsg = 'ERROR: Your Password fields below do not match<br />';
     } else if ($humancheck != "") {
              $errorMsg = 'ERROR: The Human Check field must be cleared to be sure you are human<br />';		 
     } else if (strlen($username) < 4) {
	           $errorMsg = "<u>ERROR:</u><br />Your User Name is too short. 4 - 20 characters please.<br />"; 
     } else if (strlen($username) > 20) {
	           $errorMsg = "<u>ERROR:</u><br />Your User Name is too long. 4 - 20 characters please.<br />"; 
     } else if ($uname_check > 0){ 
              $errorMsg = "<u>ERROR:</u><br />Your User Name is already in use inside of our system. Please try another.<br />"; 
     } else if ($email_check > 0){ 
              $errorMsg = "<u>ERROR:</u><br />Your Email address is already in use inside of our system. Please use another.<br />"; 
     } else { // Error handling is ended, process the data and add member to database
     ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
     $email1 = mysql_real_escape_string($email1);
     $pass1 = mysql_real_escape_string($pass1);
	 
     // Add MD5 Hash to the password variable
     $db_password = md5($pass1); 
	 
	 // Convert Birthday to a DATE field type format(YYYY-MM-DD) out of the month, day, and year supplied 
	 $full_birthday = "$b_y-$b_m-$b_d";

     // GET USER IP ADDRESS
     $ipaddress = getenv('REMOTE_ADDR');

     // Add user info into the database table for the main site table
 $sql = mysql_query("INSERT INTO member (username, gender, birthday, email, password, ipaddress, sign_up_date,email_activated) 
     VALUES('$username','$gender','$full_birthday','$email1','$db_password', '$ipaddress', now(),'1')")  
     or die (mysql_error());
 
     $id = mysql_insert_id();
	 
	 // Create directory(folder) to hold each user's files(pics, MP3s, etc.)		
     mkdir("members/$id", 0755);	

    //!!!!!!!!!!!!!!!!!!!!!!!!!    Email User the activation link    !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    $to = "$email1";
		$dyn_www='';									 
    $from = $dyn_www; // $adminEmail is established in [ scripts/connect_to_mysql.php ]
    $subject = 'Complete Your ' . $dyn_www . ' Registration';
    //Begin HTML Email Message
    $message = "Hi $username,

   Complete this step to activate your login identity at $dyn_www

   Click the line below to activate when ready

   http://$dyn_www/activation.php?id=$id&sequence=$db_password
   If the URL above is not an active link, please copy and paste it into your browser address bar

   Login after successful activation using your:  
   E-mail Address: $email1 
   Password: $pass1

   See you on the site!";
   //end of message
	$headers  = "From: $from\r\n";
    $headers .= "Content-type: text\r\n";

    mail($to, $subject, $message, $headers);
	
	 $a= '<center><a href="login.php">Go to Login Page</a></center>';
echo $a;

   $msgToUser = "<h2>One Last Step - Activate through Email</h2><h4>$username, there is one last step to verify your email identity:</h4><br />
   In a moment you will be sent an Activation link to your email address.<br /><br />
   <br />

   <strong><font color=\"#990000\">VERY IMPORTANT:</font></strong> 
   If you check your email with your host providers default email application, there may be issues with seeing the email contents.  If this happens to you and you cannot read the message to activate, download the file and open using a text editor.<br /><br />

   ";
   
   include_once 'scripts/msgToUser.php'; 
   exit();

   } // Close else after duplication checks

} else { // if the form is not posted with variables, place default empty variables so no warnings or errors show
	  
	  $errorMsg = "";
      $username = "";
	  $gender = "";
	  $b_m = "";
	  $b_d = "";
	  $b_y = "";
	  $email1 = "";
	  $email2 = "";
	  $pass1 = "";
	  $pass2 = "";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<me0ta name="Description" content="Register to yourdomain" />
<meta name="Keywords" content="register, yourdomain" />
<meta name="rating" content="General" />
<title>Register</title>
<link href="main.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script src="js/jquery-1.4.2.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript"> 
$(document).ready(function() {
	$("#username").blur(function() {
		$("#nameresponse").removeClass().text('Checking Username...').fadeIn(1000);
		$.post("scripts/check_signup_name.php",{ username:$(this).val() } ,function(data) {
		  	$("#nameresponse").fadeTo(200,0.1,function() { 
			  $(this).html(data).fadeTo(900,1);	
			});
        });
	});
});
function toggleSlideBox(x) {
		if ($('#'+x).is(":hidden")) {
			$('#'+x).slideDown(300);
		} else {
			$('#'+x).slideUp(300);
		}
}
</script>
<style type="text/css">
<!--
.style26 {color: #FF0000}
.style28 {font-size: 14px}
.brightRed {
	color: #F00;
}
.textSize_9px {
	font-size: 9px;
}
-->
</style>
</head>
<body>
<tabl0e class="mainBodyTable" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="738" valign="top">

        <h2 align="center" style="margin-left:80px;">Create Your Account </h2>

      <table width="600" align="center" cellpadding="8" cellspacing="0" style="border:#999 1px solid; background-color:#FBFBFB;">
        <form action="register.php" method="post" enctype="multipart/form-data">
          <tr>
            <td align="left" colspan="2"><font color="#FF0000"><?php print "$errorMsg"; ?></font></td>
          </tr>       
         <tr>
            <td width="153" bgcolor="#FFFFFF"><div align="left">User Name:<span class="brightRed"> *</span></div></td>
            <td width="413" bgcolor="#FFFFFF"><div align="left">
              <input name="username" type="text" class="formFields" id="username" value="<?php print "$username"; ?>" size="32" maxlength="20" />
              <span id="nameresponse"><span class="textSize_9px"><span class="greyColor">Alphanumeric Characters Only</span></span></span></div></td>
          </tr>
          <tr>
            <td bgcolor="#EFEFEF"><div align="left">Gender:<span class="brightRed"> *</span></div></td>
            <td bgcolor="#EFEFEF"><label>
              <div align="left">
                <input name="gender" type="radio" id="gender" value="m" checked="checked" />
                Male &nbsp;
                <input type="radio" name="gender" id="gender" value="f" />
                Female              </div>
            </label></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><div align="left">Date of Birth: <span class="brightRed">*</span></div></td>
            <td bgcolor="#FFFFFF">
<div align="left">
  <select name="birth_month" class="formFields" id="birth_month">
    <option value="<?php print "$b_m"; ?>"><?php print "$b_m"; ?></option>
    <option value="01">January</option>
    <option value="02">February</option>
    <option value="03">March</option>
    <option value="04">April</option>
    <option value="05">May</option>
    <option value="06">June</option>
    <option value="07">July</option>
    <option value="08">August</option>
    <option value="09">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option>
  </select> 
  <select name="birth_day" class="formFields" id="birth_day">
    <option value="<?php print "$b_d"; ?>"><?php print "$b_d"; ?></option>
    <option value="01">1</option>
    <option value="02">2</option>
    <option value="03">3</option>
    <option value="04">4</option>
    <option value="05">5</option>
    <option value="06">6</option>
    <option value="07">7</option>
    <option value="08">8</option>
    <option value="09">9</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
    <option value="13">13</option>
    <option value="14">14</option>
    <option value="15">15</option>
    <option value="16">16</option>
    <option value="17">17</option>
    <option value="18">18</option>
    <option value="19">19</option>
    <option value="20">20</option>
    <option value="21">21</option>
    <option value="22">22</option>
    <option value="23">23</option>
    <option value="24">24</option>
    <option value="25">25</option>
    <option value="26">26</option>
    <option value="27">27</option>
    <option value="28">28</option>
    <option value="29">29</option>
    <option value="30">30</option>
    <option value="31">31</option>
  </select> 
  <select name="birth_year" class="formFields" id="birth_year">
    <option value="<?php print "$b_y"; ?>"><?php print "$b_y"; ?></option>
    <option value="2010">2010</option>
    <option value="2009">2009</option>
    <option value="2008">2008</option>
    <option value="2007">2007</option>
    <option value="2006">2006</option>
    <option value="2005">2005</option>
    <option value="2004">2004</option>
    <option value="2003">2003</option>
    <option value="2002">2002</option>
    <option value="2001">2001</option>
    <option value="2000">2000</option>
    <option value="1999">1999</option>
    <option value="1998">1998</option>
    <option value="1997">1997</option>
    <option value="1996">1996</option>
    <option value="1995">1995</option>
    <option value="1994">1994</option>
    <option value="1993">1993</option>
    <option value="1992">1992</option>
    <option value="1991">1991</option>
    <option value="1990">1990</option>
    <option value="1989">1989</option>
    <option value="1988">1988</option>
    <option value="1987">1987</option>
    <option value="1986">1986</option>
    <option value="1985">1985</option>
    <option value="1984">1984</option>
    <option value="1983">1983</option>
    <option value="1982">1982</option>
    <option value="1981">1981</option>
    <option value="1980">1980</option>
    <option value="1979">1979</option>
    <option value="1978">1978</option>
    <option value="1977">1977</option>
    <option value="1976">1976</option>
    <option value="1975">1975</option>
    <option value="1974">1974</option>
    <option value="1973">1973</option>
    <option value="1972">1972</option>
    <option value="1971">1971</option>
    <option value="1970">1970</option>
    <option value="1969">1969</option>
    <option value="1968">1968</option>
    <option value="1967">1967</option>
    <option value="1966">1966</option>
    <option value="1965">1965</option>
    <option value="1964">1964</option>
    <option value="1963">1963</option>
    <option value="1962">1962</option>
    <option value="1961">1961</option>
    <option value="1960">1960</option>
    <option value="1959">1959</option>
    <option value="1958">1958</option>
    <option value="1957">1957</option>
    <option value="1956">1956</option>
    <option value="1955">1955</option>
    <option value="1954">1954</option>
    <option value="1953">1953</option>
    <option value="1952">1952</option>
    <option value="1951">1951</option>
    <option value="1950">1950</option>
    <option value="1949">1949</option>
    <option value="1948">1948</option>
    <option value="1947">1947</option>
    <option value="1946">1946</option>
    <option value="1945">1945</option>
    <option value="1944">1944</option>
    <option value="1943">1943</option>
    <option value="1942">1942</option>
    <option value="1941">1941</option>
    <option value="1940">1940</option>
    <option value="1939">1939</option>
    <option value="1938">1938</option>
    <option value="1937">1937</option>
    <option value="1936">1936</option>
    <option value="1935">1935</option>
    <option value="1934">1934</option>
    <option value="1933">1933</option>
    <option value="1932">1932</option>
    <option value="1931">1931</option>
    <option value="1930">1930</option>
    <option value="1929">1929</option>
    <option value="1928">1928</option>
    <option value="1927">1927</option>
    <option value="1926">1926</option>
    <option value="1925">1925</option>
    <option value="1924">1924</option>
    <option value="1923">1923</option>
    <option value="1922">1922</option>
    <option value="1921">1921</option>
    <option value="1920">1920</option>
    <option value="1919">1919</option>
    <option value="1918">1918</option>
    <option value="1917">1917</option>
    <option value="1916">1916</option>
    <option value="1915">1915</option>
    <option value="1914">1914</option>
    <option value="1913">1913</option>
    <option value="1912">1912</option>
    <option value="1911">1911</option>
    <option value="1910">1910</option>
    <option value="1909">1909</option>
    <option value="1908">1908</option>
    <option value="1907">1907</option>
    <option value="1906">1906</option>
    <option value="1905">1905</option>
    <option value="1904">1904</option>
    <option value="1903">1903</option>
    <option value="1902">1902</option>
    <option value="1901">1901</option>
    <option value="1900">1900</option>
  </select> 
  <a href="#" onclick="return false" onmousedown="javascript:toggleSlideBox('why');">why?</a></div>
<div id="why" style="background-color:#E6F5FF; border:#999 1px solid; padding:12px; display:none; margin-top:8px;">
     <div align="left">Sometime down the road we may offer content that is only suitable for people over 18. We require this information to check your age. <br />
         <br />
       We can also use this information to alert your friends to when your birthday is.     </div>
</div></td>
          </tr>                  
          <tr>
            <td bgcolor="#EFEFEF"><div align="left">Email Address: <span class="brightRed">*</span></div></td>
            <td bgcolor="#EFEFEF"><div align="left">
              <input name="email1" type="text" class="formFields" id="email1" value="<?php print "$email1"; ?>" size="32" maxlength="48" />
            </div></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><div align="left">Confirm Email:<span class="brightRed"> *</span></div></td>
            <td bgcolor="#FFFFFF"><div align="left">
              <input name="email2" type="text" class="formFields" id="email2" value="<?php print "$email2"; ?>" size="32" maxlength="48" />
            </div></td>
          </tr>
          <tr>
            <td bgcolor="#EFEFEF"><div align="left">Create Password:<span class="brightRed"> *</span></div></td>
            <td bgcolor="#EFEFEF"><div align="left">
              <input name="pass1" type="password" class="formFields" id="pass1" size="32" maxlength="16" />
              <span class="textSize_9px"><span class="greyColor">Alphanumeric Characters Only</span></span></div></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><div align="left">Confirm Password:<span class="brightRed"> *</span></div></td>
            <td bgcolor="#FFFFFF"><div align="left">
              <input name="pass2" type="password" class="formFields" id="pass2" size="32" maxlength="16" />
            <span class="textSize_9px"><span class="greyColor">Alphanumeric Characters Only</span></span></div></td>
          </tr>
          <tr>
            <td bgcolor="#EFEFEF"><div align="left">Human Check: <span class="brightRed">*</span></div></td>
            <td bgcolor="#EFEFEF"><div align="left">
              <input name="humancheck" type="text" class="formFields" id="humancheck" value="Please remove all of this text" size="32" maxlength="32" />
            </div></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><div align="left"></div></td>
            <td bgcolor="#FFFFFF"><p align="left">
              <input type="submit" name="Submit" value="Sign Up!" />
              <br />
            </p></td>
          </tr>
        </form>
      </table>
      <br />
      <br /></td>
    <td width="160" valign="top"></td>
  </tr>
</table>

</body>
</html>
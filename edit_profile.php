<?php
/* Web Intersect Social Network Template System and CMS v1.34
 * Licensed under the GNU General Public License version 3.0 (GPLv3)
 * http://www.webintersect.com/license.php
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 * See the GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Date: February 9, 2010
 *------------------------------------------------------------------------------------------------*/
// Start_session, check if user is logged in or not, and connect to the database all in one included file
include_once("scripts/checkuserlog.php");
?>
<?php
////////////////////////////////////////////////      Member log in double check       ///////////////////////////////////////////////////
if (!$_SESSION['idx']) { 
    $msgToUser = '<br /><br /><font color="#FF0000">Only site member can do that</font><p><a href="register.php">Join Here</a></p>';
    include_once 'scripts/msgToUser.php'; 
    exit(); 
} else if ($logOptions_id != $_SESSION['id']) {
	$msgToUser = '<br /><br /><font color="#FF0000">Only site member can do that</font><p><a href="register.php">Join Here</a></p>';
    include_once 'msgToUser.php'; 
    exit(); 
}
////////////////////////////////////////////////      End Member log in double check       ///////////////////////////////////////
$id = $logOptions_id; // Set the profile owner ID
// Now let's initialize vars to be printed to page in the HTML section so our script does not return errors 
// they must be initialized in some server environments, not shown in video
$error_msg = ""; 
$errorMsg = "";
$success_msg = "";
$firstname = "";
$middlename = "";
$lastname = "";
$country = "";	
$state = "";
$city = "";
$zip = "";
$bio_body = "";
$bio_body = "";
$website = "";
$youtube = "";
$facebook = "";
$twitter = "";
$user_pic = "";
$cacheBuster = rand(9999999,99999999999); // Put appended to the image URL will help always show new when changed
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ------- IF WE ARE PARSING ANY DATA ------------------------------------------------------------------------------------------------------------
if (isset($_POST['parse_var'])){
	
//// W.I.P.I.T ///
$thisWipit = $_POST['thisWipit'];
$sessWipit = base64_decode($_SESSION['wipit']);
//
if (!isset($_SESSION['wipit']) || !isset($_SESSION['idx'])) {
	    echo  'Error: Your session expired from inactivity. Please <a href="index.php">click here to refresh it.</a>.';
        exit();
}
//
if ($sessWipit != $thisWipit) {
		echo  'Your session expired from inactivity. Please <a href="index.php">click here to refresh it.</a>.';
    	exit();
}
//
if ($thisWipit == "") {
		echo  'Error: Missing Data... click back in your browser please.';
    	exit();
}
//------------------------------------------------------------------------------------------------------------------------
// ------- PARSING PICTURE UPLOAD ---------
if ($_POST['parse_var'] == "pic"){
	
	// If a file is posted with the form
	if ($_FILES['fileField']['tmp_name'] != "") { 
            $maxfilesize = 51200; // 51200 bytes equals 50kb
            if($_FILES['fileField']['size'] > $maxfilesize ) { 

                        $error_msg = '<font color="#FF0000">ERROR: Your image was too large, please try again.</font>';
                        unlink($_FILES['fileField']['tmp_name']); 

            } else if (!preg_match("/\.(gif|jpg|png)$/i", $_FILES['fileField']['name'] ) ) {

                        $error_msg = '<font color="#FF0000">ERROR: Your image was not one of the accepted formats, please try again.</font>';
                        unlink($_FILES['fileField']['tmp_name']); 

            } else { 
                        $newname = "$id.jpg";
                        $place_file = move_uploaded_file( $_FILES['fileField']['tmp_name'], "members/$id/".$newname);
            }
    } 
}
// ------- END PARSING PICTURE UPLOAD ---------
//------------------------------------------------------------------------------------------------------------------------
// ------- PARSING PERSONAL INFO ---------
if ($_POST['parse_var'] == "location"){
	
	$firstname = preg_replace('#[^A-Za-z]#i', '', $_POST['firstname']); // filter everything but desired characters
	$lastname = preg_replace('#[^A-Za-z]#i', '', $_POST['lastname']); // filter everything but desired characters
	$country = strip_tags($_POST['country']);
	$country = str_replace("'", "&#39;", $country);
	$country = str_replace("`", "&#39;", $country);
	$country = mysql_real_escape_string($country);
	$state = preg_replace('#[^A-Z a-z]#i', '', $_POST['state']); // filter everything but desired characters
    $city = preg_replace('#[^A-Z a-z]#i', '', $_POST['city']); // filter everything but desired characters
	
	$sqlUpdate = mysql_query("UPDATE member SET firstname='$firstname', lastname='$lastname', country='$country', state='$state', city='$city' WHERE id='$id' LIMIT 1");
    if ($sqlUpdate){
        $success_msg = '<img src="images/round_success.png" width="20" height="20" alt="Success" />Location information has been updated successfully.';
    } else {
		$error_msg = '<img src="images/round_error.png" width="20" height="20" alt="Failure" /> ERROR: Problems arose during the information exchange, please try again later.</font>';
    }
}
// ------- END PARSING LOCATION INFO ---------
//------------------------------------------------------------------------------------------------------------------------
// ------- PARSING LINKS ---------
if ($_POST['parse_var'] == "links"){
	
	$website = $_POST['website'];
	$website = strip_tags($website);
	$website = str_replace("http://", "", $website);
	$website = str_replace("'", "&#39;", $website);
	$website = str_replace("`", "&#39;", $website);
	$website = mysql_real_escape_string($website);
	$youtube = preg_replace('#[^A-Za-z_0-9]#i', '', $_POST['youtube']); // filter everything but desired characters
	$facebook = preg_replace('#[^0-9]#i', '', $_POST['facebook']); // filter everything but desired characters
	$twitter = preg_replace('#[^A-Za-z_0-9]#i', '', $_POST['twitter']); // filter everything but desired characters

    $sqlUpdate = mysql_query("UPDATE member SET website='$website', youtube='$youtube', facebook='$facebook', twitter='$twitter' WHERE id='$id' LIMIT 1");
	if ($sqlUpdate){
            $success_msg = '<img src="images/round_success.png" width="20" height="20" alt="Success" />Your links and API connections have been updated successfully.';
    } else {
		    $error_msg = '<img src="images/round_error.png" width="20" height="20" alt="Failure" /> ERROR: Problems arose during the information exchange, please try again later.</font>';
    }
}
// ------- END PARSING LINKS ---------
//------------------------------------------------------------------------------------------------------------------------
// ------- PARSING BIO ---------
if ($_POST['parse_var'] == "bio"){
	
	$bio_body = $_POST['bio_body'];
	$bio_body = str_replace("'", "&#39;", $bio_body);
	$bio_body = str_replace("`", "&#39;", $bio_body);
    $bio_body = mysql_real_escape_string($bio_body);
    $bio_body = nl2br(htmlspecialchars($bio_body));
	 // Update the database data now here for all fields posted in the form
	 $sqlUpdate = mysql_query("UPDATE member SET bio_body='$bio_body' WHERE id='$id' LIMIT 1");
     if ($sqlUpdate){
            $success_msg = '<img src="images/round_success.png" width="20" height="20" alt="Success" />Your description information has been updated successfully.';
     } else {
		    $error_msg = '<img src="images/round_error.png" width="20" height="20" alt="Failure" /> ERROR: Problems arose during the information exchange, please try again later.</font>';
     }
}
// ------- END PARSING BIO ---------
//------------------------------------------------------------------------------------------------------------------------
//////////////////////////////////////////////////////////////////////////////////
} // <<--- This closes "if ($_POST['parse_var']){"
// ------- END IF WE ARE PARSING ANY DATA ------------------------------------------------------------------------------------------------------------
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// ------- ESTABLISH THE PROFILE INTERACTION TOKEN ---------
if (!isset($_SESSION['wipit'])) { // Check to see if session wipit is set yet
	session_register('wipit'); // Be sure to register the session if it is not set yet
}
$thisRandNum = rand(9999999999999,999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum);
// ------- END ESTABLISH THE PROFILE INTERACTION TOKEN ---------

// All parsing has ended by this point in the script, so query the most current data for member
// This will show refreshed data to the user so they do not see old data after making changes
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Final default sql query that will refresh the member data on page, and show most current
$sql_default = mysql_query("SELECT * FROM member WHERE id='$id'");

while($row = mysql_fetch_array($sql_default)){ 

	$firstname = $row["firstname"];
	$lastname = $row["lastname"];
	$country = $row["country"];	
	$state = $row["state"];
	$city = $row["city"];
	$bio_body = $row["bio_body"];
	$bio_body = str_replace("<br />", "", $bio_body);
	$bio_body = stripslashes($bio_body);
	$website = $row["website"];
	$youtube = $row["youtube"];
    $facebook = $row["facebook"];
	$twitter = $row["twitter"];
	///////  Mechanism to Display Pic. See if they have uploaded a pic or not  //////////////////////////
	$check_pic = "members/$id/$id.jpg";
	$default_pic = "members/0/image01.jpg";
	if (file_exists($check_pic)) {
    $user_pic = "<img src=\"$check_pic?$cacheBuster\" width=\"50px\" />"; // forces picture to be 100px wide and no more
	} else {
	$user_pic = "<img src=\"$default_pic\" width=\"50px\" />"; // forces default picture to be 100px wide and no more
	}
	

} // close while loop
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="Description" content="Profile edit area for <?php echo "$firstname $lastname"; ?>" />
<meta name="Keywords" content="<?php echo "$firstname, $lastname"; ?>" />
<meta name="rating" content="General" />
<meta name="revisit-after" content="7 days" />
<meta name="ROBOTS" content="All" />
<title>Edit profile area for <?php echo "$firstname $lastname"; ?></title>
<link href="style/main.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script src="js/jquery-1.4.2.js" type="text/javascript"></script>
<style type="text/css">
<!--
.brightRed {	color: #F00;}
.textSize_9px {	font-size: 9px;}
h1 { display:inline;	}
h2 { display:inline; }
h3 { display:inline;	}
.boxHeader {
	border:#999 1px solid; background-color: #FFF; background-image:url(style/accountStrip1.jpg); background-repeat:repeat-x; padding:5px; margin-left:19px; margin-right:20px; margin-top:6px; color:#060; text-decoration:none;
}

.boxHeader a:link {
	color: #060;
	text-decoration:none;
}
.boxHeader a:hover {
	color: #000;
	text-decoration:none;
}
.editBox {
	display:none;
}
-->
</style>
<script language="javascript" type="text/javascript"> 
function toggleSlideBox(x) {
		if ($('#'+x).is(":hidden")) {
			$(".editBox").slideUp(200);
			$('#'+x).slideDown(300);
		} else {
			$('#'+x).slideUp(300);
		}
}
</script>
</head>
<body>

<table class="mainBodyTable" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><br />
      <table width="94%" border="0" align="center">
        <tr>
          <td><h3><?php echo $success_msg; ?><font color="#FF0000"><?php echo $errorMsg; ?></font></h3>            <h2>&nbsp;</h2></td>
        </tr>
      </table>
      <br />
      
      <div class="boxHeader">
      <a href="#" onclick="return false" onmousedown="javascript:toggleSlideBox('picBox');">
       <img src="images/toggleBtn1.png" alt="Toggle" width="22" height="30" border="0" style="position:relative; top:6px;" />&nbsp;<h2>Profile Picture</h2>
      </a> 
      </div>
      <div class="editBox" id="picBox">
        <table width="700" align="center" cellpadding="10" cellspacing="0" style="border:#999 1px solid; background-color:#FBFBFB;">
          <form action="edit_profile.php" method="post" enctype="multipart/form-data">
            <tr>
              <td width="61"><?php echo $user_pic; ?></td>
              <td width="521"><input name="fileField" type="file" class="formFields" id="fileField" size="42" />
              50 kb max </td>
              <td width="56"><input name="updateBtn1" type="submit" id="updateBtn1" value="Update" />
                <input name="parse_var" type="hidden" value="pic" />
                <input name="thisWipit" type="hidden" value="<?php echo $thisRandNum; ?>" />
              </td>
            </tr>
          </form>
        </table>
      </div>
      <!-- -->
      <div class="boxHeader">
      <a href="#" onclick="return false" onmousedown="javascript:toggleSlideBox('locationBox');">
      <img src="images/toggleBtn1.png" alt="Toggle" width="22" height="30" border="0" style="position:relative; top:6px;" />
      <h2>Personal Information</h2>
      </a>
      </div>
      <div class="editBox" id="locationBox">
      <table width="700" align="center" cellpadding="10" cellspacing="0" style="border:#999 1px solid; background-color:#FBFBFB;">
        <form action="edit_profile.php" method="post" enctype="multipart/form-data">
          <tr>
            <td width="602"><table width="100%" border="0" align="center">
              <tr>
                <td width="34%"><strong>First Name</strong></td>
                <td width="33%"><strong>Last Name</strong></td>
                <td width="33%">&nbsp;</td>
              </tr>
            </table>
              <table width="100%" border="0" align="center">
              <tr>
                <td width="34%"><input name="firstname" type="text" class="formFields" id="firstname" value="<?php echo $firstname; ?>" style="width:99%" maxlength="20" /></td>
                <td width="33%"><input name="lastname" type="text" class="formFields" id="lastname" value="<?php echo $lastname; ?>" style="width:99%" maxlength="20" /></td>
                <td width="33%">&nbsp;</td>
              </tr>
            </table>
              <table width="100%" border="0" align="center">
              <tr>
                <td width="34%"><strong>Country</strong></td>
                <td width="33%"><strong>State</strong></td>
                <td width="33%"><strong>City</strong></td>
                </tr>
            </table>
              <table width="100%" border="0" align="center">
                <tr>
                  <td width="34%">
                  <select name="country" class="formFields">
                    <option value="<?php print "$country"; ?>"><?php print "$country"; ?></option>
                    <option value="United States of America">United States of America</option>
                    <option value="Afghanistan">Afghanistan</option>
                    <option value="Albania">Albania</option>
                    <option value="Algeria">Algeria</option>
                    <option value="American Samoa">American Samoa</option>
                    <option value="Andorra">Andorra</option>
                    <option value="Angola">Angola</option>
                    <option value="Anguilla">Anguilla</option>
                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                    <option value="Argentina">Argentina</option>
                    <option value="Armenia">Armenia</option>
                    <option value="Aruba">Aruba</option>
                    <option value="Australia">Australia</option>
                    <option value="Austria">Austria</option>
                    <option value="Azerbaijan">Azerbaijan</option>
                    <option value="Bahamas">Bahamas</option>
                    <option value="Bahrain">Bahrain</option>
                    <option value="Bangladesh">Bangladesh</option>
                    <option value="Barbados">Barbados</option>
                    <option value="Belarus">Belarus</option>
                    <option value="Belgium">Belgium</option>
                    <option value="Belize">Belize</option>
                    <option value="Benin">Benin</option>
                    <option value="Bermuda">Bermuda</option>
                    <option value="Bhutan">Bhutan</option>
                    <option value="Bolivia">Bolivia</option>
                    <option value="Bonaire">Bonaire</option>
                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                    <option value="Botswana">Botswana</option>
                    <option value="Brazil">Brazil</option>
                    <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                    <option value="Brunei">Brunei</option>
                    <option value="Bulgaria">Bulgaria</option>
                    <option value="Burkina Faso">Burkina Faso</option>
                    <option value="Burundi">Burundi</option>
                    <option value="Cambodia">Cambodia</option>
                    <option value="Cameroon">Cameroon</option>
                    <option value="Canada">Canada</option>
                    <option value="Canary Islands">Canary Islands</option>
                    <option value="Cape Verde">Cape Verde</option>
                    <option value="Cayman Islands">Cayman Islands</option>
                    <option value="Central African Republic">Central African Republic</option>
                    <option value="Chad">Chad</option>
                    <option value="Channel Islands">Channel Islands</option>
                    <option value="Chile">Chile</option>
                    <option value="China">China</option>
                    <option value="Christmas Island">Christmas Island</option>
                    <option value="Cocos Island">Cocos Island</option>
                    <option value="Columbia">Columbia</option>
                    <option value="Comoros">Comoros</option>
                    <option value="Congo">Congo</option>
                    <option value="Cook Islands">Cook Islands</option>
                    <option value="Costa Rica">Costa Rica</option>
                    <option value="Cote D'Ivoire">Cote D'Ivoire</option>
                    <option value="Croatia">Croatia</option>
                    <option value="Cuba">Cuba</option>
                    <option value="Curacao">Curacao</option>
                    <option value="Cyprus">Cyprus</option>
                    <option value="Czech Republic">Czech Republic</option>
                    <option value="Denmark">Denmark</option>
                    <option value="Djibouti">Djibouti</option>
                    <option value="Dominica">Dominica</option>
                    <option value="Dominican Republic">Dominican Republic</option>
                    <option value="East Timor">East Timor</option>
                    <option value="Ecuador">Ecuador</option>
                    <option value="Egypt">Egypt</option>
                    <option value="El Salvador">El Salvador</option>
                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                    <option value="Eritrea">Eritrea</option>
                    <option value="Estonia">Estonia</option>
                    <option value="Ethiopia">Ethiopia</option>
                    <option value="Falkland Islands">Falkland Islands</option>
                    <option value="Faroe Islands">Faroe Islands</option>
                    <option value="Fiji">Fiji</option>
                    <option value="Finland">Finland</option>
                    <option value="France">France</option>
                    <option value="French Guiana">French Guiana</option>
                    <option value="French Polynesia">French Polynesia</option>
                    <option value="French Southern Ter">French Southern Ter</option>
                    <option value="Gabon">Gabon</option>
                    <option value="Gambia">Gambia</option>
                    <option value="Georgia">Georgia</option>
                    <option value="Germany">Germany</option>
                    <option value="Ghana">Ghana</option>
                    <option value="Gibraltar">Gibraltar</option>
                    <option value="Great Britain">Great Britain</option>
                    <option value="Greece">Greece</option>
                    <option value="Greenland">Greenland</option>
                    <option value="Grenada">Grenada</option>
                    <option value="Guadeloupe">Guadeloupe</option>
                    <option value="Guam">Guam</option>
                    <option value="Guatemala">Guatemala</option>
                    <option value="Guinea">Guinea</option>
                    <option value="Guyana">Guyana</option>
                    <option value="Haiti">Haiti</option>
                    <option value="Hawaii">Hawaii</option>
                    <option value="Honduras">Honduras</option>
                    <option value="Hong Kong">Hong Kong</option>
                    <option value="Hungary">Hungary</option>
                    <option value="Iceland">Iceland</option>
                    <option value="India">India</option>
                    <option value="Indonesia">Indonesia</option>
                    <option value="Iran">Iran</option>
                    <option value="Iraq">Iraq</option>
                    <option value="Ireland">Ireland</option>
                    <option value="Isle of Man">Isle of Man</option>
                    <option value="Israel">Israel</option>
                    <option value="Italy">Italy</option>
                    <option value="Jamaica">Jamaica</option>
                    <option value="Japan">Japan</option>
                    <option value="Jordan">Jordan</option>
                    <option value="Kazakhstan">Kazakhstan</option>
                    <option value="Kenya">Kenya</option>
                    <option value="Kiribati">Kiribati</option>
                    <option value="Korea North">Korea North</option>
                    <option value="Korea South">Korea South</option>
                    <option value="Kuwait">Kuwait</option>
                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                    <option value="Laos">Laos</option>
                    <option value="Latvia">Latvia</option>
                    <option value="Lebanon">Lebanon</option>
                    <option value="Lesotho">Lesotho</option>
                    <option value="Liberia">Liberia</option>
                    <option value="Libya">Libya</option>
                    <option value="Liechtenstein">Liechtenstein</option>
                    <option value="Lithuania">Lithuania</option>
                    <option value="Luxembourg">Luxembourg</option>
                    <option value="Macau">Macau</option>
                    <option value="Macedonia">Macedonia</option>
                    <option value="Madagascar">Madagascar</option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="Malawi">Malawi</option>
                    <option value="Maldives">Maldives</option>
                    <option value="Mali">Mali</option>
                    <option value="Malta">Malta</option>
                    <option value="Marshall Islands">Marshall Islands</option>
                    <option value="Martinique">Martinique</option>
                    <option value="Mauritania">Mauritania</option>
                    <option value="Mauritius">Mauritius</option>
                    <option value="Mayotte">Mayotte</option>
                    <option value="Mexico">Mexico</option>
                    <option value="Midway Islands">Midway Islands</option>
                    <option value="Moldova">Moldova</option>
                    <option value="Monaco">Monaco</option>
                    <option value="Mongolia">Mongolia</option>
                    <option value="Montserrat">Montserrat</option>
                    <option value="Morocco">Morocco</option>
                    <option value="Mozambique">Mozambique</option>
                    <option value="Myanmar">Myanmar</option>
                    <option value="Nambia">Nambia</option>
                    <option value="Nauru">Nauru</option>
                    <option value="Nepal">Nepal</option>
                    <option value="Netherland Antilles">Netherland Antilles</option>
                    <option value="Netherlands">Netherlands</option>
                    <option value="Nevis">Nevis</option>
                    <option value="New Caledonia">New Caledonia</option>
                    <option value="New Zealand">New Zealand</option>
                    <option value="Nicaragua">Nicaragua</option>
                    <option value="Niger">Niger</option>
                    <option value="Nigeria">Nigeria</option>
                    <option value="Niue">Niue</option>
                    <option value="Norfolk Island">Norfolk Island</option>
                    <option value="Norway">Norway</option>
                    <option value="Oman">Oman</option>
                    <option value="Pakistan">Pakistan</option>
                    <option value="Palau Island">Palau Island</option>
                    <option value="Palestine">Palestine</option>
                    <option value="Panama">Panama</option>
                    <option value="Papua New Guinea">Papua New Guinea</option>
                    <option value="Paraguay">Paraguay</option>
                    <option value="Peru">Peru</option>
                    <option value="Philippines">Philippines</option>
                    <option value="Pitcairn Island">Pitcairn Island</option>
                    <option value="Poland">Poland</option>
                    <option value="Portugal">Portugal</option>
                    <option value="Puerto Rico">Puerto Rico</option>
                    <option value="Qatar">Qatar</option>
                    <option value="Reunion">Reunion</option>
                    <option value="Romania">Romania</option>
                    <option value="Russia">Russia</option>
                    <option value="Rwanda">Rwanda</option>
                    <option value="St Barthelemy">St Barthelemy</option>
                    <option value="St Eustatius">St Eustatius</option>
                    <option value="St Helena">St Helena</option>
                    <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                    <option value="St Lucia">St Lucia</option>
                    <option value="St Maarten">St Maarten</option>
                    <option value="St Pierre and Miquelon">St Pierre and Miquelon</option>
                    <option value="St Vincent and Grenadines">St Vincent and Grenadines</option>
                    <option value="Saipan">Saipan</option>
                    <option value="Samoa">Samoa</option>
                    <option value="Samoa American">Samoa American</option>
                    <option value="San Marino">San Marino</option>
                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                    <option value="Saudi Arabia">Saudi Arabia</option>
                    <option value="Senegal">Senegal</option>
                    <option value="Seychelles">Seychelles</option>
                    <option value="Serbia and Montenegro">Serbia and Montenegro</option>
                    <option value="Sierra Leone">Sierra Leone</option>
                    <option value="Singapore">Singapore</option>
                    <option value="Slovakia">Slovakia</option>
                    <option value="Slovenia">Slovenia</option>
                    <option value="Solomon Islands">Solomon Islands</option>
                    <option value="Somalia">Somalia</option>
                    <option value="South Africa">South Africa</option>
                    <option value="Spain">Spain</option>
                    <option value="Sri Lanka">Sri Lanka</option>
                    <option value="Sudan">Sudan</option>
                    <option value="Suriname">Suriname</option>
                    <option value="Swaziland">Swaziland</option>
                    <option value="Sweden">Sweden</option>
                    <option value="Switzerland">Switzerland</option>
                    <option value="Syria">Syria</option>
                    <option value="Tahiti">Tahiti</option>
                    <option value="Taiwan">Taiwan</option>
                    <option value="Tajikistan">Tajikistan</option>
                    <option value="Tanzania">Tanzania</option>
                    <option value="Thailand">Thailand</option>
                    <option value="Togo">Togo</option>
                    <option value="Tokelau">Tokelau</option>
                    <option value="Tonga">Tonga</option>
                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                    <option value="Tunisia">Tunisia</option>
                    <option value="Turkey">Turkey</option>
                    <option value="Turkmenistan">Turkmenistan</option>
                    <option value="Turks and Caicos Is">Turks and Caicos Is</option>
                    <option value="Tuvalu">Tuvalu</option>
                    <option value="Uganda">Uganda</option>
                    <option value="Ukraine">Ukraine</option>
                    <option value="United Arab Emirates">United Arab Emirates</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="United States of America">United States of America</option>
                    <option value="Uruguay">Uruguay</option>
                    <option value="Uzbekistan">Uzbekistan</option>
                    <option value="Vanuatu">Vanuatu</option>
                    <option value="Vatican City State">Vatican City State</option>
                    <option value="Venezuela">Venezuela</option>
                    <option value="Vietnam">Vietnam</option>
                    <option value="Virgin Islands (Brit)">Virgin Islands Brit</option>
                    <option value="Virgin Islands (USA)">Virgin Islands USA</option>
                    <option value="Wake Island">Wake Island</option>
                    <option value="Wallis and Futana Is">Wallis and Futana Is</option>
                    <option value="Yemen">Yemen</option>
                    <option value="Zaire">Zaire</option>
                    <option value="Zambia">Zambia</option>
                    <option value="Zimbabwe">Zimbabwe</option>
                  </select></td>
                  <td width="33%"><input name="state" type="text" class="formFields" id="state" value="<?php echo $state; ?>" style="width:99%" maxlength="24" /></td>
                  <td width="33%"><input name="city" type="text" class="formFields" id="city" value="<?php echo $city; ?>" style="width:99%" maxlength="24" /></td>
                </tr>
            </table></td>
            <td width="56" valign="top"><input name="updateBtn2" type="submit" id="updateBtn2" value="Update" />
              <input name="parse_var" type="hidden" value="location" />
            <input name="thisWipit" type="hidden" value="<?php echo $thisRandNum; ?>" /></td>
          </tr>
        </form>
      </table>
      </div>
     <!-- -->
      <div class="boxHeader">
      <a href="#" onclick="return false" onmousedown="javascript:toggleSlideBox('linksBox');">
      <img src="images/toggleBtn1.png" alt="Toggle" width="22" height="30" border="0" style="position:relative; top:6px;" /> <h2>Links and API Connections</h2>
      </a>
      </div>
     <div class="editBox" id="linksBox">
      <table width="700" align="center" cellpadding="10" cellspacing="0" style="border:#999 1px solid; background-color:#FBFBFB;">
        <form action="edit_profile.php" method="post" enctype="multipart/form-data">
        <tr>
          <td width="111">Your Website: <span class="brightRed">*</span></td>
          <td width="471"><strong>http://</strong>
            <input name="website" type="text" class="formFields" id="website" value="<?php echo $website; ?>" size="36" maxlength="32" /></td>
          <td width="56" rowspan="3" valign="top"><input name="updateBtn3" type="submit" id="updateBtn3" value="Update" />
            <input name="parse_var" type="hidden" value="links" />
            <input name="thisWipit" type="hidden" value="<?php echo $thisRandNum; ?>" /></td>
        </tr>
        <tr>
          <td>Youtube Channel: <span class="brightRed">*</span></td>
          <td><strong>http://www.youtube.com/user/</strong>
            <input name="youtube" type="text" class="formFields" id="youtube" value="<?php echo $youtube; ?>" size="20" maxlength="40" /></td>
          </tr>
        <tr>
          <td>Facebook ID:<span class="brightRed"> *</span></td>
          <td><strong>http://www.facebook.com/profile.php?id=</strong>
            <input name="facebook" type="text" class="formFields" id="facebook" value="<?php echo $facebook; ?>" size="20" maxlength="40" /></td>
          </tr>
        <tr>
          <td>Twitter Username:<span class="brightRed"> *</span></td>
          <td><strong>http://twitter.com/</strong>
            <input name="twitter" type="text" class="formFields" id="twitter" value="<?php echo $twitter; ?>" size="20" maxlength="40" /></td>
          </tr>
      </form>
    </table>
    </div>
      <!-- -->
    <div class="boxHeader">
      <a href="#" onclick="return false" onmousedown="javascript:toggleSlideBox('bioBox');">
      <img src="images/toggleBtn1.png" alt="Toggle" width="22" height="30" border="0" style="position:relative; top:6px;" /> <h2>Description</h2>
      </a>
      </div>
    <div class="editBox" id="bioBox">
    <table width="700" align="center" cellpadding="10" cellspacing="0" style="border:#999 1px solid; background-color:#FBFBFB;">
      <form action="edit_profile.php" method="post" enctype="multipart/form-data">
        <tr>
          <td width="602" valign="top"><textarea name="bio_body" cols="" rows="3" class="formFields" style="width:80%;"><?php echo $bio_body; ?></textarea></td>
          <td width="56" valign="top"><input name="updateBtn4" type="submit" id="updateBtn4" value="Update" />
            <input name="parse_var" type="hidden" value="bio" />
            <input name="thisWipit" type="hidden" value="<?php echo $thisRandNum; ?>" /></td>
          </tr>
      </form>
    </table>
    </div>
    <!-- -->
    <div class="boxHeader">
      <a href="#" onclick="return false" onmousedown="javascript:toggleSlideBox('emailalertBox');">
      <img src="images/toggleBtn1.png" alt="Toggle" width="22" height="30" border="0" style="position:relative; top:6px;" /> <h2>Privacy and Email Alert Settings</h2>
      </a>
      </div>
    <div class="editBox" id="emailalertBox">
    <table width="700" align="center" cellpadding="10" cellspacing="0" style="border:#999 1px solid; background-color:#FBFBFB;">
        <tr>
          <td width="602" valign="top">This section is going to be added in a future version. We are doing away with the edit_settings.php page and integrating those functions on this page to keep things tidy.</td>
       </tr>
    </table>
    </div>   
    <!-- -->
    <div class="boxHeader">
      <a href="#" onclick="return false" onmousedown="javascript:toggleSlideBox('emailBox');">
      <img src="images/toggleBtn1.png" alt="Toggle" width="22" height="30" border="0" style="position:relative; top:6px;" /> <h2>Account Settings</h2>
      </a>
      </div>
    <div class="editBox" id="emailBox">
    <table width="700" align="center" cellpadding="10" cellspacing="0" style="border:#999 1px solid; background-color:#FBFBFB;">
        <tr>
          <td width="602" valign="top">This section is going to be added in a future version. We are doing away with the edit_settings.php page and integrating those functions on this page to keep things tidy.</td>
       </tr>
    </table>
    </div>
    <br />
    <p align="center" style="font-size:16px"><strong><a href="index.php">Go to Main Panel</a></strong></p><br /></td>
  </tr>
</table>

</body>
</html>

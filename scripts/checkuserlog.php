<?php
/* Web Intersect Social Network Template System and CMS v1.34
 * Copyright (c) 2011 Adam Khoury
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
session_start(); // Start Session First Thing
// Force script errors and warnings to show on page in case php.ini file is set to not display them
error_reporting(E_ALL);
ini_set('display_errors', '1');
//-----------------------------------------------------------------------------------------------------------------------------------
include_once "conn.php"; // Connect to the database
$dyn_www = $_SERVER['HTTP_HOST']; // Dynamic www.domainName available now to you in all of your scripts that include this file
//------ CHECK IF THE USER IS LOGGED IN OR NOT AND GIVE APPROPRIATE OUTPUT -------
$logOptions = ''; // Initialize the logOptions variable that gets printed to the page
// If the session variable and cookie variable are not set this code runs
if (!isset($_SESSION['idx'])) { 
  if (!isset($_COOKIE['idCookie'])) {
     $logOptions = '<a href="http://' . $dyn_www . '/register.php">Register Account</a>
	 &nbsp;&nbsp; | &nbsp;&nbsp; 
	 <a href="http://' . $dyn_www . '/login.php">Log In</a>';
   }
}
// If session ID is set for logged in user without cookies remember me feature set
if (isset($_SESSION['idx'])) { 
    
	$decryptedID = base64_decode($_SESSION['idx']);
	$id_array = explode("p3h9xfn8sq03hs2234", $decryptedID);
	$logOptions_id = $id_array[1];
    //$logOptions_username = $_SESSION['username'];
    //$logOptions_username = substr('' . $logOptions_username . '', 0, 15); // cut user name down in length if too long
	

} else if (isset($_COOKIE['idCookie'])) {// If id cookie is set, but no session ID is set yet, we set it below and update stuff
	
	$decryptedID = base64_decode($_COOKIE['idCookie']);
	$id_array = explode("nm2c0c4y3dn3727553", $decryptedID);
	$userID = $id_array[1]; 
	$userPass = $_COOKIE['passCookie'];
	// Get their user first name to set into session var
    $sql_uname = mysql_query("SELECT username, email FROM member WHERE id='$userID' AND password='$userPass' LIMIT 1");
	$numRows = mysql_num_rows($sql_uname);
	if ($numRows == 0) {
		// Kill their cookies and send them back to homepage if they have cookie set but are not a member any longer
		setcookie("idCookie", '', time()-42000, '/');
	    setcookie("passCookie", '', time()-42000, '/');
		header("location: index.php"); // << makes the script send them to any page we set
		exit();
	}
    while($row = mysql_fetch_array($sql_uname)){ 
	    $username = $row["username"];
		$useremail = $row["email"];
	}

    $_SESSION['id'] = $userID; // now add the value we need to the session variable
	$_SESSION['idx'] = base64_encode("g4p3h9xfn8sq03hs2234$userID");
    $_SESSION['username'] = $username;
	$_SESSION['useremail'] = $useremail;
	$_SESSION['userpass'] = $userPass;

    $logOptions_id = $userID;
    //$logOptions_uname = $username;
    //$logOptions_uname = substr('' . $logOptions_uname . '', 0, 15); 
    ///////////          Update Last Login Date Field       /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    mysql_query("UPDATE member SET last_log_date=now() WHERE id='$logOptions_id'"); 
    // Ready the output for this logged in user
    // Check if this user has any new PMs and construct which envelope to show
	$sql_pm_check = mysql_query("SELECT id FROM private_messages WHERE to_id='$logOptions_id' AND opened='0' LIMIT 1");
	$num_new_pm = mysql_num_rows($sql_pm_check);
	if ($num_new_pm > 0) {
		$PM_envelope = '<a href="pm_inbox.php"><img src="../images/pm2.gif" width="18" height="11" alt="PM" border="0"/></a>';
	} else {
		$PM_envelope = '<a href="pm_inbox.php"><img src="../images/pm1.gif" width="18" height="11" alt="PM" border="0"/></a>';
	}
	// Ready the output for this logged in user
     $logOptions = $PM_envelope . ' &nbsp; &nbsp;
	 <!--<a href="http://' . $dyn_www . '">Home</a>
	&nbsp;&nbsp; |&nbsp;&nbsp; -->
	 <a href="http://' . $dyn_www . '/profile.php?id=' . $logOptions_id . '">Profile</a>
	&nbsp;&nbsp; |&nbsp;&nbsp;
';
}
?>
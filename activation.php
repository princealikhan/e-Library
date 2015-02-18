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
// If the GET variable id is not empty, we run this script, if variable is empty we give message at bottom
// Force script errors and warnings to show on page in case php.ini file is set to not display them
error_reporting(E_ALL);
ini_set('display_errors', '1');
//-----------------------------------------------------------------------------------------------------------------------------------
if ($_GET['id'] != "") {
	
    //Connect to the database through an include 
    include_once "scripts/conn.php";

    $id = $_GET['id']; 
    $hashpass = $_GET['sequence']; 

    $id  = mysql_real_escape_string($id );
    $id = eregi_replace("`", "", $id);

    $hashpass = mysql_real_escape_string($hashpass);
    $hashpass = eregi_replace("`", "", $hashpass);

    $sql = mysql_query("UPDATE member SET email_activated='1' WHERE id='$id' AND password='$hashpass'"); 

    $sql_doublecheck = mysql_query("SELECT * FROM myMembers WHERE id='$id' AND password='$hashpass' AND email_activated='1'"); 
    $doublecheck = mysql_num_rows($sql_doublecheck); 

    if($doublecheck == 0){ 
        $msgToUser = "<br /><br /><h3><strong><font color=red>Your account could not be activated!</font></strong><h3><br />
        <br />
        Please email site administrator and request manual activation.
        "; 
    include 'msgToUser.php'; 
	exit();
    } elseif ($doublecheck > 0) { 

        $msgToUser = "<br /><br /><h3><font color=\"#0066CC\"><strong>Your account has been activated! <br /><br />
        Log In anytime up top.</strong></font></h3>";
	
    include 'msgToUser.php'; 
	exit();
} 

} // close first if

print "Essential data from the activation URL is missing! Close your browser, go back to your email inbox, and please use the full URL supplied in the activation link we sent you.<br />
<br />
admin@yourdomain.com
";
?>
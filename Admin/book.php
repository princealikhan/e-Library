



<?php	 
  include "../scripts/conn.php";

  
 

$errorMsg='';	
$thisRandNum='';
$user_pic = "";
	if (isset($_POST['Submit'])) {

 $b_name = preg_replace('#[^A-Za-z0-9]#i', '', $_POST['b_name']); // filter everything but letters and numbers
 $b_author = preg_replace('#[^A-Za-z0-9]#i', '', $_POST['b_author']); // filter everything but letters and numbers
 $b_publisher = preg_replace('#[^A-Za-z0-9]#i', '', $_POST['b_publisher']); // filter everything but letters and numbers
 $b_quantity = preg_replace('#[^0-9]#i', '', $_POST['b_quantity']); // filter everything but letters and numbers
 $c_name = $_POST['c_name']; 
  
// convert b_cat to c_id
 $sql=mysql_query("SELECT c_id FROM b_cate WHERE c_name='$c_name'");
 while($row=mysql_fetch_array($sql)){
$b_cat=$row["c_id"];
}
    
 $errorMsg="";
     // Error handling for missing data
     if ((!$b_cat)||(!$b_name)  || (!$b_author) || (!$b_publisher) || (!$b_quantity)|| (!$c_name)) { 

     $errorMsg = 'ERROR: You did not submit the following required information:<br /><br />';
   if(!$b_cat){ 
       $errorMsg .= ' * Please Enter book name<br />';

     } 
     if(!$b_name){ 
       $errorMsg .= ' * Please Enter book name<br />';

     } 
     if(!$b_author){ 
       $errorMsg .= ' * Please Enter Author Name<br />';
     } 	
	 if(!$b_publisher){ 
       $errorMsg .= ' * Please Enter Publisher Name<br />';      
     }
	 if(!$b_quantity){ 
       $errorMsg .= ' * Please Mention b_quantity.<br />';        
 if(!$c_name){ 
       $errorMsg .= ' * Please Mention c_name.<br />'; }
     } 
     ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
     // Add user info into the database table for the main site table

} else {

// ------- PARSING PICTURE UPLOAD ---------


    
mysql_query("INSERT INTO book VALUES ('', '$b_cat', '$b_name', '$b_author', '$b_publisher','$b_quantity')");
  $id = mysql_insert_id();
mkdir("books/$id", 0755);
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
                        $newname =$id.".jpg";
                        $place_file = move_uploaded_file( $_FILES['fileField']['tmp_name'], "books/$id/".$newname);
            }
    } 
}
echo "Data enter successfully";
}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<me0ta name="Description" content="Register to yourdomain" />
<meta name="Keywords" content="register, yourdomain" />
<meta name="rating" content="General" />
<title>book</title>
<link href="main.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script src="js/jquery-1.4.2.js" type="text/javascript"></script>

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

<h2 align="center" style="margin-left:80px;">Book Entry</h2>

      <table width="600" align="center" cellpadding="8" cellspacing="0" style="border:#999 1px solid; background-color:#FBFBFB;">
        <form action="book.php" method="post" enctype="multipart/form-data">
          <tr>
            <td align="left" colspan="2"><?php print $errorMsg; ?>			</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><div align="left">Categories:<span class="brightRed"> *</span></div></td>
            <td bgcolor="#FFFFFF"><div align="left">
              <select name="c_name" id="c_name">
                <?php 
 include "conn.php";
$string='';
$sql=mysql_query("SELECT c_name FROM b_cate");
 while($row=mysql_fetch_array($sql)){
$c_name=$row["c_name"];
$string.="<option>".$c_name."</option>";
}
echo $string;
?>
              </select>
            </div></td>
          </tr>
          <tr>

            <td width="114" bgcolor="#FFFFFF"><div align="left">Book Name:<span class="brightRed"> *</span></div></td>
            <td width="452" bgcolor="#FFFFFF"><div align="left">
              <input name="b_name" type="text" class="formFields" id="b_name" value="" size="32" maxlength="20" />
              <span id="nameresponse"><span class="textSize_9px"><span class="greyColor">Alphanumeric Characters Only</span></span></span></div></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><div align="left">Book Author:<span class="brightRed"> *</span></div></td>
            <td bgcolor="#FFFFFF"><div align="left">
              <input name="b_author" type="text" class="formFields" id="b_author" value="" size="32" maxlength="20" />
              <span id="nameresponse2"><span class="textSize_9px"><span class="greyColor">Alphanumeric Characters Only</span></span></span></div></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><div align="left">Book Publisher:<span class="brightRed"> *</span></div></td>
            <td bgcolor="#FFFFFF"><div align="left">
              <input name="b_publisher" type="text" class="formFields" id="b_publisher"  size="32" maxlength="20" />
            </div></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><div align="left">Book Quantity:<span class="brightRed"> *</span></div></td>
            <td bgcolor="#FFFFFF"><div align="left">
              <input name="b_quantity" type="text" class="formFields" id="b_quantity" value="" size="32" maxlength="20" />
            </div></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><div align="left"><?php echo $user_pic; ?></div></td>
            <td bgcolor="#FFFFFF"><div align="left">
              <input name="fileField" type="file" class="formFields" id="fileField" size="42" />
              50 kb max
  <input name="thisWipit" type="hidden" value="<?php echo $thisRandNum; ?>" />
              <input name="parse_var" type="hidden" value="pic" />
            </div></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">
            <td align="left" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="Submit" id="Submit" />
        </form>
      </table>
<br />
      <br /></td>
    <td width="160" valign="top"></td>
  </tr>
</table>

<img name="" src="" width="32" height="32" alt="" />
</body>
</html>
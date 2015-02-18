<?php

include 'scripts/config.php';


if(!isSet($_SESSION['id'])){
header("Location: login.php");
exit;
}
else{
$id=$_SESSION['id'];

}
 
include "header.php";
$sponsors='';
$id = "";
$check="";
$username = "";
$firstname = "";
$lastname = "";
$mainNameLine = "";
$country = "";	
$state = "";
$city = "";
$zip = "";
$bio_body = "";
$website = "";
$youtube = "";
$facebook = "";
$twitter = "";
$twitterWidget = "";
$locationInfo = "";
$user_pic = "";
$blabberDisplayList = "";
$interactionBox = "";
$cacheBuster = rand(999999999,9999999999999); // Put on an image URL will help always show new when changed

// ------- END INITIALIZE SOME VARIABLES ---------
include "scripts/conn.php";
  // SQL - Collect username for Recipient 
  $id=$_SESSION['id'];

    $sql = mysql_query("SELECT * FROM member WHERE id='$id' LIMIT 1");
while($row = mysql_fetch_array($sql)){ 
    $username = $row["username"];
	$firstname = $row["firstname"];
	$lastname = $row["lastname"];
	$country = $row["country"];	
	$state = $row["state"];
	$city = $row["city"];
	$sign_up_date = $row["sign_up_date"];
    $sign_up_date = strftime("%b %d, %Y", strtotime($sign_up_date));
	$last_log_date = $row["last_log_date"];
    $last_log_date = strftime("%b %d, %Y", strtotime($last_log_date));	
	$bio_body = $row["bio_body"];	
	$bio_body = str_replace("&amp;#39;", "'", $bio_body);
	$bio_body = stripslashes($bio_body);
	$website = $row["website"];
	$youtube = $row["youtube"];
	$facebook = $row["facebook"];
	$twitter = $row["twitter"];
	$friend_array = $row["friend_array"];
	///////  Mechanism to Display Pic. See if they have uploaded a pic or not  //////////////////////////
	$check_pic = "members/$id/$id.jpg";
	$default_pic = "members/0/image01.png";
	if (file_exists($check_pic)) {
    $user_pic = "<img src=\"$check_pic?$cacheBuster\" width=\"195px\" />"; 
	} else {
	$user_pic = "<img src=\"$default_pic\" width=\"190px\" />"; 
	}
	///////  Mechanism to Display Real Name Next to Username - real name(username) //////////////////////////
	if ($firstname != "" && $lastname != "") {
        $mainNameLine = "$firstname $lastname";
		$username = $firstname;
	} else {
		$mainNameLine = $username;
	}
	///////  Mechanism to Display Youtube channel link or not  //////////////////////////
	if ($youtube == "") {
    $youtube = "";
	} else {
	$youtube = '<br /><br /><img src="images/youtubeIcon.jpg" width="18" height="12" alt="Youtube Channel for ' . $username . '" /> <strong>YouTube Channel:</strong><br /><a href="http://www.youtube.com/user/' . $youtube . '" target="_blank">youtube.com/' . $youtube . '</a>';
	}
    ///////  Mechanism to Display Facebook Profile link or not  //////////////////////////
	if ($facebook == "") {
    $facebook = "";
	} else {
	$facebook = '<br /><br /><img src="images/facebookIcon.jpg" width="18" height="12" alt="Facebook Profile for ' . $username . '" /> <strong>Facebook Profile:</strong><br /><a href="http://www.facebook.com/profile.php?id=' . $facebook . '" target="_blank">profile.php?id=' . $facebook . '</a>';
	}
    ///////  Mechanism to Display Website URL or not  //////////////////////////
	if ($website == "") {
    $website = "";
	} else {
	$website = '<br /><br /><img src="images/websiteIcon.jpg" width="18" height="12" alt="Website URL for ' . $username . '" /> <strong>Website:</strong><br /><a href="http://' . $website . '" target="_blank">' . $website . '</a>'; 
	}
	///////  Mechanism to Display About me text or not  //////////////////////////
	if ($bio_body == "") {
    $bio_body = "";
	} else {
	$bio_body = '<div class="infoBody">' . $bio_body . '</div>'; 
	}
	///////  Mechanism to Display Location Info or not  //////////////////////////
	if ($country == "" && $state == "" && $city == "") {
    $locationInfo = "";
	} else {
	$locationInfo = "$city &middot; $state<br />$country ".'<a href="#" onclick="return false" onmousedown="javascript:toggleViewMap(\'google_map\');">view map</a>'; 
	}
} // close while loop





  ?>
  
       
  
  <?php	 
include "scripts/conn.php";
$b_cat='';
if (isset($_POST['Submit'])) {
$c_name = $_POST['c_name']; 

//c_name converted to c_id
$sql=mysql_query("SELECT c_id FROM b_cate WHERE c_name='$c_name'");
while($row=mysql_fetch_array($sql)){
$b_cat=$row["c_id"];}
}
?>
<?php
$ava="";
$sql=mysql_query("SELECT * FROM book WHERE c_id='$b_cat'");
while($row=mysql_fetch_array($sql)){
$b_id=$row['b_id'];
$a=$b_id;
$ava=$row['b_quantity'];
$b_name=$row["b_name"];

$check="";

//$check="<input type=checkbox name='check_list[]' value=.$a.>";
// echo "< INPUT TYPE=CHECKBOX NAME='delete' VALUE=$theVal>";
$sponsors[]=array($a,$b_name,$a,$ava);
}
?>
 
 <div  class ="text1"><marquee>Welcome To Hindustan Institute of Engineering Technology E-Library Student Portal.!
  </marquee></div>
    </div>
    
<br />
	<!-- This clearing element should immediately follow the #mainContent div in order to force the #container div to contain all child floats -->
  <p><div class="container">
    <div class="right">
      <div id="mainContentR" class="tabs-content">
        <p class="text2"> <span style="font-size:16px; font-weight:800;">Hello, <?php echo $mainNameLine; ?></span></font></p>
        <br />
         
          <div id="" class="text2">
            <div id="pageContent" class="text2">
              <form action="books.php" method="post" >
                <p>
                  <select name="c_name" id="c_name">
                    <?php 
include "scripts/conn.php";
$string='';
$sql=mysql_query("SELECT c_name FROM b_cate");
 while($row=mysql_fetch_array($sql)){
$c_name=$row["c_name"];
$string.="<option>".$c_name."</option>";
}
echo $string;
?>
                  </select>
                  <input class="uiButton"type="submit" name="Submit" value="Search" id="Submit" />
                </p>
              </form>
            </div>
          
            <br/>
            <div id="div">
              <div class="sponsorListHolder">
               <form action="books.php" method="post">
               <div>
               
                <?php
			
			// Looping through the array:
			if(empty($sponsors))
{echo"<p class =text2>Please select any category.......</p><br>";}
else
{
			foreach($sponsors as $company)
			{
				
				echo'

				<div class="sponsor" title="Click to flip">
					<div class="sponsorFlip">
						<img src="books/'.$company[0].'/'.$company[0].'.jpg" alt="'.$company[0].'" />
											</div>
					
					<div class="sponsorData">
						<div class="sponsorDescription">
						<center>	'.$company[1].'</center>
						</div>
						
						
						<div class="sponsorURL">
							<div style="padding:0;">
							<input type="checkbox" name="check_list[]" value="'.$company[2].'">
<label for="checkbox">Check for select</label></div>
<div class="sponsorDescription">
						<center>Available	'.$company[3].'</center>
						</div>
						</div>
					</div>
				</div>
							
				';
				      
    
	}
}

if(!empty($_POST['check_list'])) {
    foreach($_POST['check_list'] as $check) {
     
     $sql = mysql_query("INSERT INTO booking (bk_id,u_id, b_id, d_booking) 
     VALUES('0','$id','$check',now())")  
     or die (mysql_error());

echo "Thanks for Booking Your book no  is "; echo $check;
echo"<BR>";
echo "Remember when you go for collection your stuffs from library tell them you pre-booked & my booking id is ";
echo $check;
   

}
	}

	
$sql=mysql_query("SELECT b_quantity FROM book WHERE b_id='$check'");
 while($row=mysql_fetch_array($sql)){
$zzz=$row["b_quantity"];
$zzz=$zzz-1;

 $sqlUpdate = mysql_query("UPDATE book SET b_quantity='$zzz' WHERE b_id='$check'");



}

		?>
                


</div>
   
        
  <input type="submit" class="uiButton" value="Book Now!" />

</form> 
      
               <div class="clear"></div>
              </div>
            </div>
            <!-- end #mainContent -->
          </div>
      </div>
      
  </div>
    <div class="left">
      <div id="mainContent" class="tabs-content">
         <div id="pageContent2" class="text2"><?php echo $user_pic; ?> <?php echo $bio_body; ?>
           <div class="infoHeader"><?php echo $username; ?>'s Information</div>
           <div class="infoBody"> <?php echo $locationInfo; ?> <?php echo $website; ?> <?php echo $youtube; ?> <?php echo $facebook; ?> </div>
           <div class="infoBody" style="border-bottom:#999 1px solid;"></div>
         </div>
</div></div>
</div>&nbsp;</p>
  <?php
  include "footer.php";?>
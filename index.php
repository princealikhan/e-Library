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
$id = "";
$gender="";
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
	$gender=$row["gender"];
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
	
	///////  Mechanism to Display Mr. & Mrs.  //////////////////////////
	if ($gender == "m") {
    $sex="Mr.";
	} else {
    $sex="Mrs.";
	}
	///////  Mechanism to Display Location Info or not  //////////////////////////
	if ($country == "" && $state == "" && $city == "") {
    $locationInfo = "";
	} else {
	$locationInfo = "$city &middot; $state<br />$country ".'<a href="#" onclick="return false" onmousedown="javascript:toggleViewMap(\'google_map\');">view map</a>'; 
	}
} // close while loop





  ?>
  
  <script>








$(document).ready(function(){

	setInterval(function(){

		// Selecting only the visible layers:
		var versions = $('.textVersion:visible');
		
		if(versions.length<2){
			// If only one layer is visible, show the other
			$('.textVersion').fadeIn(800);
		}
		else{
			// Hide the upper layer
			versions.eq(0).fadeOut(800);
		}
	},1000);

});

var default_content="";

$(document).ready(function(){
	
	checkURL();
	$('ul li a').click(function (e){

			checkURL(this.hash);

	});
	
	//filling in the default content
	default_content = $('#pageContent').html();
	
	
	setInterval("checkURL()",250);
	
});

var lasturl="";

function checkURL(hash)
{
	if(!hash) hash=window.location.hash;
	
	if(hash != lasturl)
	{
		lasturl=hash;
		
		// FIX - if we've used the history buttons to return to the homepage,
		// fill the pageContent with the default_content
		
		if(hash=="")
		$('#pageContent').html(default_content);
		
		else
		loadPage(hash);
	}
}


function loadPage(url)
{
	url=url.replace('#page','');
	
	$('#loading').css('visibility','visible');
	
	$.ajax({
		type: "POST",
		url: "load_page.php",
		data: 'page='+url,
		dataType: "html",
		success: function(msg){
			
			if(parseInt(msg)!=0)
			{
				$('#pageContent').html(msg);
				$('#loading').css('visibility','hidden');
			}
		}
		
	});

}
</script>
  
  
 <div  class ="text1"><marquee>Welcome To Hindustan Institute of Engineering Technology E-Library Student Portal.!
  </marquee></div>
    </div><br />
	<!-- This clearing element should immediately follow the #mainContent div in order to force the #container div to contain all child floats -->
<div class="container">
    <div class="right">
      <div id="mainContentR" class="tabs-content">
        <p class="text2"> <span style="font-size:16px; font-weight:800;"><i>Hi,</i></br> <?php echo $sex?> <?php echo $mainNameLine; ?></span></font></p>
        <br />
        <div class="text2">
        	       <div id="pageContent2" class="text2">

          <p class="text2">
     
 
     
     <a href="#page2" class="googlebtn middle">Intro Video</a>
      <a href="#page3" class="googlebtn middle">Developer</a><img id="loading" src="img/ajax_load.gif" alt="loading" /> <br />
    </div>
          </p>
          <div id="pageContent" class="text2"> Hello, Please click on above tab to see Contents..</div>
          <br />
          <br/>
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
</div>  <?php
  include "footer.php";?>
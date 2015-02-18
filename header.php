


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><link rel="icon" href="../Master/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="../Master/favicon.ico" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Welcome</title>

<style type="text/css"> 
<!-- 
body  {
	font: 100% Verdana, Arial, Helvetica, sans-serif;
	background: #666666;
	margin: 0; /* it's good practice to zero the margin and padding of the body element to account for differing browser defaults */
	padding: 0;
	text-align: center; /* this centers the container in IE 5* browsers. The text is then set to the left aligned default in the #container selector */
	color: #000000;
}

.right {
margin-top: 0;
	margin-right: 0.4em;
	margin-bottom: 0;
	margin-left: 0.1em;
	width: 77%;
    float: right;
		margin-left:10px;

}

.left {
    float: none; /* not needed, just for clarification */
    /* the next props are meant to keep this block independent from the other floated one */
    width: auto;
    overflow: hidden;
	margin-top: 0;
	margin-right: 0.4em;
	margin-bottom: 0;
	margin-left: 0.1em;
	width: 21%;

}​​
			.container {
   height: auto;
   overflow: hidden;
}
/* Tips for Elastic layouts 
1. Since the elastic layouts overall sizing is based on the user's default fonts size, they are more unpredictable. Used correctly, they are also more accessible for those that need larger fonts size since the line length remains proportionate.
2. Sizing of divs in this layout are based on the 100% font size in the body element. If you decrease the text size overall by using a font-size: 80% on the body element or the #container, remember that the entire layout will downsize proportionately. You may want to increase the widths of the various divs to compensate for this.
3. If font sizing is changed in differing amounts on each div instead of on the overall design (ie: #sidebar1 is given a 70% font size and #mainContent is given an 85% font size), this will proportionately change each of the divs overall size. You may want to adjust based on your final font sizing.
*/

.twoColElsLtHdr #container { 
	width: 1024px;  /* this width will create a container that will fit in an 800px browser window if text is left at browser default font sizes */
	background: #FFFFFF;
	margin: 0 auto; /* the auto margins (in conjunction with a width) center the page */
	border: 1px solid #000000;
	text-align: left; /* this overrides the text-align: center on the body element. */
} 
.twoColElsLtHdr #header { 
	background: white; 
	padding: 0 0px;  /* this padding matches the left alignment of the elements in the divs that appear beneath it. If an image is used in the #header instead of text, you may want to remove the padding. */
} 
.twoColElsLtHdr #header h1 {
	margin: 0; /* zeroing the margin of the last element in the #header div will avoid margin collapse - an unexplainable space between divs. If the div has a border around it, this is not necessary as that also avoids the margin collapse */
	padding: 10px 0; /* using padding instead of margin will allow you to keep the element away from the edges of the div */
}

/* Tips for sidebar1:
1. Be aware that if you set a font-size value on this div, the overall width of the div will be adjusted accordingly.
2. Since we are working in ems, it's best not to use padding on the sidebar itself. It will be added to the width for standards compliant browsers creating an unknown actual width. 
3. Space between the side of the div and the elements within it can be created by placing a left and right margin on those elements as seen in the ".twoColElsLtHdr #sidebar1 p" rule.
*/
.twoColElsLtHdr #sidebar1 {
	float: left; 
	width: 13.4em; /* since this element is floated, a width must be given */
	/* the background color will be displayed for the length of the content in the column, but no further */
	padding: 13px 0; /* top and bottom padding create visual space within this div */
}
.twoColElsLtHdr #sidebar1 h3, .twoColElsLtHdr #sidebar1 p {
	margin-left: 10px; /* the left and right margin should be given to every element that will be placed in the side columns */
	margin-right: 10px;
        height: 24px;
    }





.twoColElsLtHdr #mainContentL {
	margin-top: 0;
	margin-right: 0.4em;
	margin-bottom: 0;
	margin-left: 0.1em;
	width: 200px;
    
	} 
	.twoColElsLtHdr #mainContentR {
	margin-top: 0;
	margin-right: 0.4em;
	margin-bottom: 0;
	margin-left: 0.1em;
	width: 770px;
    } 
.twoColElsLtHdr #footer { 
	padding: 0 10px; /* this padding matches the left alignment of the elements in the divs that appear above it. */
	background:#DDDDDD;
} 
.twoColElsLtHdr #footer p {
	margin: 0; /* zeroing the margins of the first element in the footer will avoid the possibility of margin collapse - a space between divs */
	padding: 10px 0; /* padding on this element will create space, just as the the margin would have, without the margin collapse issue */
}

/* Miscellaneous classes for reuse */
.fltrt { /* this class can be used to float an element right in your page. The floated element must precede the element it should be next to on the page. */
	float: right;
	margin-left: 8px;
}
.fltlft { /* this class can be used to float an element left in your page */
	float: left;
	margin-right: 8px;
}
.clearfloat { /* this class should be placed on a div or break element and should be the final element before the close of a container that should fully contain a float */
	clear:both;
    height:0;
    font-size: 1px;
    line-height: 0px;
}
--> 
</style>
<link type="text/css" rel="stylesheet" media="all" href="styles/theme.css" />
	<link type="text/css" rel="stylesheet" media="all" href="styles/styles.css" />
	<link type="text/css" rel="stylesheet" media="all" href="style/Common.css" />
    	<link type="text/css" rel="stylesheet" media="all" href="style/Google.css" />
	<link type="text/css" rel="stylesheet" media="all" href="demo.css" />
    <link href="style/styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.flip.min.js"></script>

<script type="text/javascript" src="js/script.js"></script>


</head>

<body class="twoColElsLtHdr">



<br />
<div id="container" class="block-border">
<table width="100%" border="0">
  <tr>
    <td width="506" align="left"><?php include"scripts/day.php"; ?>&nbsp;</td>
  
    <td width="580" align="right"><div align="right"><a href="logout.php">Log Out</a></div></td>
    
  </tr>
</table>
  <div class="block-content dark-bg">
  

    <table width="98%" style="width: 96%;">
        <tr>
              <td width="13%" class="style1"><a href="#link">
                  <img src="./images/logo.png" alt="" 
                      name="" align="right" style="height: 192px; width: 203px" /></a>
            </td>
              <td align="center" class="style2">&nbsp; </td>
              <td align="left"> <a href="index.php"><p class="headertextNew"><font size="+7">HIET</font></p></a>
			  <br/>		 
             <a href="index.php">   <p class="headertextNew">  <font size="+2">Hindustan Institute of Engineering Technology</font></p><br />  <p class="headertext">  <font size="+3">E-Library System </font></p><br /> <p class="headertext">  <font size="+2">Student Portal</font></p></a>
              </td>
      </tr>
    </table>
  
</div>
<div>
<br />
 <div id="">
 <div class="lavalamp dark" >
    <ul>
        <li id="menutext"><a href="index.php">Home</a></li>
        <li id="menutext"><a href="books.php">Book Search</a></li>
                 <li id="menutext"><a href="    <?php
				 if(!isSet($_SESSION['id'])){
header("Location: login.php");
exit;
}
else{
$id=$_SESSION['id'];
$a='edit_profile.php?=';
}
				  echo $a,$id;?>
">Edit Your Profile</a></li>

         <li id="menutext"><a href="panel.php">Mine Panel</a></li>

    </ul>
        <div class=""></div>
    </div></div>
    
  </div>  <div>
  <br /> 
<?php
function date_international ($date_format, $lang = "En", $time=0) {


	if (! $time) $time = time();
	if (! $lang) $lang = "En";
	if (! $date_format) { if ($lang == "En") $date_format = "F, l  Y - h:i A"; else $date_format = "l J F Y - H:i"; }

	$clock = date($date_format, $time);
	return $clock;

}
?>
<?php echo date_international(""); ?>
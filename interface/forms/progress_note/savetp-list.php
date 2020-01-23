<?php

include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");
foreach ($_POST as $k => $var) {
	$_POST[$k] = add_escape_custom($var);
	$b = "$_PO";
//	echo $k."= {{{". $k."}}} ,<br>";
	echo $k."<br>";//just the list
	
	//reason_why='".$_POST["reason_why"]."',
}

// find and replace {{{ with '".$_POST["
// find and replace }}} with "]."'

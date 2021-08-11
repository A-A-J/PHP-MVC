<?php
function getInject($var) {
	$vlink=trim($var);
	$vlink=stripslashes($vlink);
	$vlink=nl2br($vlink);
	$xarray=array (
        "select", "insert", "update", "delet", "great", "drop",
        "grant", "union", "group", "FROM", "where", "limit", "script",
        "order", "by", "\.", "\..", "\...", "\'",
        "<", ">", "%", "\*", "\#", "\;", "\~", "\&",
        "@", "\!", ":", "+", "-", "_", "\(", "\)", "\""
    );
	foreach ($xarray as $danger) {
		if(@preg_match("/$danger/", $vlink)){
            die('No direct script access allowed');
            exit;
		}
	}
	return $var;
}
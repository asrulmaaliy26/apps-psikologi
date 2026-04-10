<?php
/*************************************************************************
php easy :: pagination scripts set - Version One
==========================================================================
Author:      php easy code, www.phpeasycode.com
Web Site:    http://www.phpeasycode.com
Contact:     webmaster@phpeasycode.com
*************************************************************************/
function paginate_one0($reload0, $page0, $tpages0) {
	
	$firstlabel = "&laquo;&nbsp;";
	$prevlabel  = "&lsaquo;&nbsp;";
	$nextlabel  = "&nbsp;&rsaquo;";
	$lastlabel  = "&nbsp;&raquo;";
	
	$out = "<ul class=\"pagination justify-content-center pagination-sm\">";
	
	// first
	if($page0>1) {
		$out.= "<li class=\"page-item\"><a class=\"page-link\" href=\"" . $reload0 . "\">" . $firstlabel . "</a></li>";
	}
	else {
		$out.= "<li class=\"page-item\"><span class=\"page-link\">" . $firstlabel . "</span></li>";
	}
	
	// previous
	if($page0==1) {
		$out.= "<li class=\"page-item\"><span class=\"page-link\">" . $prevlabel . "</span></li>";
	}
	elseif($page0==2) {
		$out.= "<li class=\"page-item\"><a class=\"page-link\" href=\"" . $reload0 . "\">" . $prevlabel . "</a></li>";
	}
	else {
		$out.= "<li class=\"page-item\"><a class=\"page-link\" href=\"" . $reload0 . "&amp;page0=" . ($page0-1) . "\">" . $prevlabel . "</a></li>";
	}
	
	// current
	$out.= "<li class=\"page-item\"><span class=\"page-link\">Page " . $page0 . " of " . $tpages0 ."</span></li>";
	
	// next
	if($page0<$tpages0) {
		$out.= "<li class=\"page-item\"><a class=\"page-link\" href=\"" . $reload0 . "&amp;page0=" .($page0+1) . "\">" . $nextlabel . "</a></li>";
	}
	else {
		$out.= "<li class=\"page-item\"><span class=\"page-link\">" . $nextlabel . "</span></li>";
	}
	
	// last
	if($page0<$tpages0) {
		$out.= "<li class=\"page-item\"><a class=\"page-link\" href=\"" . $reload0 . "&amp;page0=" . $tpages0 . "\">" . $lastlabel . "</a></li>";
	}
	else {
		$out.= "<li class=\"page-item\"><span class=\"page-link\">" . $lastlabel . "</span></li>";
	}
	
	$out.= "</ul>";
	
	return $out;
}
?>
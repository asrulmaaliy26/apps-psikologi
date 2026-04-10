<?php
/*************************************************************************
php easy :: pagination scripts set - Version One
==========================================================================
Author:      php easy code, www.phpeasycode.com
Web Site:    http://www.phpeasycode.com
Contact:     webmaster@phpeasycode.com
*************************************************************************/
function paginate_one2($reload2, $page2, $tpages2) {
	
	$firstlabel = "&laquo;&nbsp;";
	$prevlabel  = "&lsaquo;&nbsp;";
	$nextlabel  = "&nbsp;&rsaquo;";
	$lastlabel  = "&nbsp;&raquo;";
	
	$out = "<ul class=\"pagination justify-content-center pagination-sm\">";
	
	// first
	if($page2>1) {
		$out.= "<li class=\"page-item\"><a class=\"page-link\" href=\"" . $reload2 . "\">" . $firstlabel . "</a></li>";
	}
	else {
		$out.= "<li class=\"page-item\"><span class=\"page-link\">" . $firstlabel . "</span></li>";
	}
	
	// previous
	if($page2==1) {
		$out.= "<li class=\"page-item\"><span class=\"page-link\">" . $prevlabel . "</span></li>";
	}
	elseif($page2==2) {
		$out.= "<li class=\"page-item\"><a class=\"page-link\" href=\"" . $reload2 . "\">" . $prevlabel . "</a></li>";
	}
	else {
		$out.= "<li class=\"page-item\"><a class=\"page-link\" href=\"" . $reload2 . "&amp;page1=" . ($page2-1) . "\">" . $prevlabel . "</a></li>";
	}
	
	// current
	$out.= "<li class=\"page-item\"><span class=\"page-link\">Page " . $page2 . " of " . $tpages2 ."</span></li>";
	
	// next
	if($page2<$tpages2) {
		$out.= "<li class=\"page-item\"><a class=\"page-link\" href=\"" . $reload2 . "&amp;page2=" .($page2+1) . "\">" . $nextlabel . "</a></li>";
	}
	else {
		$out.= "<li class=\"page-item\"><span class=\"page-link\">" . $nextlabel . "</span></li>";
	}
	
	// last
	if($page2<$tpages2) {
		$out.= "<li class=\"page-item\"><a class=\"page-link\" href=\"" . $reload2 . "&amp;page2=" . $tpages2 . "\">" . $lastlabel . "</a></li>";
	}
	else {
		$out.= "<li class=\"page-item\"><span class=\"page-link\">" . $lastlabel . "</span></li>";
	}
	
	$out.= "</ul>";
	
	return $out;
}
?>
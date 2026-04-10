<?php
/*************************************************************************
php easy :: pagination scripts set - Version One
==========================================================================
Author:      php easy code, www.phpeasycode.com
Web Site:    http://www.phpeasycode.com
Contact:     webmaster@phpeasycode.com
*************************************************************************/
function paginate_one1($reload1, $page1, $tpages1) {
	
	$firstlabel = "&laquo;&nbsp;";
	$prevlabel  = "&lsaquo;&nbsp;";
	$nextlabel  = "&nbsp;&rsaquo;";
	$lastlabel  = "&nbsp;&raquo;";
	
	$out = "<ul class=\"pagination justify-content-center pagination-sm\">";
	
	// first
	if($page1>1) {
		$out.= "<li class=\"page-item\"><a class=\"page-link\" href=\"" . $reload1 . "\">" . $firstlabel . "</a></li>";
	}
	else {
		$out.= "<li class=\"page-item\"><span class=\"page-link\">" . $firstlabel . "</span></li>";
	}
	
	// previous
	if($page1==1) {
		$out.= "<li class=\"page-item\"><span class=\"page-link\">" . $prevlabel . "</span></li>";
	}
	elseif($page1==2) {
		$out.= "<li class=\"page-item\"><a class=\"page-link\" href=\"" . $reload1 . "\">" . $prevlabel . "</a></li>";
	}
	else {
		$out.= "<li class=\"page-item\"><a class=\"page-link\" href=\"" . $reload1 . "&amp;page1=" . ($page1-1) . "\">" . $prevlabel . "</a></li>";
	}
	
	// current
	$out.= "<li class=\"page-item\"><span class=\"page-link\">Page " . $page1 . " of " . $tpages1 ."</span></li>";
	
	// next
	if($page1<$tpages1) {
		$out.= "<li class=\"page-item\"><a class=\"page-link\" href=\"" . $reload1 . "&amp;page1=" .($page1+1) . "\">" . $nextlabel . "</a></li>";
	}
	else {
		$out.= "<li class=\"page-item\"><span class=\"page-link\">" . $nextlabel . "</span></li>";
	}
	
	// last
	if($page1<$tpages1) {
		$out.= "<li class=\"page-item\"><a class=\"page-link\" href=\"" . $reload1 . "&amp;page1=" . $tpages1 . "\">" . $lastlabel . "</a></li>";
	}
	else {
		$out.= "<li class=\"page-item\"><span class=\"page-link\">" . $lastlabel . "</span></li>";
	}
	
	$out.= "</ul>";
	
	return $out;
}
?>
<?php
/*************************************************************************
php easy :: pagination scripts set - Version One
==========================================================================
Author:      php easy code, www.phpeasycode.com
Web Site:    http://www.phpeasycode.com
Contact:     webmaster@phpeasycode.com
*************************************************************************/
function paginate_one($reload, $page, $tpages) {
	
	$firstlabel = "&laquo;&nbsp;";
	$prevlabel  = "&lsaquo;&nbsp;";
	$nextlabel  = "&nbsp;&rsaquo;";
	$lastlabel  = "&nbsp;&raquo;";
	
	$out = "<ul class=\"pagination justify-content-center pagination-sm\">";
	
	// first
	if($page>1) {
		$out.= "<li class=\"page-item\"><a class=\"page-link\" href=\"" . $reload . "\">" . $firstlabel . "</a></li>";
	}
	else {
		$out.= "<li class=\"page-item\"><span class=\"page-link\">" . $firstlabel . "</span></li>";
	}
	
	// previous
	if($page==1) {
		$out.= "<li class=\"page-item\"><span class=\"page-link\">" . $prevlabel . "</span></li>";
	}
	elseif($page==2) {
		$out.= "<li class=\"page-item\"><a class=\"page-link\" href=\"" . $reload . "\">" . $prevlabel . "</a></li>";
	}
	else {
		$out.= "<li class=\"page-item\"><a class=\"page-link\" href=\"" . $reload . "&amp;page=" . ($page-1) . "\">" . $prevlabel . "</a></li>";
	}
	
	// current
	$out.= "<li class=\"page-item\"><span class=\"page-link\">Page " . $page . " of " . $tpages ."</span></li>";
	
	// next
	if($page<$tpages) {
		$out.= "<li class=\"page-item\"><a class=\"page-link\" href=\"" . $reload . "&amp;page=" .($page+1) . "\">" . $nextlabel . "</a></li>";
	}
	else {
		$out.= "<li class=\"page-item\"><span class=\"page-link\">" . $nextlabel . "</span></li>";
	}
	
	// last
	if($page<$tpages) {
		$out.= "<li class=\"page-item\"><a class=\"page-link\" href=\"" . $reload . "&amp;page=" . $tpages . "\">" . $lastlabel . "</a></li>";
	}
	else {
		$out.= "<li class=\"page-item\"><span class=\"page-link\">" . $lastlabel . "</span></li>";
	}
	
	$out.= "</ul>";
	
	return $out;
}
?>
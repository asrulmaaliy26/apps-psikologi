<?php
$files = glob("ekspor*.php");
$count = 0;
foreach ($files as $file) {
    $content = file_get_contents($file);
    
    $pattern = '/<\?php\s*header\("Content-type:\s*application\/vnd-ms-excel"\);\s*header\([^\)]+\);\s*\?>/is';
    
    if (preg_match($pattern, $content, $matches)) {
        $header_block = $matches[0];
        
        // Check if it's already before <!DOCTYPE html>
        // We can just check if <!DOCTYPE html> comes AFTER the first header block
        $doctype_pos = stripos($content, "<!DOCTYPE html>");
        $header_pos = strpos($content, "header(\"Content-type");
        
        if ($doctype_pos !== false && $header_pos > $doctype_pos) {
            // Remove the block
            $content = preg_replace($pattern, "", $content, 1);
            
            // Insert it before <!DOCTYPE html>
            $content = str_ireplace("<!DOCTYPE html>", $header_block . "\n<!DOCTYPE html>", $content);
            file_put_contents($file, $content);
            echo "Fixed $file\n";
            $count++;
        }
    } else {
        // sometimes there's no closing tag or it's mixed with other things
        // Let's check manually for header("Content-type: application/vnd-ms-excel");
        // and header('Content-Disposition: attachment; ...');
    }
}
echo "Total fixed: $count\n";
?>

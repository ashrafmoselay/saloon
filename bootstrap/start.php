<?php
/*$response = (bool) @fsockopen("www.google.com", 80);
$is_conn = false;
if($response)
{
    $is_conn = true;
}*/

//if(!$is_conn) {
    //$mac = GetMAC();
   /* $mac = getUniqueMachineID();
    if (file_exists('macAdd.php')) {
        $data = file_get_contents('macAdd.php');
        if ($mac != $data) {
            die('Not Allowed');
        }
    } else {
        file_put_contents( 'macAdd.php', $mac);
    }*/
//}
function getUniqueMachineID($salt = "") {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $temp = "diskpartscript.txt";
        if(!file_exists($temp) && !is_file($temp)) file_put_contents($temp, "select disk 0\ndetail disk");
        $output = shell_exec("diskpart /s ".$temp);
        $lines = explode("\n",$output);
        $result = array_filter($lines,function($line) {
            return stripos($line,"ID:")!==false;
        });
        if(count($result)>0) {
            $result = array_shift(array_values($result));
            $result = explode(":",$result);
            $result = trim(end($result));
        } else $result = $output;
    } else {
        $result = shell_exec("blkid -o value -s UUID");
        if(stripos($result,"blkid")!==false) {
            $result = $_SERVER['HTTP_HOST'];
        }
    }
    return md5($salt.md5($result));
}
function GetMAC(){
    ob_start();
    system('getmac');
    $Content = ob_get_contents();
    ob_clean();
    return substr($Content, strpos($Content,'\\')-20, 17);
}
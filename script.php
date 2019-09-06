<?php

$properties = ['Request: USER ', 'Request: PASS '];

$users = [];
$passwords = [];

$jsons = [];

$file_lines = [];

if ($fh = fopen('export_wireshark_2.txt', 'r')) {
    while (!feof($fh)) {
        $line = fgets($fh);
        array_push($file_lines, $line);
    }
    fclose($fh);
}

for ($i = 0; $i < sizeof($file_lines); $i++) {
    if (strstr( $file_lines[$i], $properties[0])) {
        $userStr = strstr($file_lines[$i], $properties[0]);
        $userArr = explode('USER ', $userStr);
        $user = $userArr[1];
        $user = rtrim($user, "\r\n");
        array_push($users, $user);
    } else if (strstr( $file_lines[$i], $properties[1])) {
        $passStr = strstr($file_lines[$i], $properties[1]);
        $passArr = explode('PASS ', $passStr);
        $pass = $passArr[1];
        $pass = rtrim($pass, "\r\n");
        array_push($passwords, $pass);
    }
}

for($i = 0; $i < sizeof($users); $i++) {
    $jsons[$i] = array($users[$i] => $passwords[$i]);
}

$myjson = json_encode($jsons);
echo $myjson;

file_put_contents ( 'export_wireshark_2.json' , $myjson);
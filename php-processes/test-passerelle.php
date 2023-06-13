<?php
$url = "http://projets-tomcat.isep.fr:8080/appService/?ACTION=GETLOG&TEAM=0G4D";
$data = file_get_contents($url);

$data_tab = str_split($data,33);
echo "Tabular Data:<br />";
for($i=0, $size=count($data_tab); $i<$size - 1; $i++){
    echo "Trame $i: $data_tab[$i]";

    $trame = $data_tab[$i];
// décodage avec des substring
    $t = substr($trame,0,1);
    $o = substr($trame,1,4);

// décodage avec scanf
    list($t, $o, $r, $c, $n, $v, $a, $x, $year, $month, $day, $hour, $min, $sec) =
        sscanf($trame,"%1s%4s%1s%1s%2s%4s%4s%2s%4s%2s%2s%2s%2s%2s");
//    echo(" || $t,$o,$r,$c,$n,$v,$a,$x,$year,$month,$day,$hour,$min,$sec<br />");
    echo(" || Value: " . hexdec($v) . "<br />");
}

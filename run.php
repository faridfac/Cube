<?php

error_reporting(0);
date_default_timezone_set("Asia/Jakarta");

awal:
$getToken =getAllToken();
$data = $getToken['data']['tokens'];
echo "Copy salah satu contract address dibawah: ".PHP_EOL;
sleep(2);
for ($i=0; $i < count($data); $i++) {
    $name = $data[$i]['symbol'];
    $address = $data[$i]['address'];
    echo "[$i] $name $address".PHP_EOL;
}

echo "\n\n";
a:
echo "[+] Contract Address : ";
$taddress = trim(fgets(STDIN));
if(!$taddress){goto a;}

ulang:
echo "[+] File Address: ";
$faddress = trim(fgets(STDIN));

if(!file_exists($faddress)){
    echo "File not found".PHP_EOL;
    goto ulang;
} else if(!$faddress){
    echo "File empty".PHP_EOL;
    goto ulang;
}

echo "\n\n";

$proxy = "p.webshare.io:80";
$proxyauth = "tnfhibvf-rotate:sjihprflr7gf";

$aa = explode("\n", file_get_contents($faddress));

while(true){
  for ($i=0; $i < count($aa); $i++) {
     $address = $acc[$i];
     echo "[$i] Using $address -> ";
     $claim = claimToken($address, $taddress, $proxy, $proxyauth);
     $code = $claim['code'];
     if($code == 0){
         $tx = $claim['data']['transaction-hash'];
         echo "$tx".PHP_EOL;
         sleep(20);
     } else {
         $msg = $claim['message'];
         echo "$msg".PHP_EOL;
     }
  }
  $date = date('H:i:s');
  echo "[$date] Sleep in 1020 seconds".PHP_EOL.PHP_EOL;
  sleep(1020);
}


function claimToken($address, $taddress, $proxy, $proxyauth){
    $ch = curl_init();
    
    $payload = '{"user-address":"'.$address.'","contract-address":"'.$taddress.'","currency-type":"token"}';

    curl_setopt($ch, CURLOPT_URL, 'https://faucet.cube.network/api/faucet/draw');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

    $headers = array();
    $headers[] = 'Host: faucet.cube.network';
    $headers[] = 'Content-Length: '.strlen($payload).'';
    $headers[] = 'Sec-Ch-Ua: ';
    $headers[] = 'Accept-Language: en-US';
    $headers[] = 'Sec-Ch-Ua-Mobile: ?0';
    $headers[] = 'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36';
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Accept: application/json, text/plain, */*';
    $headers[] = 'Yapi: true';
    $headers[] = 'Sec-Ch-Ua-Platform: Linux\"\"';
    $headers[] = 'Origin: https://faucet.cube.network';
    $headers[] = 'Sec-Fetch-Site: same-origin';
    $headers[] = 'Sec-Fetch-Mode: cors';
    $headers[] = 'Sec-Fetch-Dest: empty';
    $headers[] = 'Referer: https://faucet.cube.network/';
    $headers[] = 'Accept-Encoding: gzip, deflate, br';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    $js = json_decode($result, true);
    return $js;
}

function getAllToken(){
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://faucet.cube.network/api/faucet/tokens');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

    $headers = array();
    $headers[] = 'Host: faucet.cube.network';
    $headers[] = 'Sec-Ch-Ua: ';
    $headers[] = 'Accept: application/json, text/plain, */*';
    $headers[] = 'Accept-Language: en-US';
    $headers[] = 'Sec-Ch-Ua-Mobile: ?1';
    $headers[] = 'User-Agent: Mozilla/5.0 (Linux; Android 11; 21061119AG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36';
    $headers[] = 'Yapi: true';
    $headers[] = 'Sec-Ch-Ua-Platform: Android\"\"';
    $headers[] = 'Sec-Fetch-Site: same-origin';
    $headers[] = 'Sec-Fetch-Mode: cors';
    $headers[] = 'Sec-Fetch-Dest: empty';
    $headers[] = 'Referer: https://faucet.cube.network/';
    $headers[] = 'Accept-Encoding: gzip, deflate, br';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    $js = json_decode($result, true);
    
    return $js;
}

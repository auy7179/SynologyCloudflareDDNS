#!/usr/bin/php -d open_basedir=/usr/syno/bin/ddns
<?php

if ($argc !== 5) {
    echo 'badparam';
    exit();
}

$account = (string)$argv[1];
$pwd = (string)$argv[2];
$hostname = (string)$argv[3];
$ip = (string)$argv[4];
$ttl = 1;
$proxied = false;
$recordType = 'A';

// check the hostname contains '.'
if (strpos($hostname, '.') === false) {
    echo 'badparam';
    exit();
}

// only for IPv4 format
if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
    echo "badparam";
    exit();
}

# listing dns
$listDnsURL = "https://api.cloudflare.com/client/v4/zones/$account/dns_records?type=$recordType&name=$hostname";

$listdns = cf_api_call($listDnsURL, 'GET');

if($listdns['success'] != true){
    echo "badparam";
    exit();
}


if(isset($listdns['result'][0])){

    if ($listdns['result'][0]['content'] != $ip) {
      
        # update dns
        $recordID = $listdns['result'][0]['id'];
        $updateDnsURL = "https://api.cloudflare.com/client/v4/zones/$account/dns_records/$recordID";

        $data_update = array(
            'type' => $recordType,
            'name' => $hostname,
            'content' => $ip,
            'ttl' => (int)$ttl,
            'proxied' => $proxied
        );

        $res = cf_api_call($updateDnsURL, 'PUT', $data_update);
        echo 'Updated';
        exit();
    } else {

        echo 'nochangeIP';
        exit();
    }

    

} else {

    # dns not exists
    $createDnsURL = "https://api.cloudflare.com/client/v4/zones/$account/dns_records";

    $data_create = array(
        'type' => $recordType,
        'name' => $hostname,
        'content' => $ip,
        'ttl' => (int)$ttl,
        'proxied' => $proxied
    );

    $res = cf_api_call($createDnsURL, 'POST', $data_create);
    echo 'Created';
    exit();

}


function cf_api_call($url, $method, $postdata = null) {

    global $pwd;

    $req = curl_init();
    curl_setopt($req, CURLOPT_URL, $url);
    curl_setopt($req, CURLOPT_CUSTOMREQUEST, $method);
    if($postdata != null){
        curl_setopt($req, CURLOPT_POSTFIELDS, json_encode($postdata));
    }
    $headers = array( "Content-type: application/json", "Authorization: Bearer $pwd", );
    curl_setopt($req, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($req, CURLOPT_RETURNTRANSFER, 1);
    $res = curl_exec($req);
    curl_close($req);

    $results = json_decode($res, true);

    return $results;

}

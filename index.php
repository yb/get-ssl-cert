<?php

$domain = 'google.com';

$context = stream_context_create(['ssl' => ['capture_peer_cert' => true ]]);
$content = stream_socket_client('ssl://'.$domain.':443', $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $context);
$response = stream_context_get_params($content);
$certificate = openssl_x509_parse($response['options']['ssl']['peer_certificate']);

echo sprintf('域名：%s', strtoupper($certificate['subject']['CN']));
echo '<br>';
echo sprintf('颁发者：%s', $certificate['issuer']['CN']);
echo '<br>';
echo sprintf('有效期：%s 至 %s', 
    date('Y-m-d', $certificate['validFrom_time_t']),
    date('Y-m-d', $certificate['validTo_time_t'])
    );
echo '<br>';
echo sprintf('算法：%s', $certificate['signatureTypeSN']);

?>

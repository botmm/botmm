<?php
swoole_async_set([
                     'dns_lookup_random' => true
                 ]);


swoole_async_dns_lookup("www.sina.com.cn", function ($host, $ip) {
    echo "01: {$host} resolve to {$ip}\n";
    swoole_async_dns_lookup("www.sina.com.cn", function ($host, $ip) {
        echo "02: {$host} resolve to {$ip}\n";
    });
});
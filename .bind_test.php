<?php
$port = $argv[1] ?? 8000;
$s = @stream_socket_server("tcp://127.0.0.1:$port", $errno, $errstr);
if (!$s) {
    echo "ERR:$errno:$errstr\n";
    exit(1);
}

fclose($s);
echo "OK\n";

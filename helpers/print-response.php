<?php

function printResponse($status, $status_code, $data, $message)
{
    $response = [
        "status" => $status,
        "status_code" => $status_code,
        "data" => $data,
        "message" => $message
    ];
    print_r(json_encode($response, JSON_PRETTY_PRINT));
}

?>
<?php

/** Function to print the response in the required format */
function printResponse($status, $status_code, $data, $message)
{
    // Set the header to JSON
    header('Content-Type: application/json');
    // Set the Response Format
    $response = [
        "status" => $status,
        "status_code" => $status_code,
        "data" => $data,
        "message" => $message
    ];
    // Print the Response
    print_r(json_encode($response, JSON_PRETTY_PRINT));
}

?>
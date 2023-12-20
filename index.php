<?php

    // error_reporting(E_ALL);
    // ini_set('display_errors', '1');

    require_once './helpers/file-content.php';
    require_once './helpers/read-csv.php';
    require_once './helpers/file-structure.php';
    require_once './helpers/file-create.php';
    require_once './helpers/file-name.php';
    require_once './helpers/print-response.php';

    $csvFile = $_FILES['csvFile'];
    $technology = isset($_GET['technology']) ? strtolower($_GET['technology']) : '';

    // Set your desired upload directory
    $target_directory = "./"; 
    // Use 'name' key to access the original file name
    $target_file = $target_directory . basename($csvFile['name']); 

    // Use 'tmp_name' key for temporary file path
    if (move_uploaded_file($csvFile['tmp_name'], $target_file)) { 

        // Get all the File Path's Array
        $allFiles = getFileNamesFromFile($target_file);

        // To convert array of arrays to array of strings
        $arrayOfFileStrings = array_map(function ($innerArray) {
            return implode("", $innerArray);
        }, $allFiles);

        // Call to the Main Function that inits the Process
        createFolderStructure($arrayOfFileStrings);

        // Zip the 'temp' directory
        $zipFileName = $technology . '.zip';
        createZipFromFolder('temp', $zipFileName);

        printResponse(true, 200, [
            "zip_file" => $zipFileName
        ], "Zip file returned successfully");

    }
    else{
        printResponse(false, 500, [], "Sorry, there was an error uploading your file.");
    }

?>

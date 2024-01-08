<?php

    // error_reporting(E_ALL);
    // ini_set('display_errors', '1');

    // Include all the required files
    require_once './helpers/file-content.php';
    require_once './helpers/read-csv.php';
    require_once './helpers/file-structure.php';
    require_once './helpers/file-create.php';
    require_once './helpers/file-name.php';
    require_once './helpers/print-response.php';

    // Get the CSV File and Technology Stack from the POST Request
    $csvFile = $_FILES['csvFile'];
    $technology = isset($_GET['technology']) ? strtolower($_GET['technology']) : '';

    // Set your desired upload directory to upload CSV File
    $csvUploadDirectory = "./csv-files/";

    // Generate a timestamp-based file name for the CSV file
    $timestamp = time();
    $fileExtension = pathinfo($csvFile['name'], PATHINFO_EXTENSION); // Get the file extension
    $newFileName = $timestamp . '-uploaded.' . $fileExtension; // New timestamp-based file name 


    // Concat new file name based on timestamp to the target directory 
    $target_file = $csvUploadDirectory . $newFileName; 
    $zipOutputDirectory = "./outputs/";

    // Use 'tmp_name' key for temporary file path
    if (move_uploaded_file($csvFile['tmp_name'], $target_file)) { 

        // Get all the File Path's Array - Example: a,b,c,d - a,b,e,f - a,b,e,g
        $allFiles = getFileNamesFromFile($target_file);

        // Get the Array of Files in the Required Format - Example: a/b/c/d - a/b/e/f - a/b/e/g
        $filesArray = getCSVInRequiredFormat($allFiles); 

        // Call to the Main Function that inits the Process
        createFolderStructure($filesArray);

        // Zip the 'temp' directory
        $zipFileName = $technology . '-' . $timestamp . '.zip'; // Include timestamp in the file name

        // Use the outputs directory for storing zip files
        $zipTargetFile = $zipOutputDirectory . $zipFileName;
        createZipFromFolder('temp', $zipTargetFile);

        // Check if the 'temp' directory exists
        $temp_directory = "./temp/";
        if (is_dir($temp_directory)) {
            // If it exists, delete it and its contents
            deleteDirectory($temp_directory);
        }

        // Print the Response according to the Format required
        printResponse(true, 200, [
            "zip_file" => $zipFileName
        ], "Zip file returned successfully");

    }
    else{
        // Print the Response according to the Format required
        printResponse(false, 500, [], "Sorry, there was an error uploading your file.");
    }

?>

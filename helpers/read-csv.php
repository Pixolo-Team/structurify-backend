<?php

/** Returns array of array of data */
function getFileNamesFromFile($target_file)
{
    $arrayOfFiles = array();
    // Check if the CSV file exists
    if (file_exists($target_file)) {
        // Open the CSV file in read mode
        $csvFileStream = fopen($target_file, 'r');

        // Check if file opening was successful
        if ($csvFileStream !== false) {
            // Read each line from the file
            while (($singleFilePath = fgetcsv($csvFileStream)) !== false) {    
                array_push($arrayOfFiles, $singleFilePath);
            }
            // Close the file
            fclose($csvFileStream);
        } else {
            echo "Failed to open the file.";
        }
        return $arrayOfFiles;
    }
}

?>
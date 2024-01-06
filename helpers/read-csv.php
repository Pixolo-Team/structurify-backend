<?php

/** 
 * Get all the File Path's Array - 
 * This  function converts the Folder Structure CSV by adding the previous path to the current path
 */
function getFileNamesFromFile($target_file)
{
    // Create a variable for the Array
    $arrayOfFiles = [];

    // Check if the file exists (Defensive Coding)
    if (file_exists($target_file)) {
        // Get the contents of the File
        $csvFileStream = fopen($target_file, 'r');

        // If CSV is read
        if ($csvFileStream !== false) {
            $currentPath = ''; // Initialize currentPath

            // While fgets returns a line from the file pointer
            while (($singleFilePath = fgets($csvFileStream)) !== false) {
                $singleFilePath = trim($singleFilePath);

                // Remove trailing commas from right
                $singleFilePath = rtrim($singleFilePath, ',');

                if (!empty($singleFilePath)) {
                    // Make array of segments
                    $segments = explode(',', $singleFilePath);
                    // Make array of the current path segments
                    $currentSegments = explode(',', $currentPath);
                    // Create variable to store the final path array
                    $outputSegments = [];

                    // Loop through the segments
                    foreach ($segments as $index => $segment) {
                        // If some string exists in the Segment then take it, or take this part from the current path
                        if (!empty($segment)) {
                            // Push the Segment into the output segments
                            $outputSegments[] = $segment;
                        } else {
                            // Handle empty segments by using '/' or the previous segment
                            if (isset($currentSegments[$index])) {
                                $outputSegments[] = $currentSegments[$index];
                            } else {
                                $outputSegments[] = '/';
                            }
                        }
                    }

                    // Construct the file path
                    $currentPath = implode(',', $outputSegments);
                    // Push the current path in Array of Files
                    $arrayOfFiles[] = $currentPath;
                }
            }
            // Close the CSV File
            fclose($csvFileStream);
        } else {
            echo "Failed to open the file.";
        }
        return $arrayOfFiles;
    }
}

/** 
 * Get the Array of Files in the Required Format - 
 * This function converts the Folder Structure CSV by replacing ',' with ',/'
 */
function getCSVInRequiredFormat($arrayOfFiles)
{
    // Create a variable for the Array
    $formattedArray = [];

    // Loop through the array of files
    foreach ($arrayOfFiles as $line) {
        // Replace ',' with ',/'
        $formattedLine = str_replace(',', '/', $line);
        $formattedArray[] = $formattedLine;
    }

    return $formattedArray;
}

?>


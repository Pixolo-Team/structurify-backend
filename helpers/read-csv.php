<?php

function getFileNamesFromFile($target_file)
{
    $arrayOfFiles = [];
    if (file_exists($target_file)) {
        $csvFileStream = fopen($target_file, 'r');

        if ($csvFileStream !== false) {
            $currentPath = ''; // Initialize currentPath

            while (($singleFilePath = fgets($csvFileStream)) !== false) {
                $singleFilePath = trim($singleFilePath);

                // Remove trailing commas
                $singleFilePath = rtrim($singleFilePath, ',');

                if (!empty($singleFilePath)) {
                    $segments = explode(',', $singleFilePath);
                    $currentSegments = explode(',', $currentPath);
                    $outputSegments = [];

                    foreach ($segments as $index => $segment) {
                        if (!empty($segment)) {
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
                    // Store the file path
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

function getCSVInRequiredFormat($arrayOfFiles)
{
    $formattedArray = [];

    foreach ($arrayOfFiles as $line) {
        // Replace ',' with ',/'
        $formattedLine = str_replace(',', '/', $line);
        $formattedArray[] = $formattedLine;
    }

    return $formattedArray;
}

?>


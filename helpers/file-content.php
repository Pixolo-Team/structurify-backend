<?php

/** Gets the extension of file from file name */
function getFileExtension($fileOrFolderPathString)
{
     // Splitting the path by comma
     $fileNameParts = explode(',', $fileOrFolderPathString); 

     // Extracting the file name from the last part of the path
     $fileNameWithExtension = end($fileNameParts);
     
     // Trim any extra whitespace or empty elements
     $fileNameWithExtension = trim($fileNameWithExtension);
    
     // Find the position of the first dot in the filename
     $firstDotPosition = strpos($fileNameWithExtension, '.');
     
     if ($firstDotPosition !== false) {
         // Get the substring starting from the first dot
         $fileExtension = substr($fileNameWithExtension, $firstDotPosition);
     }
    return $fileExtension;
}


/** Retrieves the content of a file based on the provided extension and technology. */
function getFileContent($normalFileName, $extension) {
    // Create the Boiler Code File Path
    $boilerCodeFilePath = "technology/".$GLOBALS['technology']."/template".$extension;
    
    // Check if the file exists
    if (file_exists($boilerCodeFilePath)) {
        // Read file content
        $boilerCodeFileContent = file_get_contents($boilerCodeFilePath);
        
        // Replace the placeholders with the file name in the required case
        $modifiedContent = replacePlaceholdersInBoilerCode($normalFileName, $extension, $boilerCodeFileContent);
        return $modifiedContent;
    } else {
        return "File not found for ".$GLOBALS['technology']." with extension ".$extension;
    }
}

?>
<?php

/** Go through the Files Array and create the Files/Folder accordingly */
function createFolderStructure($fileOrFolderNameStrings)
{
    // Iterate through the Files/Folder Paths
    foreach ($fileOrFolderNameStrings as $fileOrFolderPath)
    {
        $main_directory = "./"; // Main directory where the 'temp' folder will be created
        $temp_directory = $main_directory . "temp/"; // Directory name 'temp' inside the main directory

        // Check if the 'temp' directory exists, if not, create it
        createFolderDirectory($temp_directory);

        $isFile = true; 

        // Check if it is File or Folder
        if (strpos(basename($fileOrFolderPath), '.') === false) {
            // It is a Folder
            $isFile = false;
        }

        if($isFile){

            // Get the name of the file broken in a normal sentence. Eg. ReadMoreInfo -> read more info
            $normalFileName = getNormalFileName(basename($fileOrFolderPath));

            // Get file extension with .
            $fileExtension = getFileExtension($fileOrFolderPath);

            // Get file content
            $fileContent = getFileContent($normalFileName, $fileExtension);

        }

        // File or Folder to be created inside the 'temp' folder
        $targetPath = $temp_directory . $fileOrFolderPath;

        // Function call to create file (with boiler code) or folder
        createFileOrFolder($targetPath, $fileContent, $isFile);

    }
}

?>
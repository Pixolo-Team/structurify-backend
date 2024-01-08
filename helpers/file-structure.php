<?php

/** Function to delete directory */
function deleteDirectory($dir) {
    if (!is_dir($dir)) {
        return;
    }

    $files = array_diff(scandir($dir), ['.', '..']);
    foreach ($files as $file) {
        $path = "$dir/$file";
        (is_dir($path)) ? deleteDirectory($path) : unlink($path);
    }

    rmdir($dir);
}

/** Go through the Files Array and create the Files/Folder accordingly */
function createFolderStructure($fileOrFolderNameStrings)
{
    $main_directory = "./";
    $temp_directory = $main_directory . "temp/";

    // Create the 'temp' directory
    createFolderDirectory($temp_directory);

    // Iterate through the Files/Folder Paths
    foreach ($fileOrFolderNameStrings as $fileOrFolderPath)
    {
        $isFile = true; 

        // Check if it is File or Folder
        if (strpos(basename($fileOrFolderPath), '.') === false) {
            // It is a Folder
            $isFile = false;
        }

        if ($isFile) {
            // Get the name of the file broken in a normal sentence
            $normalFileName = getNormalFileName(basename($fileOrFolderPath));
            $fileExtension = getFileExtension($fileOrFolderPath);
            $fileContent = getFileContent($normalFileName, $fileExtension);
        }

        // File or Folder to be created inside the 'temp' folder
        $targetPath = $temp_directory . $fileOrFolderPath;

        // Function call to create file (with boiler code) or folder
        createFileOrFolder($targetPath, $fileContent, $isFile);
    }
}

?>
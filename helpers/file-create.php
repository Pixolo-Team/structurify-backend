<?php

/** Create the Folder Directive */
function createFolderDirectory($fileOrFolderPath) {
    if (!file_exists($fileOrFolderPath)) {
        mkdir($fileOrFolderPath, 0777, true);
        return true;
    }
}

/** For a file, creates it and puts boiler code in file and for a folder, creates folders */
function createFileOrFolder($fileOrFolderPath, $boilerCode, $isFile)
{
    // Trim any extra whitespace
    $fileOrFolderPath = trim($fileOrFolderPath);

    // Check if it is not a File
    if ($isFile === false) {
        // Create the Folder Path
        createFolderDirectory($fileOrFolderPath);
    } else {
        // Creating the file, and Directory
        $directoryPath = dirname($fileOrFolderPath);
        createFolderDirectory($directoryPath);
        // Put the contents of the Boiler Code in the File, and Save it
        file_put_contents($fileOrFolderPath, $boilerCode);
    }
}

/** Function to create a zip file from a folder */
function createZipFromFolder($folderPath, $zipFileName)
{
    $zip = new ZipArchive();
    if ($zip->open($zipFileName, ZipArchive::CREATE) === true) {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($folderPath),
            RecursiveIteratorIterator::SELF_FIRST // Include empty directories
        );

        // Get the length of the base folder ('temp' in this case)
        $baseFolderLength = strlen($folderPath) + 1; // Account for the slash

        foreach ($files as $name => $file) {
            $filePath = $file->getRealPath();
            // Calculate relative path after 'temp/' folder
            $relativePath = substr($filePath, $baseFolderLength);
            
            // Check if the $folderPath exists in $relativePath
            $folderPos = strpos($relativePath, $folderPath);

            if ($folderPos !== false) {
                // Extract the path starting from $folderPath
                $zipPath = substr($relativePath, $folderPos + strlen($folderPath) + 1); // +1 for the slash after the folder name

                // For Folders
                if ($file->isDir()) {
                    $zip->addEmptyDir($zipPath);
                } 
                // For Files
                else {
                    $zip->addFile($filePath, $zipPath);
                }
            }
        }
        $zip->close();
    }
}

?>
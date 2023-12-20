<?php

/** Converts the basename of file in normal english Eg:readInfoLess => read info less */
function getNormalFileName($fileBaseName) {
    // Remove file extension if present
    $fileNameWithoutExtension = pathinfo($fileBaseName, PATHINFO_FILENAME);

    // Remove everything after the first dot (file extension)
    $fileNameWithoutExtension = explode('.', $fileNameWithoutExtension)[0];

    // Split by various delimiters: camelCase, PascalCase, snake_case, kebab-case
    $words = preg_split('/(?=[A-Z])|_|-/', $fileNameWithoutExtension);

    // Filter out empty elements and format words to normal English
    $filteredWords = array_filter($words);
    $normalFileName = implode(' ', array_map('strtolower', $filteredWords));

    return $normalFileName;
}

/** Replaces |camelCase| in boiler code to it's file Name in camel case Eg: read info less to readInfoLess instead of |camelCase| in the file */
function replacePlaceholdersInBoilerCode($fileName, $fileExtension, $boilerCodeContent) {
    $kebabCaseFileName = str_replace(' ', '-', strtolower($fileName));
    $snakeCaseFileName = str_replace(' ', '_', strtolower($fileName));
    $pascalCaseFileName = str_replace(' ', '', ucwords($fileName));
    $camelCaseFileName = lcfirst($pascalCaseFileName);
    $CapitalFileName = ucwords($fileName);

    // Replace placeholders in the boilerplate code with respective formatted filenames
    $modifiedContent = str_replace('|camelCase|', $camelCaseFileName, $boilerCodeContent);
    $modifiedContent = str_replace('|kebab-case|', $kebabCaseFileName, $modifiedContent);
    $modifiedContent = str_replace('|snake_case|', $snakeCaseFileName, $modifiedContent);
    $modifiedContent = str_replace('|PascalCase|', $pascalCaseFileName, $modifiedContent);
    $modifiedContent = str_replace('|normal|', $fileName, $modifiedContent);
    $modifiedContent = str_replace('|Capital|', $CapitalFileName, $modifiedContent);

    return $modifiedContent;
}

?>
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

/** Function to singularize the file name */
function singularize($word) {
    $singular = array (
    '/(quiz)zes$/i' => '\1',
    '/(matr)ices$/i' => '\1ix',
    '/(vert|ind)ices$/i' => '\1ex',
    '/^(ox)en/i' => '\1',
    '/(alias|status)es$/i' => '\1',
    '/([octop|vir])i$/i' => '\1us',
    '/(cris|ax|test)es$/i' => '\1is',
    '/(shoe)s$/i' => '\1',
    '/(o)es$/i' => '\1',
    '/(bus)es$/i' => '\1',
    '/([m|l])ice$/i' => '\1ouse',
    '/(x|ch|ss|sh)es$/i' => '\1',
    '/(m)ovies$/i' => '\1ovie',
    '/(s)eries$/i' => '\1eries',
    '/([^aeiouy]|qu)ies$/i' => '\1y',
    '/([lr])ves$/i' => '\1f',
    '/(tive)s$/i' => '\1',
    '/(hive)s$/i' => '\1',
    '/([^f])ves$/i' => '\1fe',
    '/(^analy)ses$/i' => '\1sis',
    '/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i' => '\1\2sis',
    '/([ti])a$/i' => '\1um',
    '/(n)ews$/i' => '\1ews',
    '/s$/i' => '',
    );

    // Uncountable words which should not be singularized
    $uncountable = array('equipment', 'information', 'rice', 'money', 'species', 'series', 'fish', 'sheep');

    // Irregular words 
    $irregular = array(
    'person' => 'people',
    'man' => 'men',
    'child' => 'children',
    'sex' => 'sexes',
    'move' => 'moves',
    'goose' => 'geese',
    'tooth' => 'teeth',
    'larva' => 'larvae',);

    // Check if the word is uncountable
    $lowercased_word = strtolower($word);
    foreach ($uncountable as $_uncountable){
        if(substr($lowercased_word,(-1*strlen($_uncountable))) == $_uncountable){
            return $word;
        }
    }

    // Check if the word is irregular
    foreach ($irregular as $_plural=> $_singular){
        if (preg_match('/('.$_singular.')$/i', $word, $arr)) {
            return preg_replace('/('.$_singular.')$/i', substr($arr[0],0,1).substr($_plural,1), $word);
        }
    }

    // Check if the word is singular
    foreach ($singular as $rule => $replacement) {
        if (preg_match($rule, $word)) {
            return preg_replace($rule, $replacement, $word);
        }
    }

    return $word;
}

/** Replaces |camelCase| in boiler code to it's file Name in camel case Eg: read info less to readInfoLess instead of |camelCase| in the file */
function replacePlaceholdersInBoilerCode($fileName, $fileExtension, $boilerCodeContent) {
    $kebabCaseFileName = str_replace(' ', '-', strtolower($fileName));
    $snakeCaseFileName = str_replace(' ', '_', strtolower($fileName));
    $pascalCaseFileName = str_replace(' ', '', ucwords($fileName));
    $camelCaseFileName = lcfirst($pascalCaseFileName);
    $CapitalFileName = ucwords($fileName);
    
    // Singularize the file name
    $pascalSingularFileName = singularize($pascalCaseFileName);
    $camelSingularFileName = singularize($camelCaseFileName);
    $kebabSingularFileName = singularize($kebabCaseFileName);
    $snakeSingularFileName = singularize($snakeCaseFileName);
    $CapitalSingularFileName = singularize($CapitalFileName);

    // Replace placeholders in the boilerplate code with respective formatted filenames
    $modifiedContent = str_replace('|camelCase|', $camelCaseFileName, $boilerCodeContent);
    $modifiedContent = str_replace('|kebab-case|', $kebabCaseFileName, $modifiedContent);
    $modifiedContent = str_replace('|snake_case|', $snakeCaseFileName, $modifiedContent);
    $modifiedContent = str_replace('|PascalCase|', $pascalCaseFileName, $modifiedContent);
    $modifiedContent = str_replace('|PascalCase-nos|', $pascalCaseNoSFileName, $modifiedContent);
    $modifiedContent = str_replace('|normal|', $fileName, $modifiedContent);
    $modifiedContent = str_replace('|Capital|', $CapitalFileName, $modifiedContent);

    return $modifiedContent;
}

?>
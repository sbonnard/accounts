<?php

// include_once 'includes/_functions.php';

/**
 * Get HTML head content.
 *
 * @param string $headTitle - The title in the head element.
 * @return string - A string of HTML elements.
 */
function fetchHead(string $headTitle):string
{
    return 
        '
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . $headTitle . '</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
            <link rel="stylesheet" href="../css/style.css">
        ';
}

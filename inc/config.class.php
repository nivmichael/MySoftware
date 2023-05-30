<?php
// specific configuration needed for the API calls

class config
{
    const images_url = "../images";
    const username_length = 3;
    const password_length = 5;

    const file_err = [
        "The uploaded file exceeds the upload_max_filesize directive in php.ini.",
        "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.",
        "The uploaded file was only partially uploaded.",
        "No file was uploaded.",
        "Missing a temporary folder. Introduced in PHP 5.0.3.",
        "Failed to write file to disk. Introduced in PHP 5.1.0.",
        "A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help.",
    ];
}

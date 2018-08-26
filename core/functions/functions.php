<?php

    /* Function that checks input field. */
    function checkInput($var) {
        $var = htmlspecialchars($var);
        $var = trim($var);
        $var = stripcslashes($var);
        return $var;
    }

    /* Function to upload an image. */
    function uploadImage($file) {
        $filename    = basename($file['name']);
        $fileTmp     = $file['tmp_name'];
        $fileSize    = $file['size'];
        $fileError   = $file['error'];

        $ext         = explode('.', $filename);
        $ext         = strtolower(end($ext));
        $allowed_ext = array('jpg', 'gif', 'jpg', 'jpeg', 'pdf');

        if(in_array($ext, $allowed_ext) === true) {
            if($fileError === 0) {
                if($fileSize <= 209272152) {
                    $fileRoot =  $_SERVER['DOCUMENT_ROOT'] . '/users/' . $filename;
                    move_uploaded_file($fileTmp, $fileRoot);
                    return $fileRoot;
                }
                else {
                    $GLOBALS['imageError'] = "The filesize is too big.";
                }
            }
            else {
                $GLOBALS['imageError'] = "The extension is not allowed.";
            }
        }
       
    }


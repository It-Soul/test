<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$callback = $_GET['CKEditorFuncNum'];
$file_name = $_FILES['upload']['name'];
$full_path = $_SERVER['DOCUMENT_ROOT'] . '/images/ckeditor_upload/' . $file_name;
$http_path = '/images/ckeditor_upload/' . $file_name;
$error = '';
if (move_uploaded_file($_FILES['upload']['tmp_name'], $full_path)) {
} else {
    $error = $file_name . '  ' . $full_path . '  ' . $file_name_tmp;//'Some error occured please try again later';
    $http_path = '';
}
echo "<script type=\"text/javascript\">window.parent.CKEDITOR.tools.callFunction(" . $callback . ",  \"" . $http_path . "\", \"" . $error . "\" );</script>";

?>


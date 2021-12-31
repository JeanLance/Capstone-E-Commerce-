<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomLibrary {
    
    /* Function: project image file directory */
    function projectImgDir() {
        return "C:/Users/jeanl/OneDrive/Desktop/MyCapstone/main_folder/codes/products_img/";
    }

    /* Function: Project temp image file directory */
    function projectImgTmpDir() {
        return "C:/Users/jeanl/OneDrive/Desktop/MyCapstone/main_folder/codes/tmp_upload/";
    }

    /* Function: Create directory. Returns true or false */
    function createDIR($path, $folder_name) {
        $last_char = substr($path, -1);
        if ($last_char != '/') {
            $path = $path . '/';
        }
        return mkdir($path . $folder_name, 0700);
    }

    /* Function: Check if directory exists. Returns true or false */
    function checkFolderExist($path, $folder_name) {
        $last_char = substr($path, -1);
        if ($last_char != '/') {
            $path = $path . '/';
        }
        return is_dir($path . $folder_name);
    }

    /* Function: Removes the extension(last) of a file and returns only it's name */
    function removeExt($file) {
        return substr($file, 0, strrpos($file, "."));
    }

    /* Function: Delete image files from the specified path(dir) */
    function deleteImageFiles($path, $files) {
        $dir_items = array();
        if (is_dir($path)) {
            if ($dh = opendir($path)) {
                while (($file = readdir($dh)) !== false) {
                    $dir_items[] = $file;
                }
                closedir($dh);
            }
        }

        $result = array_intersect($dir_items, $files);

        foreach($result as $key => $value) {
            for($j = 0; $j < count($dir_items); $j++) {
                if ($result[$key] == $dir_items[$j]) {
                    if (is_file($path . '/' . $dir_items[$j])) {
                        unlink($path . '/' . $dir_items[$j]);
                    }
                }
            }
        }
    }

    /* Function: Deletes all temp file from the temp image directory */
    function deleteTempFiles() {
        $tmp_dir = $this->projectImgTmpDir();
        $files = glob($tmp_dir .'*');
        foreach($files as $file){
            if(is_file($file)) {
                unlink($file);
            }
        }
    }
}
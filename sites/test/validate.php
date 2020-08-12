<?php
    function is_email($str) {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }
    function is_username($username) {
        if (preg_match('/^[a-z0-9]{3,15}$/', $username)){
            return TRUE;
        }
        return FALSE;
    }
    function is_password($password) {
        if (preg_match('/^[a-z0-9]{2,15}$/', $password)){
            $lowercase = preg_match('@[a-z]@', $password);
            $number    = preg_match('@[0-9]@', $password);
            if(!$lowercase || !$number || strlen($password) >= 15) {
                return FALSE;
            }
            return TRUE;
        }
        return FALSE;
    }
    function is_image($image){
        $target_dir    = "uploads/";
        $target_file   = $target_dir . basename($image['name']);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $maxfilesize   = 3000000;
        $allowtypes    = array('jpg', 'png', 'jpeg');

        if ($image['error'] != 0 || file_exists($target_file) || ($image['size'] > $maxfilesize) || !in_array($imageFileType,$allowtypes))
        {
            return FALSE;
        }

        move_uploaded_file($image["tmp_name"], $target_file);
        return TRUE;
    }
?>
<?php

    function auth($login, $mdp) {
        $salt = "a25QUHTqgxIWxHXZqmkh7Gmry41tINCI9Bui4MVXHdvgBPYXGRxmLs2ZSQTNVLI";
        $fh = file_gets_content("pwd");

        foreach ($fh as $r) {
            $p = split(':', $p);
            if ($p[0] == $login && $p[1] == sha1($salt . $mdp)) {
                return true;
            }
        }
        return false;
    }

?>

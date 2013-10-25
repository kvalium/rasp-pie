<?php

/* * ******************************************
 * General parameters of the application
 * Please edit this file on purpose
 * ******************************************* */

function get_params($param) {

    $array = [
        // database information
        "database_host" => "localhost",
        "database_login" => "root",
        "database_password" => "",
        "database_name" => "rasppie",
        // Misc
        "snmp_community" => "public",
        "raspberry_subnet" => "192.168.0.",
        "hash_salt" => "a25QUHTqgxIWxHXZqmkh7Gmry41tINCI9Bui4MVXHdvgBPYXGRxmLs2ZSQTNVLI"

    ];

    return $array[$param];
}

?>
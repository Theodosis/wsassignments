<?php

    class User {
        public static function BasicAuth( $users ) {
            if ( empty( $_SERVER[ 'PHP_AUTH_USER' ] ) ) {
                return false;
            }

            $username = $_SERVER[ 'PHP_AUTH_USER' ];
            $password = $_SERVER[ 'PHP_AUTH_PW' ];

            if ( !isset( $users[ $username ] ) ) {
                return false;
            }

            $user = $users[ $username ];
            $user[ 'name' ] = $username;

            if ( $user[ 'password' ] != $password ) {
                return false;
            }

            return $user;
        }
    }

?>

<?php

    class Student {
        public static function GetByEmail( $email ) {
            $rows = db_select( 'students', compact( 'email' ) );
            if ( isset( $rows[ 0 ] ) ) {
                return $rows[ 0 ];
            }
            else {
                return null;
            }
        }
        public static function Create( $firstname, $lastname, $email ) {
            $created = date( "Y-m-d H:i:s", time() );
            $user = compact( 'firstname', 'lastname', 'email', 'isreplied', 'created' );
            db_insert( 'students', $user );
            $user[ 'id' ] = mysql_insert_id();
            return $user;
        }
    }

?>

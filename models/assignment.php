<?php

    class Assignment {
        public static function Get( $id ) {
            $rows = db_select( 'assignments', compact( 'id' ) );
            if ( isset( $rows[ 0 ] ) ) {
                return $rows[ 0 ];
            }
            // else
            return null;
        }
    }

?>
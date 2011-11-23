<?php
    class Validation {
        public static function Listing( $offset = 0, $limit = 100 ) {
            return db_array( 'SELECT * FROM `validation` LIMIT :offset, :limit',
                        compact( 'offset', 'limit' ) );
        }
    }
?>

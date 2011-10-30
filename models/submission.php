<?php

    class Submission {
        public static function listing {
            return db_select( 'submissions' );
        }
        public static function update( $title, $content, $id = false ) {
            if ( $id == false ) {
                return db_insert( 'submissions', compact( 'title', 'content' ) );
            }
            return db_update( 'submissions', compact( 'id' ), compact( 'title', 'content' ) );
        }
        public static function delete( $id ) {
            return db_delete( 'submissions', compact( 'id' ) );
        }
    }

?>

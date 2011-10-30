<?php

    class Submission {
        public static function Listing() {
            return db_select( 'submissions' );
        }
        public static function Create( $assignmentid, $studentid, $iscorrect, $isreplied, $id ) {
            return db_insert( 'submissions', compact( 'assignmentid', 'studentid', 'iscorrect', 'isreplied' ) );
        }
        public static function Update( $assignmentid, $studentid, $iscorrect, $isreplied, $id ) {
            return db_update( 'submissions', compact( 'id' ), compact( 'assignmentid', 'studentid', 'iscorrect', 'isreplied' ) );
        }
        public static function Delete( $id ) {
            return db_delete( 'submissions', compact( 'id' ) );
        }
    }

?>

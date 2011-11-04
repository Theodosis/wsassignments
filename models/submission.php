<?php

    class Submission {
        public static function Listing( $offset, $limit ) {
            return db_array( 'SELECT * FROM `submissions` LIMIT :offset, :limit',
                        compact( 'offset', 'limit' ) );
        }
        public static function Create( $assignmentid, $studentid, $iscorrect, $isreplied ) {
            $received = date( "Y-m-d H:i:s", time() );
            $submission = compact( 'assignmentid', 'studentid', 'iscorrect', 'isreplied', 'received' );
            db_insert( 'submissions', $submission );
            $submission[ 'id' ] = mysql_insert_id();
            return $submission;
        }
        public static function Update( $assignmentid, $studentid, $iscorrect, $isreplied, $id ) {
            return db_update( 'submissions', compact( 'id' ), compact( 'assignmentid', 'studentid', 'iscorrect', 'isreplied' ) );
        }
        public static function Delete( $id ) {
            return db_delete( 'submissions', compact( 'id' ) );
        }
    }

?>

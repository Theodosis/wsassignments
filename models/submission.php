<?php
    class Submission {
        // function Listing lists all submissions, paginated by offset and limit.
        public static function Listing( $offset, $limit ) {
            return db_array( 'SELECT * FROM `submission` LIMIT :offset, :limit',
                        compact( 'offset', 'limit' ) );
        }
        // function Create stores a new submission to the database.
        public static function Create( $assignmentid, $userid, $validationid, $comment = "" ) {
            $received = date( "Y-m-d H:i:s", time() );
            $submission = compact( 'assignmentid', 'userid', 'validationid', 'comment' );
            db_insert( 'submission', $submission );
            $submission[ 'id' ] = mysql_insert_id();
            return $submission;
        }
        // function delete removes a submission from the database.
        public static function Delete( $id ) {
            return db_delete( 'submission', compact( 'id' ) );
        }
        
        // function ListByUserAndAssignment returns the submissions for 
        // a user for an assignment.
        public static function ListByUserAndAssignment( $userid, $assignmentid ){
            $submission_list = db_array( "
                SELECT `s`.`id`, `v`.`description` as status, `s`.`comment`, `s`.`created`, `v`.`id` as validationid FROM `submission` as s
                    CROSS JOIN `validation` as v ON `s`.`validationid` = `v`.`id`
                    WHERE `s`.`userid` = :userid AND `s`.`assignmentid` = :assignmentid
                    ORDER BY `s`.created DESC LIMIT 0, 10; ", compact( 'userid', 'assignmentid' ) );
            return $submission_list;
        }
        // function ListAllGroupped returns the submission status for all users, for 
        // all assignments. Is used for administration reasons.
        public static function ListAllGroupped(){
            return db_array( "
                SELECT
                    u.id as userid, u.firstname, u.lastname, u.email,
                    a.id as assignmentid, a.description as assignment, v.description as status,
                    s.comment
                FROM 
                    (assignment a, user u)
                    LEFT JOIN submission s ON s.userid = u.id AND s.assignmentid = a.id
                    LEFT JOIN submission s2 ON s2.userid = u.id AND s2.assignmentid = a.id AND s.id != s2.id AND s.validationid > s2.validationid
                    LEFT JOIN submission s3 ON s3.userid = u.id AND s3.assignmentid = a.id AND s.validationid = s3.validationid AND s.id > s3.id
                    LEFT JOIN validation v ON s.validationid = v.id
                WHERE
                    s2.id IS NULL AND s3.id IS NULL;
            " );
        }
        // function UserResults returns the best result for a user for an assignment.
        // also used for administration reasons.
        public static function UserResults( $userid, $assignmentid ){
            return db_array( "
                SELECT v.description FROM submission as s
                    CROSS JOIN validation as v
                        ON s.validationid = v.id
                    WHERE userid=:userid AND assignmentid=:assignmentid
                ORDER BY validationid ASC
                LIMIT 1;
            ", compact( 'userid', 'assignmentid' ) );
        }
        public static function Update( $userid, $assignmentid, $validationid ){
            return db_update( 'submission', compact( 'userid', 'assignmentid' ), compact( 'validationid' ) );
        }
    }

?>

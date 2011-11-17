<?php

    class Submission {
        public static function Listing( $offset, $limit ) {
            return db_array( 'SELECT * FROM `submission` LIMIT :offset, :limit',
                        compact( 'offset', 'limit' ) );
        }
        public static function Create( $assignmentid, $userid, $result, $servercomment ) {
            $received = date( "Y-m-d H:i:s", time() );
            $submission = compact( 'assignmentid', 'userid', 'result', 'servercomment' );
            db_insert( 'submissions', $submission );
            $submission[ 'id' ] = mysql_insert_id();
            return $submission;
        }
        public static function Update() {
        }
        public static function Delete( $id ) {
            return db_delete( 'submission', compact( 'id' ) );
        }

        public static function ListByUserAndAssignment( $userid, $assignmentid ){
            $submission_list = db_array( "
                SELECT `s`.`id`, `v`.`description` as status, `s`.`comment`, `s`.`created`, `v`.`id` as validationid FROM `submission` as s
                    CROSS JOIN `validation` as v ON `s`.`validationid` = `v`.`id`
                    WHERE `s`.`userid` = :userid AND `s`.`assignmentid` = :assignmentid
                    ORDER BY `s`.created DESC; ", compact( 'userid', 'assignmentid' ) );
            return $submission_list;
        }
        public static function ListAllGroupped(){
            return db_array( "
            SELECT * FROM (
                SELECT 
                    `u`.`id` as userid, `u`.`firstname`, `u`.`lastname`,
                    `u`.`email`, `a`.`id` as assignmentid, `a`.`description` as assignment, `v`.`description` as status, `s`.`comment`
                FROM `user` as u
                    LEFT JOIN `submission` as s ON `s`.`userid` = `u`.`id`
                    LEFT JOIN `assignment` as a ON `s`.`assignmentid` = `a`.`id`
                    LEFT JOIN `validation` as v ON `v`.`id` = `s`.`validationid`
                ORDER BY `u`.`id` ASC, `s`.`validationid` ASC
            ) as FOO
            GROUP BY assignmentid, userid
            ORDER BY userid, assignmentid;
            " );
        }
    }

?>

<?php
    class Assignment {
        // function Get fetches an assignment by id, after deciding whether it is 
        // active or not (on time limits).
        public static function Get( $id ) {
            global $user;
            $rows = db_select( 'assignment', compact( 'id' ) );
            if ( isset( $rows[ 0 ] ) ) {
                $rows[ 0 ][ 'active' ] = strtotime( $rows[ 0 ][ 'start' ] ) < time() &&
                                         strtotime( $rows[ 0 ][ 'end' ] )   > time();
                return $rows[ 0 ];
            }
            // else
            return null;
        }
        // function Listing lists all available assignments.
        public static function Listing(){
            return db_array( '
            SELECT * FROM `assignment`
                WHERE
                start <= NOW();' );
        }
        // function GetLast fetches the assignment with the higher id, after deciding 
        // whether it is active or not (on time limits).
        public static function GetLast(){
            global $user;
            if( $user[ 'rights' ] > 40 ){
                $last = db_array( "
                    SELECT * FROM `assignment`
                        ORDER BY `id` DESC
                        LIMIT 1;" );
            }
            else{
                $last = db_array( "
                    SELECT * FROM `assignment`
                        WHERE
                            `start` <= NOW()
                        ORDER BY `id` DESC
                        LIMIT 1;" );
            }
            if( count( $last ) ){
                $last[ 0 ][ 'active' ] = $user[ 'rights' ] > 40 ||
                                         strtotime( $last[ 0 ][ 'start' ] ) < time() &&
                                         strtotime( $last[ 0 ][ 'end' ] )   > time();
                return $last[ 0 ];
            }
            return null;
        }
        // function ListByUser is responsible to select the submission status for every assignment 
        // for a user. It sets the submission status depending on the query results.
        public static function ListByUser( $id ){
            global $user;
            $results = db_array( "
                SELECT * FROM (
                    SELECT `validationid`, `a`.`id` as assignmentid, `a`.`description`, `a`.`end` FROM `assignment` as a
                        LEFT JOIN ( SELECT * FROM `submission` WHERE `userid` = :id ) as s
                            ON `s`.`assignmentid` = `a`.`id`
                        " . ( $user[ 'rights' ] < 40 ? "WHERE `a`.`start` < NOW()" : "" ) . "
                        ORDER BY `s`.`assignmentid` ASC, `s`.`validationid` ASC
                    ) as SUB
                GROUP BY assignmentid;", compact( 'id' ) );
            for( $i = 0; $i < count( $results ); ++$i ){
                if( $results[ $i ][ 'validationid' ] == NULL && strtotime( $results[ $i ][ 'end' ] ) > date( time() ) ){
                    $results[ $i ][ 'submission_status' ] = 'delayed';
                    $results[ $i ][ 'submission_description' ] = 'Εκκρεμεί.';
                }
                else if( $results[ $i ][ 'validationid' ] == NULL ){
                    $results[ $i ][ 'submission_status' ] = 'empty';
                    $results[ $i ][ 'submission_description' ] = 'Δεν έχει αποσταλεί.';
                }
                else if( $results[ $i ][ 'validationid' ] == 0 ){
                    $results[ $i ][ 'submission_status' ] = 'accepted';
                    $results[ $i ][ 'submission_description' ] = 'Έχει αποσταλεί.';
                }
                else{
                    $results[ $i ][ 'submission_status' ] = 'rejected';
                    $results[ $i ][ 'submission_description' ] = 'Απορρίφθηκε.';
                }

            }
            return $results;
        }
    }

?>

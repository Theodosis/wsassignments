<?php

    clude( 'models/submission.php' );

    class SubmissionController extends Controller {
        public static function Create( $params ) {
            global $settings;
            global $user;
            clude( 'models/assignment.php' );
            clude( 'models/student.php' );
            clude( 'controllers/dashboard.php' );

            if( !Controller::RequiredParameters( $params, 'file', 'assignmentid' ) ) return;
            if( !Controller::RequiredParameters( $params[ 'file' ], 'name', 'tmp_name' ) ) return;
            
            $assignment = Assignment::Get( $params[ 'assignmentid' ] );
            if ( empty( $assignment ) ) {
                die( 'no such assignment' );
            }
            if( !$assignment[ 'active' ] ){
                die( 'Assignment is not active' );
            }
            if( $params[ 'file' ][ 'error' ] ){
                die( 'Error while uploading file' );
            }
            // TODO
            
            $ch = curl_init( $settings[ 'validator' ] );
            
            curl_setopt( $ch, CURLOPT_POST, true );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch, CURLOPT_TIMEOUT, 3000 );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, array(
                'pass' => $settings[ 'validator_pass' ],
                'id' => $user[ 'id' ],
                'mail' => $user[ 'email' ],
                'assignmentid' => $params[ 'assignmentid' ],
                'filename' => $params[ 'file' ][ 'name' ],
                'file' => '@' . $params[ 'file' ][ 'tmp_name' ],
            ) );

            $results = curl_exec( $ch );
            curl_close( $ch );
            if( $results === false ){
                $results = (object) array(
                    "validationid" => 2,
                    "comment" => ''
                );
            }
            else{
                $results = json_decode( $results );
            }
            db_insert( 'submission', array(
                "userid" => $user[ 'id' ],
                "assignmentid" => $params[ 'assignmentid' ],
                "validationid" => $results->validationid,
                "comment" => $results->comment
            ) );
            $results->submissionid = mysql_insert_id();
            $row = db_array( '
                SELECT * FROM `validation`
                    WHERE `id`=:id;', array( "id" => $results->validationid ) );

            $results->validation = $row[ 0 ][ 'description' ];
            DashboardController::View( get_object_vars( $results ) );
        }
        public static function Update( $params ) {
        }
        public static function Delete( $params ) {
        }
    }

?>

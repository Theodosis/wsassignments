<?php

    clude( 'models/submission.php' );
    // class SubmissionController is responsible to handle the submission requests.
    class SubmissionController extends Controller {
        // function Create checks the validity of the request by validating the parameters,
        // and checks whether the referenced assignment is active.
        // It sends a post request to the validation server, stores the results to the db 
        // and outputs the dashboard/view view.
        public static function Create( $params ) {
            global $settings;
            global $user;
            clude( 'models/assignment.php' );
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
            if( $user[ 'id' ] == 530 ){
                echo $results;
            }
            $results = json_decode( $results );
            curl_close( $ch );
            if( $results === NULL || !isset( $results->validationid ) ){
                $results = (object) array(
                    "validationid" => 2,
                    "comment" => ""
                );
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
            $controller = "dashboard";
            DashboardController::View( get_object_vars( $results ) );
        }
        
        // function Update is available only for administrators, and updates the 
        // submission status for a user for an assignment.
        public static function Update( $params ) {
            clude( 'models/submission.php' );
            global $user;
            $user[ 'rights' ] < 40 && die( 'hard' );
            
            Controller::RequiredParameters( $params, 'userid', 'assignmentid', 'validationid' ) or die( 'hard' );
            if( Submission::Update( $params[ 'userid' ], $params[ 'assignmentid' ], $params[ 'validationid' ] ) == 0 ){
                Submission::Create( $params[ 'assignmentid' ], $params[ 'userid' ], $params[ 'validationid' ] );
            }
            $res = Submission::UserResults( $params[ 'userid' ], $params[ 'assignmentid' ] );
            //TODO: write a view to output the description.
            echo $res[ 0 ][ 'description' ];
        }
        public static function Delete( $params ) {

        }
    }

?>

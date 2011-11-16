<?php

    require( 'models/submission.php' );

    class SubmissionController extends Controller {
        public static function Listing( $params ) {
            $offset = isset( $params[ 'offset' ] ) ? $params[ 'offset' ] : 0;
            $limit = isset( $params[ 'limit' ] ) ? $params[ 'limit' ] : 500;
            
            $submissions = Submission::Listing( $offset, $limit );

            Controller::View( compact( 'submissions', 'offset', 'limit' ) );
        }
        public static function Create( $params ) {
            require( 'models/assignment.php' );
            require( 'models/student.php' );

            if ( !Controller::RequiredParameters( $params, 'student_email', 'assignment_id' ) ) return;
            
            $assignment = Assignment::Get( $params[ 'assignment_id' ] );
            if ( empty( $assignment ) ) {
                die( 'no such assignment' );
            }
            // TODO
        }
        public static function Update( $params ) {
        }
        public static function Delete( $params ) {
        }
    }

?>

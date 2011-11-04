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

            $student = Student::GetByEmail( $params[ 'student_email' ] );
            if ( empty( $student ) ) {
                if ( !Controller::RequiredParameters( $params, 'student_firstname', 'student_lastname' ) ) return;
                $student = Student::Create( $params[ 'student_firstname' ], $params[ 'student_lastname' ], $params[ 'student_email' ] );
            }

            $submission = Submission::Create( $assignment[ 'id' ], $student[ 'id' ], 'unknown', 'unknown' );

            Controller::View( compact( 'assignment', 'student', 'submission' ) );
        }
        public static function Update( $params ) {
        }
        public static function Delete( $params ) {
        }
    }

?>

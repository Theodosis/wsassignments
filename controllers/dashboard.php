<?php
    class DashboardController {
        // gather all required resources: assignment status for the user,
        // active assignment and submission list for the active assignment, set
        // the title and the controller and run Controller::View to output the 
        // appropriate view.
        public static function View( $results ){
            global $user;
            clude( 'models/submission.php' );
            clude( 'models/assignment.php' );
            $assignments = Assignment::ListByUser( $user[ 'id' ] );
            
            $current = Assignment::GetLast();

            $submission_list = Submission::ListByUserAndAssignment( $user[ 'id' ], $current[ 'id' ] );
            
            $title = "Webseminar Dashboard";
            Controller::View( '/dashboard/view', 
                compact( 'assignments', 'current', 'submission_list', 
                         'results', 'title', 'controller' ) 
            );
        }
        public static function Listing( $params ) {
        }
        public static function Create( $params ) {
        }
        public static function Update( $params ) {
        }
        public static function Delete( $params ) {
        }
    }
?>

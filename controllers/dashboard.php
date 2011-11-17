<?php
    class DashboardController {
        public static function View( $results ){
            global $user;
            clude( 'models/submission.php' );
            clude( 'models/assignment.php' );
            $assignments = Assignment::ListByUser( $user[ 'id' ] );
            
            $current = Assignment::GetLast();

            $submission_list = Submission::ListByUserAndAssignment( $user[ 'id' ], $current[ 'id' ] );
            
            $title = "Webseminar Dashboard";
            $controller = "dashboard";
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

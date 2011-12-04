<?php
    class AdminpanelController {
        public static function View( $params ){
            global $user;
            clude( 'controllers/submission.php' );
            clude( 'models/validation.php' );
            if( $user[ 'rights' ] < 40 ){
                header( 'HTTP/1.1 403 Forbidden' );
                exit();
            }
            $rows = Submission::ListAllGroupped();
            $validlist = Validation::Listing();
            $validation = array();
            foreach( $validlist as $val ){
                $validation[ $val[ 'id' ] ] = $val[ 'description' ];
            }
            
            $title = "Webseminar Admin Panel";
            $controller = "adminpanel";
            Controller::View( compact( 'rows', 'title', 'controller', 'validation' ) );
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

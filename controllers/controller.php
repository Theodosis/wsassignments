<?php

    class Controller {
        public static function RequiredParameters( $params /*, ... */ ) {
            $arguments = func_get_args(); 
            array_shift( $arguments );

            $missingParameters = array();
            foreach ( $arguments as $argument ) {
                if ( !isset( $params[ $argument ] ) ) {
                    $missingParameters[] = $argument;
                }
            }

            if ( !empty( $missingParameters ) ) {
                Controller::View( compact( 'missingParameters' ) );
                return false;
            }

            return true;
        }
        public static function View( $path, $vars = false ) {
            global $controller;
            global $method;

            if ( $vars == false ) {
                $vars = $path;
                $path = "$controller/$method";
            }
            
            foreach ( $vars as $_name => $_value ) {
                $$_name = $_value; //MAGIC!
            }

            require( "views/$path.php" );
        }
    }

?>

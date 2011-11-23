<?php
    /*
        Author: Aleksis "abresas" Brezas <abresas@kamibu.com>
        
        class Controller is an abstract class and defines some helping functions
    */
    class Controller {
        // function RequiredParameteres checks whether the array params has 
        // all of the specified attributes and returns true on success, false otherwise.
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
                //Controller::View( compact( 'missingParameters' ) );
                return false;
            }

            return true;
        }
        // function view is responsible for calling the appropriate views, defined 
        // by path (using controller/method if ommited).
        // It passes the variables vars (using path if vars is ommited).
        // If mode is normal, it wraps the viewer output around the header and footer views.
        // else it calls just the specified view (minimal version).
        public static function View( $path, $vars = false, $mode = 'normal' ) {
            global $controller;
            global $method;

            if ( $vars === false ) {
                $vars = $path;
                $path = "$controller/$method";
            }
            foreach ( $vars as $_name => $_value ) {
                $$_name = $_value; //MAGIC!
            }
            if( $mode == 'normal' ){
                require( "views/header.php" );
            }
            require( "views/$path.php" );
            if( $mode == 'normal' ){
                require( "views/footer.php" );
            }
        }
    }

?>

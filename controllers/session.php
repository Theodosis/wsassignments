<?php
    class SessionController {
        // this function is used to display the login page
        public static function View( $params ){
            Controller::View( '/session/view', $params, 'tiny' );
        }
        public static function Listing( $params ) {
        }
        // this function creates a new session and logs the user in.
        // It also sends the appropriate headers to set the login cookie
        // and redirects him to the dashboard
        public static function Create( $params ) {
            global $user;
            global $settings;
            //if ( !Controller::RequiredParameters( $params, 'username', 'password' ) ) return;
            
            $user = User::Login( $params[ 'username' ], $params[ 'password' ] );
            if( $user === false ){
                $login = false;
                Controller::View( '/session/view', compact( 'user', 'login' ), 'tiny' );
                return;
            }
            $cookie = $user[ 'id' ] . ':' . $user[ 'authtoken' ];
            $eofw = 2147483646;
            setcookie( $settings[ 'cookiename' ], $cookie, $eofw, '/', $settings[ 'domain' ], false, true );
            $_SESSION[ 'user' ] = $user;
            header( "Location: /" );
        }
        public static function Update( $params ) {
        }
        // this function logs the user out. by unsetting the authtoken and the session of a user
        // and removing the login cookie from the user. It redirects the user to the login page.
        public static function Delete( $params ) {
            global $user;
            global $settings;

            User::Logout( $user[ 'id' ] );
            setcookie( $settings[ 'cookiename' ], '', time() - 100000000, '/', $settings[ 'domain' ] );
            unset( $_SESSION[ 'user' ] );
            header( "Location: /" ); 
        }
    }
?>

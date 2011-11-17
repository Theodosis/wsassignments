<?php
    class SessionController {
        public static function View( $params ){
            Controller::View( '/session/view', $params, 'tiny' );
        }
        public static function Listing( $params ) {
        }
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

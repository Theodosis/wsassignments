<?php
    class SessionController {
        public static function View( $params ){
            Controller::View( $params );
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
                Controller::View( '/session/view', compact( 'user', 'login' ) );
                return;
            }
            $cookie = $user[ 'id' ] . ':' . $user[ 'authtoken' ];
            $eofw = 2147483646;
            setcookie( $settings[ 'cookiename' ], $cookie, $eofw, '/wsass/', $settings[ 'cookiedomain' ], false, true );
            $_SESSION[ 'user' ] = $data;
            header( "Location: /wsass/" );
        }
        public static function Update( $params ) {
        }
        public static function Delete( $params ) {
            global $user;
            global $settings;

            User::Logout( $user[ 'id' ] );
            setcookie( $settings[ 'cookiename' ], '', time() - 100000000 );
            unset( $_SESSION[ 'user' ] );
            header( "Location: /wsass/" ); 
        }
    }
?>

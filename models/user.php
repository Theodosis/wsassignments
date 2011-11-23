<?php
    // class user is responsible for user authentication.
    class User {
        // function GetCookieData extracts the login cookie of a user 
        // and returns the details of the user if logged in, false otherwise.
        public static function GetCookieData() {
            global $settings;

            if ( !isset( $_COOKIE[ $settings[ 'cookiename' ] ] ) ) {
                return false;
            }
            $cookie = $_COOKIE[ $settings[ 'cookiename' ] ];
            $cookieparts = explode( ':' , $cookie );
            if ( count( $cookieparts ) != 2 ) {
                return false;
            }
            $userid = ( int )$cookieparts[ 0 ];
            $authtoken = $cookieparts[ 1 ];
            if ( $userid <= 0 ) {
                return false;
            }
            if ( !preg_match( '#^[a-zA-Z0-9]{32}$#', $authtoken ) ) {
                throw New Exception( 'invalid auth' );
                return false;
            }
            return User::AuthtokenValidation( $userid, $authtoken );
        }

        // function AuthtokenValidation returns a user by her user id
        // and her authtoken.
        public static function AuthtokenValidation( $userid, $authtoken )  {
            if ( !is_int( $userid ) || !$userid || !$authtoken || $authtoken == "" ) {
                return false;
            }
            $res = db(
                'SELECT
                    `id`, `username`, `authtoken`, `rights`, `email`
                FROM
                    `user`
                WHERE
                    `id` = :userid AND
                    `authtoken` = :authtoken
                LIMIT 1;',
                compact( 'userid', 'authtoken' )
            );
            
            if ( mysql_num_rows( $res ) ) {
                $row = mysql_fetch_array( $res );
                $row[ 'id' ] = (int)$row[ 'id' ];
                return $row;
            }
            
            return false;
        }

        // function Login selects a user by her username and password, 
        // and sets her authtoken on success. Returns false otherwise.
        public static function Login( $username, $password ) {
            if( !$username || !$password ) {
                return false;
            }
            $res = db(
                'SELECT
                    `id`, `username`, `authtoken`, `rights`, `email`
                FROM
                    `user`
                WHERE
                    `username` = :username
                    AND `password` = MD5( :password )
                LIMIT 1',
                compact( 'username', 'password' )
            );
            if( !mysql_num_rows( $res ) ){
                return false;
            }
            $row = mysql_fetch_array( $res );
            $row[ 'id' ] = ( int )$row[ 'id' ];
            $row[ 'authtoken' ] = User::RenewAuthtoken( $row[ 'id' ] ); 

            return $row;
        }

        // function Logout clears the authtoken of a user. Thus, all sessions from all
        // places are terminated.
        public static function Logout(){
            global $user;
            $id = ( int )$user[ 'id' ];
            $res = db(
                'UPDATE `user`
                    SET
                        `authtoken`=""
                    WHERE
                        `id` = :id
                    LIMIT 1;',
                    compact( 'id' )
            );
        }
        
        // function RenewAuthtoken generates a pseudo-random string and sets user's authtoken
        // to that string.
        public static function RenewAuthtoken( $userid ) {
            $userid = ( int )$userid;

            // generate authtoken
            // first generate 16 random bytes
            // generate 8 pseurandom 2-byte sequences 
            // (that's bad but generally conventional pseudorandom generation algorithms do not allow very high limits
            // unless they repeatedly generate random numbers, so we'll have to go this way)
            $bytes = array(); // the array of all our 16 bytes
            for ( $i = 0; $i < 8 ; ++$i ) {
                $bytesequence = rand( 0, 65535 ); // generate a 2-bytes sequence
                // split the two bytes
                // lower-order byte
                $a = $bytesequence & 255; // a will be 0...255
                // higher-order byte
                $b = $bytesequence >> 8; // b will also be 0...255
                // append the bytes
                $bytes[] = $a;
                $bytes[] = $b;
            }
            // now that we have 16 "random" bytes, create a string of 32 characters,
            // each of which will be a hex digit 0...f
            $authtoken = ''; // start with an empty string
            foreach ( $bytes as $byte ) {
                // each byte is two authtoken digits
                // split them up
                $first = $byte & 15; // this will be 0...15
                $second = $byte >> 4; // this will be 0...15 again
                // convert decimal to hex and append
                // order doesn't really matter, it's all random after all
                $authtoken .= dechex( $first ) . dechex( $second );
            }
            
            db(
                'UPDATE
                    `user`
                SET
                    `authtoken`=:authtoken
                WHERE
                    `id`=:userid
                LIMIT 1', compact( 'userid', 'authtoken' )
            );

            return $authtoken;
        }
    }
?>

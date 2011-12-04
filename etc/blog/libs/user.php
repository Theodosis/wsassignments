<?php
    function getUser(){
        if( isset( $_SESSION[ 'user' ] ) ){
            return $_SESSION[ 'user' ];
        }
        return getUserByCookie();
    }
    function getUserByCookie(){
        if( $_COOKIE[ 'user' ] ){
            $parts = explode( '|', $_COOKIE[ 'user' ] );
            $id = $parts[ 0 ];
            $authtoken = $parts[ 1 ];
            return getUserByIdAndAuthtoken( $id, $authtoken );
        }
    }
    function getUserByIdAndAuthtoken( $id, $authtoken ){
        $id = mysql_real_escape_string( $id );
        $authtoken = mysql_real_escape_string( $authtoken );
        
        $res = mysql_query( "SELECT 
                                id, firstname, lastname, mail 
                            FROM 
                                user 
                            WHERE 
                                id = $id and authtoken = $authtoken;" );
        
        if( mysql_num_rows() == 0 ){
            return false;
        }
        $user = mysql_fetch_array( $res );
        return $user;
    }
?>

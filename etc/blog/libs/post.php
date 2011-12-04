<?php
    function getPosts(){
        $res = mysql_query( "SELECT 
                                * 
                            FROM 
                                post;" );
        $rows = array();
        while( $row = mysql_fetch_array( $res ) ){
            $rows[] = $row;
        }
        return $row;
    }
    function getLastPost(){
        $res = mysql_query( "SELECT 
                                * 
                            FROM 
                                post 
                            ORDER BY created DESC
                            LIMIT 1;" );
        return mysql_fetch_array( $res );
    }
    function getPost( $id ){
        $res = mysql_query( "SELECT
                                *
                            FROM
                                post
                            WHERE 
                                id = $id;" );
        return mysql_fetch_array( $res );
    }
    function createPost( $title, $text ){
        $res = mysql_query( "INSERT INTO 
                                post ( 'title', 'text' )
                            VALUES
                                ( '$title', '$text' );" );
        return mysql_insert_id();
    }
?>

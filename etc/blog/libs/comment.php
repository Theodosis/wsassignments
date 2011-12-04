<?php
    function createComment( $postid, $text ){
        mysql_query( "INSERT INTO 
                        comment ( postid, text )
                      VALUES
                        ( $postid, $text );" );
        return mysql_insert_id();
    }
    function getCommentsByPostid( $postid ){
        $res = mysql_query( "SELECT
                        *
                    FROM 
                        comment
                    WHERE 
                        postid = $postid;" );
        $rows = array();
        while( $row = mysql_fetch_array( $res ) ){
            $rows[] = $row;
        }
        return $rows;
    }
?>

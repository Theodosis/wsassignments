<?php
    global $settings;
    
    mysql_connect( $settings[ 'db' ][ 'host' ], $settings[ 'db' ][ 'user' ], $settings[ 'db' ][ 'pass' ] ) or die( mysql_error() );
    mysql_select_db( $settings[ 'db' ][ 'name' ] ) or die( mysql_error() );

    mysql_query( "SET NAMES UTF8;" );
?>

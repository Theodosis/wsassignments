<?php
    /*
        Author: Dionysis "dionyziz" Zindros <dionyziz@gmail.com>

        This file is responsible to connect to a MySQL server using credentials 
        from the settings.
        It also defines some helping functions for querying the database safely.
    */
    global $settings;

    mysql_connect( $settings[ 'db' ][ 'host' ], $settings[ 'db' ][ 'user' ], $settings[ 'db' ][ 'pass' ] ) or die( mysql_error() );
    mysql_select_db( $settings[ 'db' ][ 'name' ] ) or die( mysql_error() );

    mysql_query( "SET NAMES UTF8;" );

    // function db executes the query sql after binding the attributes bind
    // and returns a mysql resource.
    function db( $sql, $bind = false ) {
        if ( $bind == false ) {
            $bind = array();
        }
        foreach ( $bind as $key => $value ) {
            if ( is_string( $value ) ) {
                $value = addslashes( $value );
                $value = '"' . $value . '"';
            }
            else if ( is_array( $value ) ) {
                foreach ( $value as $i => $subvalue ) {
                    $value[ $i ] = addslashes( $subvalue );
                }
                $value = "('" . implode( "', '", $value ) . "')";
            }
            else if ( is_null( $value ) ) {
                $value = '""';
            }
            $bind[ ':' . $key ] = $value;
            unset( $bind[ $key ] );
        }
        $finalsql = strtr( $sql, $bind );
        $res = mysql_query( $finalsql );
        if ( $res === false ) {
            throw new Exception(
                "SQL query failed with the following error:\n\""
                . mysql_error()
                . "\"\n\nThe query given was:\n"
                . $sql
                . "\n\nThe SQL bindings were:\n"
                . print_r( $bind, true )
                . "The query executed was:\n"
                . $finalsql
            );
        }
        return $res;
    }

    // function db_array executes the query sql after binding the attributes bind
    // and returns the results in an array
    function db_array( $sql, $bind = false, $id_column = false ) {
        $res = db( $sql, $bind );
        $rows = array();
        if ( $id_column !== false ) {
            while ( $row = mysql_fetch_array( $res ) ) {
                $rows[ $row[ $id_column ] ] = $row;
            }
        }
        else {
            while ( $row = mysql_fetch_array( $res ) ) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    // function db_insert inserts a row with values on set in the specified table
    function db_insert( $table, $set ) {
        $fields = array();
        foreach ( $set as $field => $value ) {
            $fields[] = "$field = :$field";
        }
        db(
            'INSERT INTO '
            . $table
            . ' SET '
            . implode( ',', $fields ),
            $set
        );
        return mysql_insert_id();
    }
    
    // function db_delete deletes a subset of the specified table using the where array to select them
    function db_delete( $table, $where ) {
        $fields = array();
        foreach ( $where as $field => $value ) {
            $fields[] = "$field = :$field";
        }
        db(
            'DELETE FROM '
            . $table
            . ' WHERE '
            . implode( ' AND ', $fields ),
            $where
        );
        return mysql_affected_rows();
    }

    // function db_update updates a subset of the selected table using the where array, and sets 
    // the values defined by set.
    function db_update( $table, $where, $set ) {
        $wfields = array();
        $wreplace = array();
        foreach ( $where as $field => $value ) {
            $wfields[] = "$field = :where_$field";
            $wreplace[ 'where_' . $field ] = $value;
        }
        $sfields = array();
        $sreplace = array();
        foreach ( $set as $field => $value ) {
            $sfields[] = "$field = :set_$field";
            $sreplace[ 'set_' . $field ] = $value;
        }
        db(
            'UPDATE '
            . $table .
            ' SET '
            . implode( ', ', $sfields ) .
            ' WHERE '
            . implode( ' AND ', $wfields ),
            array_merge( $wreplace, $sreplace )
        );
        return mysql_affected_rows();
    }
    
    // function db_select selects a subset of the specified table, using the where array. 
    // If where is omitted it returns the whole table.
    function db_select( $table, $where = array(1=>1) ) {
        $wreplace = array();
        $wfields = array();
        foreach ( $where as $field => $value ) {
            $wfields[] = "$field = :where_$field";
            $wreplace[ 'where_' . $field ] = $value;
        }
        return db_array(
            'SELECT
                *
            FROM
                ' . $table . '
            WHERE
                ' . implode( ' AND ', $wfields ),
                $wreplace
        );
    }
    
    // function db_fetch takes a mysql resource and returns it's results into an array.
    function db_fetch( $res ) {
        $ret = array();
        while ( $row = mysql_fetch_array( $res ) ) {
            $ret[] = $row;
        }
        return $ret;
    }
?>

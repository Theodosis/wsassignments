<?php

    class Submission {
        public static function listing {
            return db_array(
                "SELECT
                    *
                FROM
                    submissions;"
            );
        }
        public static function update( $id = false, $title, $content ) {
            if ( $id == false ) {
                db(
                    "INSERT INTO
                        submissions
                    SET
                        title = '$title',
                        content = '$content';"
                );
            }
            else {
                db(
                    "UPDATE
                        submissions
                    SET
                        title = '$title',
                        content = '$content'
                    WHERE
                        id = $id;"
                );
            }
        }
        public static function delete( $id ) {
            return db(
                "DELETE FROM
                    submissions
                WHERE
                    id = $id
                LIMIT
                    1;"
            );
        }
    }

?>

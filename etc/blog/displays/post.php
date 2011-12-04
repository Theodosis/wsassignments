<?php
    function displayPosts( $posts ){
        include "head.php";
        ?><form method="post" action="index.php?page=createpost">
            <div>
                <label>Title: </label>
                <input type="text" name="title" />
            </div>
            <div>
                <textarea name="text"></textarea>
            </div>
            <div>
                <input type="submit" value="Στείλε!" />
            </div>
        </form><ul><?php
        foreach( $posts as $post ){
            ?><li id="<?php
                $post[ 'id' ];
            ?>">
                <h2><?php
                    echo $post[ 'title' ];
                ?></h2>
                <p><?php
                    echo $post[ 'text' ];
                ?></p>
            </li><?php
        }
        ?></ul><?php
        include "foot.php";
    }
    function displayPost( $post, $comments ){
        include "head.php";
        ?><h2><?php
            echo $post[ 'title' ];
        ?></h2>
        <p><?php
            echo $post[ 'text' ];
        ?></p>
        <form method="post" action="index.php?page=createcomment">
            <div>
                <label>Απάντηση</label>
                <textarea name="text"></textarea>
                <input type="hidden" name="postid" value="<?php
                    echo $post[ 'id' ];
                ?>" />
                <input type="submit" value="Σχολίασε!" />
            </div>
        </form>
        <ul><?php
            foreach( $comments as $comment ){
                ?><li id="comment_<?php
                    echo $comment[ 'id' ];
                ?>"><?php
                    echo $comment[ 'text' ];
                ?></li><?php
            }
        ?></ul><?php
        include "foot.php";
    }
?>

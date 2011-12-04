<?php
    global $settings;
    $settings = require( 'settings.php' );
    
    require_once "libs/db.php";
    require_once "libs/post.php";
    require_once "libs/comment.php";
    
    $page = 'posts';
    if( isset( $_GET[ 'page' ] ) ){
        $page = $_GET[ 'page' ];
    }
    
    switch( $page ){
        case 'posts':
            $posts = getPosts();
            displayPosts( $posts );
            break;
        case 'post':
            if( !isset( $_GET[ 'id' ] ) ){
                $post = getLastPost();
            }
            else{
                $post = getPost( $_GET[ 'id' ] );
            }
            displayPost( $post );
            break;
        case 'newpost':
            if( !isset( $_POST[ 'title' ] ) || !isset( $_POST[ 'text' ] ) ){
                die( "We need a title and a text." );
            }
            $id = createPost( $_POST[ 'title' ], $_POST[ 'text' ] );
            header( "Location http://localhost/blog/index.php?page=post&id=$id" );
            break;
        case 'newcomment':
            if( !isset( $_POST[ 'postid' ] ) || !isset( $_POST[ 'text' ] ) ){
                die( "We need the postid and a text." );
            }
            createComment( $_POST[ 'postid' ], $_POST[ 'text' ] );
            header( "Location http://localhost/blog/index.php?page=post&id=" . $_POST[ 'postid' ] );
            $post = getPost( $_POST[ 'postid' ] );
            displayPost( $post );
        default:
            die( "I could not find the page $page." );
    }
?>

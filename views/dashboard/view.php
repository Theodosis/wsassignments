<?php 
    global $user;
    if( $user[ 'rights' ] > 40 ){
        ?><a href="admin" id="crypto"></a><?php
    }
?>

<p>
    Καλωσήρθες στο σύστημα υποβολής εργασιών. 
    Σε περίπτωση που επικοινωνήσεις μαζί μας, 
    ανάφερέ μας το id σου: <?=$user[ 'id' ];?>
</p>
<div class="current">
    <h2><?php
        echo $current[ 'description' ];
    ?></h2><?php
        if( $current[ 'active' ] ){
            ?><form method="post" action="/submission/create" enctype="multipart/form-data">
                <div>
                    <label>Υποβολή εργασίας: </label>
                    <input type="file" name="file" />
                    <input type="hidden" name="assignmentid" value="<?php
                        echo $current[ 'id' ];
                    ?>" />
                </div>
            </form><?php
        }
    ?><ul class="submilist"><?php
        foreach( $submission_list as $submission ){
            ?><li class="validation_<?php 
                echo $submission[ 'validationid' ]; 
                if( isset( $results ) && $submission[ 'id' ] == $results[ 'submissionid' ] ){
                    echo " result";
                }
            ?>">
                <span class="when"><?php
                    echo date( "d/n H:i", strtotime( $submission[ 'created' ] ) + 3600 * 2 );
                ?></span>
                <span class="result"><?php
                    echo $submission[ 'status' ];
                ?></span><p><?php
                    echo htmlentities( $submission[ 'comment' ] );
                ?></p>
            </li><?php
        }
    ?></ul>
</div>
<ul class="assignmentlist"><?php
    foreach( $assignments as $assignment ){
        ?>
        <li>
            <h2 class="<?=$assignment[ 'submission_status' ];?>" title="<?=$assignment[ 'submission_description' ] ?>">
                <?=$assignment[ 'description' ];?>
            </h2>
        </li><?php
    }
?></ul>

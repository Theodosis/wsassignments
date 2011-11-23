<?php 
    global $user;
?>
<a href="/" id="back"></a>
<table>
    <thead>
        <tr>
            <th>user id</th>
            <th>first name</th>
            <th>last name</th>
            <th>email</th>
            <th>assignment</th>
            <th>validation status</th>
            <th>validation comment</th>
        </tr>
    </thead>
    <tbody><?php
        foreach( $rows as $row ){
            ?><tr>
                <td><?= $row[ 'userid' ] ?></td>
                <td><?= $row[ 'firstname' ] ?></td>
                <td><?= $row[ 'lastname' ] ?></td>
                <td><?= $row[ 'email' ] ?></td>
                <td title="<?= $row[ 'assignment' ] ?>"><?= $row[ 'assignmentid' ] ?></td>
                <td class="status"><?= $row[ 'status' ] ?></td>
                <td><?= $row[ 'comment' ] ?></td>
            </tr><?php
        }
    ?></tbody>
</table>
<script type="text/javascript">
    var validation = <?php
        echo json_encode( $validation );
    ?>;
</script>

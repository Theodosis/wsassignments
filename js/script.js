$( function(){
    $( 'input[type=file]' ).change( function(){
        $( 'form' ).submit();
    } );
    $( '#exit' ).click( function(){
        var form = document.createElement( 'form' );
        form.action = "/session/delete";
        form.method = "post";
        $( form ).appendTo( 'body' ).submit();
    });
    $( 'table' ).dataTable( {
        "iDisplayLength": 30,
        "aLengthMenu": [ 10, 30, 100, 1000 ]
    } );
    if( $( 'table' ).length ){
        $( '.status' ).live( 'click', function(){
            if( $( this ).data( 'edit' ) == 'true' ){
                return;
            }
            $( this ).data( 'edit', 'true' );
            $( this ).editable( '/submission/update', {
                data: JSON.stringify( validation ),
                type: 'select',
                submit: 'ok',
                name: 'validationid',
                submitdata: function( value, settings ){
                    return{
                        userid: $( this ).siblings( ':first' ).text(),
                        assignmentid: $( this ).prev().text()
                    };
                },
                callback: function( value, settings ){
                    console.log( [ this, value, settings ] );
                }
            } ).click();
        } );
    }
} );

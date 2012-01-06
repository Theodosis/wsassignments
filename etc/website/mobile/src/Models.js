Ext.regModel( 'FAQ', {
    fields: [
        { name: 'question', type: 'string' },
        { name: 'answer', type: 'string' }
    ]
} );

Ext.regModel('Video', {
    fields: [ 'id', 'title', 'thumbnail' ]
});

Ext.regModel('Tweet', {
    fields: ['id', 'text', 'to_user_id', 'from_user', 'created_at', 'profile_image_url']
});

WS.VideoList = Ext.extend(Ext.Panel, {
    layout: 'card',
    playlist_id: null,
    hideText: '',
    initComponent: function(){
        var toolbarBase = {
            xtype: 'toolbar',
            title: 'Βιντεοσκοπήσεις'
        };
        if ( this.prevCard !== undefined ) {
            toolbarBase.items = [ {
                ui: 'back',
                text: this.prevCard.title,
                scope: this,
                handler: function(){
                    this.ownerCt.setActiveItem(this.prevCard, { type: 'slide', reverse: true } );
                }
            } ]
        }
        
        this.dockedItems = toolbarBase;

        if ( this.playlist_id === null ) {
            console.warn( 'No Youtube playlist ID provided.' );
        }
        else {
            this.list = new Ext.List( {
                itemTpl: '<div class="thumb" style="background-image: url({thumbnail.sqDefault})"></div><span class="name">{title}</span>',
                loadingText: false,
                store: new Ext.data.Store( {
                    model: 'Video',
                    autoLoad: true,
                    proxy: {
                        type: 'scripttag',
                        url : 'http://gdata.youtube.com/feeds/api/videos?q=webseminars+THMMY&author=webseminarTHMMY&alt=jsonc&v=2',
                        reader: {
                            type: 'json',
                            root: 'data.items'
                        }
                    }
                } ),
                listeners: {
                    selectionchange: { fn: this.onSelect, scope: this }
                }
            } );
            
            this.items = this.list;
        }
        
        WS.VideoList.superclass.initComponent.call( this );
    },
    
    onSelect: function( selectModel, records ) {
        console.log( records );
        if ( records[ 0 ] !== undefined ) {

            Ext.Msg.confirm('External Link', 'Μετάβαση στο Youtube;', function( res ) {
                if( res == 'yes' ) {
                    window.location = 'http://www.youtube.com/watch?v=' + records[ 0 ].data.id + '&feature=player_embedded';
                }
                
                selectModel.deselectAll();
            }, this);
            
        }
    }
} );

Ext.reg( 'videolist', WS.VideoList );
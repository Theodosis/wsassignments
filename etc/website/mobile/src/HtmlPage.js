WS.HtmlPage = Ext.extend( Ext.Panel, {
    scroll: 'vertical',
    styleHtmlContent: true,
    initComponent: function(){
        
        var toolbarBase = {
            xtype: 'toolbar',
            title: this.head ? this.head : this.title
        };
        
        if( this.prevCard !== undefined ) {
            toolbarBase.items = {
                ui: 'back',
                text: this.prevCard.title,
                scope: this,
                handler: function(){
                    this.ownerCt.setActiveItem( this.prevCard, { type: 'slide', reverse: true } );
                }
            }
        }
        if( !this.nobar ) {
            this.dockedItems = toolbarBase;
        }
        Ext.Ajax.request( {
            url: this.url,
            success: function(rs){
                this.update( rs.responseText ); 
                
                Ext.select( 'a[href^=h]' ).addListener( 'click', function( ev, a ){
                    Ext.Msg.confirm('External Link', 'Navigate away?', function( res ){
                        if (res == 'yes') {
                            window.location = a.href;
                        }
                    } );
                    ev.stopEvent();
                } );
                this.after && this.after();
            },
            scope: this
        } );
        WS.HtmlPage.superclass.initComponent.call( this );
    }
} );

Ext.reg( 'htmlpage', WS.HtmlPage );

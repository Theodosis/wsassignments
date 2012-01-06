WS.FAQ = Ext.extend( Ext.Panel, {
    scroll: 'vertical',
    items: [{
        xtype: 'list',
        scroll: false,
        itemTpl: '<span data-answer="{answer}">{question}</span>',
        listeners: {
            itemtap: function( list, index, item ){
                var question = item.querySelector( 'span' ).innerText;
                var answer = item.querySelector( 'span' ).attributes[ 0 ].value;
                new Ext.Panel({
                    id: 'faqentry',
                    cls: 'faqentry',
                    scroll: 'vertical',
                    html:"<h3>" + question + "</h3><div>" + answer + "</div>",
                    fullscreen: true,
                    padding: '50px 0px',
                });
                var tb = list.ownerCt.dockedItems.get( 0 );
                tb.add({
                    text: 'back',
                    ui: 'back',
                    handler: function( a, b, c, d ){
                        window.a = a;
                        a.destroy();
                        document.body.removeChild( window.faqentry );
                    }
                });
                tb.doLayout();
            }
        },
    }],
    listeners: {
        show: function(){
            WS.App.addListener( 'beforecardswitch', function(){
                var button = WS.App.query( 'faq' )[ 0 ].dockedItems.get( 0 ).items.items[ 0 ];
                button && button.destroy();
                window.faqentry && document.body.removeChild( window.faqentry );
            } );
        }
    },

    initComponent: function(){
        var toolbarBase = {
            xtype: 'toolbar',
            title: this.title,
            dock: 'top'
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
        this.dockedItems = toolbarBase;
        
        this.items[ 0 ].store = this.store;
        Ext.Ajax.request( {
            url: this.url,
            success: function(rs){
                var div = document.createElement( 'div' );
                div.innerHTML = rs.responseText;
                window.div = div;
                var questions = div.querySelectorAll( 'ul.questionlist > li' );
                var items = [];
                window.questions = questions;
                for( var i = 0; i < questions.length; ++i ){
                    var q = questions[ i ];
                    window.q = q;
                    items.push( {
                        question: q.querySelector( 'h3' ).innerText,
                        answer: q.querySelector( 'div' ).innerHTML
                    } );
                }
                this.items.items[ 0 ].store.loadData( items );
                this.items.items[ 0 ].doComponentLayout();
            },
            scope: this
        } );
        WS.FAQ.superclass.initComponent.call( this );
    }
} );

Ext.reg( 'faq', WS.FAQ );

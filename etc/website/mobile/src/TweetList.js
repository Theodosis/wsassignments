WS.TweetList = Ext.extend(Ext.Panel, {
    hashtag: '',
    layout: 'fit',
    initComponent: function(){
        
        var toolbarBase = {
            xtype: 'toolbar',
            title: this.hashtag
        };
        
        if (this.prevCard !== undefined) {
            toolbarBase.items = [{
                ui: 'back',
                text: this.prevCard.title,
                scope: this,
                handler: function(){
                    this.ownerCt.setActiveItem(this.prevCard, { type: 'slide', reverse: true });
                }
            }]
        }
        
        this.dockedItems = toolbarBase;
        
        this.list = new Ext.List({
            itemTpl: new Ext.XTemplate('<div class="avatar"<tpl if="profile_image_url"> style="background-image: url({profile_image_url})"</tpl>></div> <div class="tweet"><strong>{from_user}</strong><tpl if="to_user"> &raquo; {to_user}</tpl><br />{text:this.linkify}</div>', {
                linkify: function(value) {
                    return value.replace(/(http:\/\/[^\s]*)/g, "<span class=\"link\" href=\"$1\">$1</span>");
                }
            }),
            loadingText: false,
            store: new Ext.data.Store({
                model: 'Tweet',
                proxy: {
                    type: 'scripttag',
                    url : 'http://search.twitter.com/search.json',
                    reader: {
                        type: 'json',
                        root: 'results'
                    }
                }
            }),
            listeners:{
                selectionchange: function( model, records ){
                    var that = this;
                    setTimeout( function(){ that.deselect( records ) }, 300 );
                }
            } 
        } );
        
        this.items = [this.list];
        
        this.list.on('afterrender', this.loadStore, this);
        
        WS.TweetList.superclass.initComponent.call(this);
    },
    loadStore: function(){
        
        this.list.el.mask('<span class="top"></span><span class="right"></span><span class="bottom"></span><span class="left"></span>', 'x-spinner', false);
        
        this.list.store.load({
            params: {
                q: WS.App.twitterSearch
            },
            callback: function(data){
                this.list.el.unmask();
            },
            scope: this
        });
        
    }
});

Ext.reg('tweetlist', WS.TweetList);

WS.LocationMap = Ext.extend(Ext.Panel, {
    mapText: '',
    permLink: '',
    initComponent: function(){
        this.coords = WS.App.gmapCoords;
        this.mapText = WS.App.gmapText;
        this.permLink = WS.App.gmapLink;
        var position = new google.maps.LatLng(this.coords[0], this.coords[1]);
        
        this.dockedItems = [{
            xtype: 'toolbar',
            title: 'Τοποθεσία',
            items: [{
                ui: 'back',
                text: this.prevCard.title,
                scope: this,
                handler: function(){
                    this.ownerCt.setActiveItem(this.prevCard, {
                        type: 'slide',
                        reverse: true,
                        scope: this,
                        after: function(){
                            this.destroy();
                        }
                    });
                }
            }, {
                xtype: 'spacer', 
                flex: 1
            }, {
                ui: 'plain',
                iconCls: 'action',
                iconMask: true,
                scope: this,
                handler: function(){
                    
                    Ext.Msg.confirm('External Link', 'Go to Google Maps?', function(res){
                        if (res == 'yes') window.location = this.permLink;
                    }, this);
                }
            }]
        }]
        
        var infowindow = new google.maps.InfoWindow({
            content: this.mapText
        });
        
        this.map = new Ext.Map({
            mapOptions : {
                center : position,
                zoom: 16,
                navigationControlOptions: {
                    style: google.maps.NavigationControlStyle.DEFAULT
                }
            },
            listeners: {
                maprender : function(comp, map){
                    var marker = new google.maps.Marker({
                         position: position,
                         title : 'ΤΗΜΜΥ, ΑΠΘ',
                         map: map
                    });

                    infowindow.open(map, marker);

                    google.maps.event.addListener(marker, 'click', function() {
                         infowindow.open(map, marker);
                    });
                }
            }
        });
        
        this.items = this.map;
        
        WS.LocationMap.superclass.initComponent.call(this);
    }
});

Ext.reg('location', WS.LocationMap);

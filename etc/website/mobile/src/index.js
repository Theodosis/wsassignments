Ext.ns( 'WS' );

var FAQstore = new Ext.data.Store({
    model: 'FAQ',
    data: []
});

Ext.setup({
    statusBarStyle: 'black',
    onReady: function() {
        var loading = document.getElementById( 'loading' );
        loading.parentNode.removeChild( loading );
        
        WS.App = new WS.App({
            id: "Application",
            title: 'Ανάπτυξη Web και Mobile Εφαρμογών',
            twitterSearch: 'webseminarTHMMY',
            gmapLink: 'http://maps.google.com/maps?q=ΑΠΘ+Θεσσαλονίκη+Ελλάδα&hl=en&ll=40.628651, 22.958306&s%20&t=m&z=16&vpsrc=6',
            gmapText: 'Μικρό αμφιθέατρο Πολυτεχνικής Σχολής, ΑΠΘ',
            gmapCoords: [ 40.628651, 22.958306 ],
            aboutPages: [{
                title: "FAQ",
                card: {
                    id: 'faq',
                    iconCls: 'faq',
                    xtype: "faq",
                    store: FAQstore,
                    url: 'http://webseminars.ee.auth.gr/faq.html'
                }
            },
             {
                title: 'Βιντεοσκοπήσεις',
                card: {
                    id: 'videos',
                    xtype: 'videolist',
                    playlist_id: 'webseminarTHMMY'
                }
            }, {
                title: 'Tweets',
                card: {
                    id: 'tweets',
                    xtype: 'tweetlist',
                    hashTag: 'webseminarTHMMY'
                }
            }, {
                title: 'Τοποθεσία',
                card: {
                    id: 'videos',
                    title: 'Τοποθεσία',
                    iconCls: 'locate',
                    xtype: 'location',
                }
            }, {
                title: 'Βιβλιογραφία',
                card: {
                    id: 'reference',
                    title: "Βιβλιογραφία",
                    iconCls: 'reference',
                    xtype: 'htmlpage',
                    url: 'http://webseminars.ee.auth.gr/reference.html'
                }
            }]
        });
    }
});

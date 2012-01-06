WS.App = Ext.extend( Ext.TabPanel, {
    fullscreen: true,
    tabBar: {
        dock: 'bottom',
        layout: { pack: 'center' }
    },
    cardSwitchAnimation: false,
    initComponent: function() {
        this.items = [ {
            id: 'home',
            head: 'Ανάπτυξη Web και Mobile Εφαρμογών',
            title: 'Ανακοινώσεις',
            iconCls: 'home',
            xtype: 'htmlpage',
            url: 'home.php',
        }, {
            title: "Οργανωτικά",
            id: 'about',
            iconCls: 'about',
            xtype: 'htmlpage',
            url: 'http://webseminars.ee.auth.gr/about.html',
            after: function(){
                document.querySelectorAll( '.credits' )[ 0 ].innerHTML = '<p>Ο σχεδιασμός της παρούσας εφαρμογής έγινε από το Θεοδόση Σουργκούνη, με χρήση του <a href="http://www.sencha.com/products/touch">Sencha Touch</a> &mdash; Ένα καινούριο framework για web εφαρμογές χτισμένο με HTML5, CSS3 και JavaScript.</p>';
            }
        }, /*{
            title: 'Βιβλιογραφία',
            id: 'reference',
            iconCls: 'reference',
            xtype: 'htmlpage',
            url: 'http://webseminars.ee.auth.gr/reference.html'
        }, */{
            id: 'lectures',
            title: 'Διαλέξεις',
            iconCls: 'lectures',
            xtype: 'htmlpage',
            url: 'http://webseminars.ee.auth.gr/lectures.html'
        }, {
            id: 'assignments',
            title: 'Εργασίες',
            iconCls: 'assignments',
            xtype: 'htmlpage',
            url: 'http://webseminars.ee.auth.gr/assignments.html'
        }, /*{
            id: 'faq',
            title: "FAQ",
            iconCls: 'faq',
            xtype: "faq",
            store: FAQstore,
            url: 'http://webseminars.ee.auth.gr/faq.html'
        },*/ {
            id: 'more',
            title: 'Περισσότερα',
            xtype: 'aboutlist',
            iconCls: 'more',
            pages: this.aboutPages
        } ];
        WS.App.superclass.initComponent.call(this);
    },
});

Ext.onReady(function() {
    MODx.load({
        xtype: 'simpleab-page-home',
        renderTo: 'simpleab-wrapper-div'
    });
    MODx.config.help_url = 'http://rtfm.modx.com/display/ADDON/SimpleAB';
});

SimpleAB.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        cls: 'container form-with-labels',
        border: false,
        components: [{
            xtype: 'panel',
            html: '<h2>' + _('simpleab.home') + '</h2>',
            border: false,
            cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs',
            width: '98%',
            border: true,
            defaults: {
                border: false,
                autoHeight: true,
                defaults: {
                    border: false
                }
            },
            items: [{
                title: _('simpleab.tests'),
                cls: 'main-wrapper',
                items: [{
                    xtype: 'simpleab-grid-tests'
                }]
            }]
        },SimpleAB.attribution()]
    });
    SimpleAB.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(SimpleAB.page.Home,MODx.Component,{

});
Ext.reg('simpleab-page-home',SimpleAB.page.Home);

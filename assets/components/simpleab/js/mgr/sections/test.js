Ext.onReady(function() {
    MODx.load({
        xtype: 'simpleab-page-test',
        renderTo: 'simpleab-wrapper-div'
    });
    MODx.config.help_url = 'http://rtfm.modx.com/display/ADDON/SimpleAB';
});

SimpleAB.page.Test = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        cls: 'container form-with-labels',
        border: false,
        components: [{
            xtype: 'panel',
            html: '<h2>' + _('simpleab.manage_test.title', {name: SimpleAB.record.name}) + '</h2>',
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
                },
                cls: 'main-wrapper'
            },
            items: [{
                title: _('simpleab.statistics'),
                items: [{
                    xtype: 'panel',
                    html: '<h3>'+_('simpleab.normalized')+'</h3>'
                },{
                    xtype: 'linechart',
                    id: 'simpleab-statistics-normalized',
                    xField: 'period',
                    yField: 'clicks',
                    height: 200,
                    series: SimpleAB.chartSeries,
                    store: new Ext.data.JsonStore({
                        url: SimpleAB.config.connectorUrl
                        ,baseParams: {
                            action: 'mgr/test/stats/normalized'
                        }
                        ,fields: ['period', 'clicks']
                        ,autoLoad: true
                        ,root: 'results'
                    })
                },{
                    xtype: 'panel',
                    html: '<h3>'+_('simpleab.conversions')+'</h3>'
                },{
                    xtype: 'linechart',
                    id: 'simpleab-statistics-conversions',
                    xField: 'period',
                    yField: 'clicks',
                    height: 200,
                    series: SimpleAB.chartSeries,
                    store: new Ext.data.JsonStore({
                        url: SimpleAB.config.connectorUrl
                        ,baseParams: {
                            action: 'mgr/test/stats/conversions'
                        }
                        ,fields: ['period', 'clicks']
                        ,autoLoad: true
                        ,root: 'results'
                    })
                },{
                    xtype: 'panel',
                    html: '<h3>'+_('simpleab.picks')+'</h3>'
                },{
                    xtype: 'linechart',
                    id: 'simpleab-statistics-picks',
                    xField: 'period',
                    yField: 'clicks',
                    height: 200,
                    series: SimpleAB.chartSeries,
                    store: new Ext.data.JsonStore({
                        url: SimpleAB.config.connectorUrl
                        ,baseParams: {
                            action: 'mgr/test/stats/picks'
                        }
                        ,fields: ['period', 'clicks']
                        ,autoLoad: true
                        ,root: 'results'
                    })
                }]
            },{
                title: _('simpleab.variations'),
                items: [{
                    xtype: 'simpleab-grid-variations'
                }]
            }]
        }]
    });
    SimpleAB.page.Test.superclass.constructor.call(this,config);
};
Ext.extend(SimpleAB.page.Test,MODx.Component,{

});
Ext.reg('simpleab-page-test',SimpleAB.page.Test);

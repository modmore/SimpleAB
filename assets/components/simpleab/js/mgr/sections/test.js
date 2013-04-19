Ext.onReady(function() {
    MODx.load({
        xtype: 'simpleab-page-test',
        renderTo: 'simpleab-wrapper-div'
    });
    MODx.config.help_url = 'http://rtfm.modx.com/display/ADDON/SimpleAB';
});

var chartStyles = {
    legend: {
        display: 'right'
    }
};
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
                    layout: 'column',
                    border: false,
                    items: [{
                        columnWidth: .2,
                        border: false,
                        items: [{
                            xtype: 'panel',
                            html: '<h3>'+_('simpleab.normalized')+'</h3>' +
                                '<p>'+_('simpleab.normalized.desc')+'</p>',
                            border: false
                        }]
                    },{
                        columnWidth: .8,
                        border: false,
                        items: [{
                            xtype: 'linechart',
                            id: 'simpleab-statistics-normalized',
                            extraStyle: chartStyles,
                            height: 200,
                            xField: 'period',
                            series: SimpleAB.chartSeries,
                            store: new Ext.data.JsonStore({
                                url: SimpleAB.config.connectorUrl,
                                baseParams: {
                                    action: 'mgr/tests/stats/normalized',
                                    test: SimpleAB.record.id
                                },
                                autoLoad: true,
                                fields: SimpleAB.chartFields,
                                idProperty: 'period',
                                root: 'results'
                            })
                        }]
                    }]
                },{
                    layout: 'column',
                    border: false,
                    items: [{
                        columnWidth: .2,
                        border: false,
                        items: [{
                            xtype: 'panel',
                            html: '<h3>'+_('simpleab.conversions')+'</h3>' +
                                '<p>'+_('simpleab.conversions.desc')+'</p>',
                            border: false
                        }]
                    },{
                        columnWidth: .8,
                        border: false,
                        items: [{
                            xtype: 'linechart',
                            id: 'simpleab-statistics-conversions',
                            extraStyle: chartStyles,
                            height: 200,
                            xField: 'period',
                            series: SimpleAB.chartSeries,
                            store: new Ext.data.JsonStore({
                                url: SimpleAB.config.connectorUrl,
                                baseParams: {
                                    action: 'mgr/tests/stats/conversions',
                                    test: SimpleAB.record.id
                                },
                                autoLoad: true,
                                fields: SimpleAB.chartFields,
                                idProperty: 'period',
                                root: 'results'
                            })
                        }]
                    }]
                },{
                    layout: 'column',
                    border: false,
                    items: [{
                        columnWidth: .2,
                        border: false,
                        items: [{
                            xtype: 'panel',
                            html: '<h3>'+_('simpleab.picks')+'</h3>' +
                                '<p>'+_('simpleab.picks.desc')+'</p>',
                            border: false
                        }]
                    },{
                        columnWidth: .8,
                        border: false,
                        items: [{
                            xtype: 'linechart',
                            id: 'simpleab-statistics-picks',
                            extraStyle: chartStyles,
                            height: 200,
                            xField: 'period',
                            series: SimpleAB.chartSeries,
                            store: new Ext.data.JsonStore({
                                url: SimpleAB.config.connectorUrl,
                                baseParams: {
                                    action: 'mgr/tests/stats/picks',
                                    test: SimpleAB.record.id
                                },
                                autoLoad: true,
                                fields: SimpleAB.chartFields,
                                idProperty: 'period',
                                root: 'results'
                            })
                        }]
                    }]
                }]
            },{
                title: _('simpleab.variations'),
                items: [{
                    xtype: 'panel',
                    id: 'simpleab-panel-refresh',
                    hidden: true,
                    html: '<p style="border: 1px solid red; padding: 5px; background-color: #ff9d00;">'+_('simpleab.refresh_to_update')+'</p>'
                },{
                    xtype: 'simpleab-grid-variations'
                }]
            }]
        }],
        buttons: [{
            text: _('simpleab.update_test'),
            handler: this.updateTest
        },'-',{
            text: _('simpleab.archive_test'),
            handler: this.archiveTest
        },'-',{
            text: _('simpleab.clear_test_data'),
            handler: this.clearTestData
        },'-',{
            text: _('simpleab.to_home'),
            handler: this.toHome
        }]
    });
    SimpleAB.page.Test.superclass.constructor.call(this,config);
};
Ext.extend(SimpleAB.page.Test,MODx.Component,{
    toHome: function() {
        MODx.loadPage(MODx.request.a);
    },

    updateTest: function() {
        var record = SimpleAB.record;
        var win = MODx.load({
            xtype: 'simpleab-window-test',
            isUpdate: true,
            record: record,
            listeners: {
                success: {fn: function() {
                    location.href = location.href;
                },scope: this},
                scope: this
            }
        });
        win.setValues(record);
        win.show();
    },

    clearTestData: function() {
        var record = SimpleAB.record;
        var win = MODx.load({
            xtype: 'simpleab-window-clear-test-data',
            isUpdate: true,
            record: record,
            listeners: {
                success: {fn: function() {
                    location.href = location.href;
                },scope: this},
                scope: this
            }
        });
        win.setValues(record);
        win.show();
    }
});
Ext.reg('simpleab-page-test',SimpleAB.page.Test);

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
                title: _('simpleab.variations'),
                items: [{
                    xtype: 'panel',
                    id: 'simpleab-panel-refresh',
                    hidden: true,
                    html: '<p style="border: 1px solid red; padding: 5px; background-color: #ff9d00;">'+_('simpleab.refresh_to_update')+'</p>'
                },{
                    xtype: 'simpleab-grid-variations'
                }]
            },{
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
            }]
        },SimpleAB.attribution()],
        buttons: [{
            text: _('simpleab.update_test'),
            handler: this.updateTest,
            hidden: !SimpleAB.config.isAdmin
        },'-',{
            text: parseInt(SimpleAB.record.archived) ? _('simpleab.unarchive_test') :  _('simpleab.archive_test'),
            handler: parseInt(SimpleAB.record.archived) ? this.unArchiveTest : this.archiveTest,
            hidden: !SimpleAB.config.isAdmin
        },'-',{
            text: _('simpleab.clear_test_data'),
            handler: this.clearTestData,
            hidden: !SimpleAB.config.isAdmin
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
    },

    archiveTest: function() {
        MODx.msg.confirm({
            title: _('simpleab.archive_test'),
            text: _('simpleab.archive_test.confirm'),
            url: SimpleAB.config.connectorUrl,
            params: {
                action: 'mgr/tests/archive',
                id: SimpleAB.record.id
            },
            listeners: {
                'success':{fn: function(r) {
                    MODx.loadPage(MODx.request.a);
                },scope: this}
            }
        });
    },

    unArchiveTest: function() {
        MODx.msg.confirm({
            title: _('simpleab.unarchive_test'),
            text: _('simpleab.unarchive_test.confirm'),
            url: SimpleAB.config.connectorUrl,
            params: {
                action: 'mgr/tests/unarchive',
                id: SimpleAB.record.id
            },
            listeners: {
                'success':{fn: function(r) {
                    MODx.loadPage(MODx.request.a,'id='+SimpleAB.record.id);
                },scope: this}
            }
        });
    }
});
Ext.reg('simpleab-page-test',SimpleAB.page.Test);

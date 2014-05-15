SimpleAB.window.Test = function(config) {
    config = config || {};
    config.id = config.id || Ext.id();
    config.record = config.record || { type: 'modTemplate' };

    Ext.applyIf(config,{
        title: (config.isUpdate) ? _('simpleab.update_test') : _('simpleab.add_test')
        ,url: SimpleAB.config.connectorUrl
        ,autoHeight: true
        ,baseParams: { action: 'mgr/tests/' + ((config.isUpdate) ? 'update' : 'create') }
        ,width: 550
        ,modal: true
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            xtype: 'hidden'
            ,name: 'type'
        },{
            layout: 'column'
            ,border: false
            ,defaults: { layout: 'form' ,border: false }
            ,items: [{
                columnWidth:.5
                ,items: [{
                    xtype: 'textfield'
                    ,name: 'name'
                    ,fieldLabel: _('simpleab.name') + '*'
                    ,allowBlank: false
                    ,maxLength: 75
                    ,anchor: '100%'
                },{
                    xtype: 'textfield'
                    ,name: 'resources'
                    ,fieldLabel: _('simpleab.apply_to_resources')
                    ,description: _('simpleab.apply_to_resources.desc')
                    ,anchor: '100%'
                    ,allowBlank: true
                    ,hidden: !(config.record.type == 'modTemplate')
                }]
            },{
                columnWidth:.5
                ,items: [{
                    xtype: 'statictextfield'
                    ,name: 'type_name'
                    ,fieldLabel: _('simpleab.type')
                    ,anchor: '100%'
                    ,submitValue: true
                    ,value: _('simpleab.type_' + config.record.type)
                },{
                    xtype: 'textfield'
                    ,name: 'templates'
                    ,fieldLabel: _('simpleab.apply_to_templates')
                    ,description: _('simpleab.apply_to_templates.desc')
                    ,anchor: '100%'
                    ,allowBlank: true
                    ,hidden: !(config.record.type == 'modTemplate')
                }]
            }]
        },{
            xtype: 'textarea'
            ,name: 'description'
            ,fieldLabel: _('simpleab.description')
            ,anchor: '100%'
            ,maxLength: 500
            ,allowBlank: true
        },{
            xtype: 'xcheckbox'
            ,name: 'active'
            ,boxLabel: _('simpleab.active')
        },{
            xtype: 'xcheckbox'
            ,name: 'archived'
            ,boxLabel: _('simpleab.archived')
        },{
            id: config.id + '-smartoptimize-toggle'
            ,xtype: 'checkbox'
            ,name: 'smartoptimize'
            ,boxLabel: _('simpleab.smartoptimize')
            ,listeners: {
                'check': { fn: function(fld, checked) {
                    var flds = Ext.getCmp(config.id + '-smartoptimize');
                    if (checked) {
                        flds.show();
                    } else {
                        flds.hide();
                    }
                } ,scope: this }
            }
        },{
            id: config.id + '-smartoptimize'
            ,hidden: true
            ,layout: 'column'
            ,border: false
            ,defaults: { layout: 'form' }
            ,items: [{
                columnWidth:.5
                ,items: [{
                    xtype: 'numberfield'
                    ,name: 'threshold'
                    ,fieldLabel: _('simpleab.threshold')
                    ,description: _('simpleab.threshold.desc')
                    ,value: 100
                    ,allowBlank: false
                    ,minValue: 0
                    ,anchor: '100%'
                }]
            },{
                columnWidth:.5
                ,items: [{
                    xtype: 'numberfield'
                    ,name: 'randomize'
                    ,fieldLabel: _('simpleab.randomize')
                    ,description: _('simpleab.randomize.desc')
                    ,value: 25
                    ,allowBlank: false
                    ,minValue: 0
                    ,maxValue: 100
                    ,anchor: '100%'
                }]
            }]
        }],
        keys: [] //prevent enter in textarea from firing submit
    });
    SimpleAB.window.Test.superclass.constructor.call(this,config);
};
Ext.extend(SimpleAB.window.Test,MODx.Window, {
    triggerOptimizeBox: function() {
        var toggle = Ext.getCmp(this.config.id + '-smartoptimize-toggle');
        toggle.fireEvent('check', toggle, toggle.getValue());
    }
});
Ext.reg('simpleab-window-test',SimpleAB.window.Test);


SimpleAB.window.ClearTestData = function(config) {
    config = config || {};
    config.id = config.id || Ext.id();

    Ext.applyIf(config,{
        title: _('simpleab.clear_test_data')
        ,autoHeight: true
        ,url: SimpleAB.config.connectorUrl
        ,baseParams: { action: 'mgr/tests/cleardata' }
        ,width: 550
        ,modal: true
        ,fields: [{
            xtype: 'statictextfield'
            ,name: 'id'
            ,fieldLabel: 'Test ID'
            ,submitValue: true
        },{
            html: '<p>'+_('simpleab.clear_test_data_warning')+'</p>'
        },{
            xtype: 'xcheckbox'
            ,name: 'clear_conversions'
            ,boxLabel: _('simpleab.clear_conversions')
        },{
            xtype: 'xcheckbox'
            ,name: 'clear_picks'
            ,boxLabel: _('simpleab.clear_picks')
        },{
            xtype: 'xcheckbox'
            ,name: 'clear_variations'
            ,boxLabel: _('simpleab.clear_variations')
        }],
        keys: [] //prevent enter from firing submit as this is an important action
    });
    SimpleAB.window.ClearTestData.superclass.constructor.call(this,config);
};
Ext.extend(SimpleAB.window.ClearTestData,MODx.Window);
Ext.reg('simpleab-window-clear-test-data',SimpleAB.window.ClearTestData);


SimpleAB.window.DuplicateTest = function(config) {
    config = config || {};
    config.id = config.id || Ext.id();

    Ext.applyIf(config,{
        title: _('simpleab.duplicate_test')
        ,autoHeight: true
        ,url: SimpleAB.config.connectorUrl
        ,baseParams: { action: 'mgr/tests/duplicate'}
        ,width: 300
        ,modal: true
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            xtype: 'textfield'
            ,name: 'name'
            ,fieldLabel: _('simpleab.name')
            ,allowBlank: false
            ,anchor: '100%'
        },{
            xtype: 'xcheckbox'
            ,name: 'duplicate_data'
            ,boxLabel: _('simpleab.duplicate_data')
        }]
    });
    SimpleAB.window.DuplicateTest.superclass.constructor.call(this,config);
};
Ext.extend(SimpleAB.window.DuplicateTest,MODx.Window);
Ext.reg('simpleab-window-duplicate-test',SimpleAB.window.DuplicateTest);

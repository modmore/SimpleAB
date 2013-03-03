SimpleAB.window.Test = function(config) {
    config = config || {};
    config.id = config.id || Ext.id(),
    Ext.applyIf(config,{
        title: (config.isUpdate) ? _('simpleab.update_test') : _('simpleab.add_test'),
        autoHeight: true,
        url: SimpleAB.config.connectorUrl,
        baseParams: {
            action: 'mgr/tests/' + ((config.isUpdate) ? 'update' : 'create')
        },
        width: 400,
        fields: [{
            xtype: 'panel',
            html: '<p>'+_('simpleab.update_test.description')+'</p>',
            hidden: !config.isUpdate
        },{
            xtype: 'hidden',
            name: 'id'
        },{
            layout: 'column',
            border: false,
            defaults: {
                layout: 'form'
            },
            items: [{
                columnWidth:.5,
                items: [{
                    xtype: 'textfield',
                    name: 'name',
                    fieldLabel: _('simpleab.name') + '*',
                    allowBlank: false,
                    maxLength: 75,
                    anchor: '100%'
                },{
                    xtype: 'numberfield',
                    name: 'threshold',
                    fieldLabel: _('simpleab.threshold'),
                    description: _('simpleab.threshold.desc'),
                    value: 100,
                    allowBlank: false,
                    minValue: 0
                },{
                    xtype: 'numberfield',
                    name: 'randomize',
                    fieldLabel: _('simpleab.randomize'),
                    description: _('simpleab.randomize.desc'),
                    value: 25,
                    allowBlank: false,
                    minValue: 0,
                    maxValue: 100
                }]
            },{
                columnWidth:.5,
                border: false,
                items: [{
                    xtype: 'statictextfield',
                    name: 'type',
                    fieldLabel: _('simpleab.type'),
                    anchor: '100%',
                    submitValue: true,
                    value: 'modTemplate'
                },{
                    xtype: 'textfield',
                    name: 'resources',
                    fieldLabel: _('simpleab.apply_to_resources'),
                    description: _('simpleab.apply_to_resources.desc'),
                    anchor: '100%',
                    allowBlank: true
                },{
                    xtype: 'textfield',
                    name: 'templates',
                    fieldLabel: _('simpleab.apply_to_templates'),
                    description: _('simpleab.apply_to_templates.desc'),
                    anchor: '100%',
                    allowBlank: true
                }]
            }]
        },{
            xtype: 'textarea',
            name: 'description',
            fieldLabel: _('simpleab.description'),
            anchor: '100%',
            maxLength: 500,
            allowBlank: true
        },{
            xtype: 'checkbox',
            name: 'active',
            boxLabel: _('simpleab.active')
        }],
        keys: [] //prevent enter in textarea from firing submit
    });
    SimpleAB.window.Test.superclass.constructor.call(this,config);
};
Ext.extend(SimpleAB.window.Test,MODx.Window);
Ext.reg('simpleab-window-test',SimpleAB.window.Test);

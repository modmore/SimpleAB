SimpleAB.window.Test = function(config) {
    config = config || {};
    config.id = config.id || Ext.id(),
    Ext.applyIf(config,{
        title: _('simpleab.add_test'),
        autoHeight: true,
        url: SimpleAB.config.connectorUrl,
        baseParams: {
            action: 'mgr/tests/create'
        },
        width: 400,
        fields: [{
            xtype: 'textfield',
            name: 'name',
            fieldLabel: _('simpleab.name') + '*',
            allowBlank: false,
            maxLength: 75,
            anchor: '100%'
        },{
            xtype: 'textarea',
            name: 'description',
            fieldLabel: _('simpleab.description'),
            anchor: '100%',
            maxLength: 500,
            allowBlank: true
        },{
            xtype: 'textfield',
            name: 'type',
            fieldLabel: _('simpleab.type'),
            anchor: '100%'
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

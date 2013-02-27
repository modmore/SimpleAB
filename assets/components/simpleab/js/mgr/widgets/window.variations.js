SimpleAB.window.Variation = function(config) {
    config = config || {};
    config.id = config.id || Ext.id(),
    Ext.applyIf(config,{
        title: (config.isUpdate) ? _('simpleab.update_variation') : _('simpleab.add_variation'),
        autoHeight: true,
        url: SimpleAB.config.connectorUrl,
        baseParams: {
            action: 'mgr/variations/' + ((config.isUpdate) ? 'update' : 'create')
        },
        width: 400,
        fields: [{
            xtype: 'hidden',
            name: 'id'
        },{
            xtype: 'hidden',
            name: 'test',
            value: SimpleAB.record.id
        },{
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
            xtype: 'modx-combo-template',
            name: 'element',
            hiddenName: 'element',
            fieldLabel: _('simpleab.element'),
            anchor: '100%'
        },{
            xtype: 'checkbox',
            name: 'active',
            boxLabel: _('simpleab.active')
        }],
        keys: [] //prevent enter in textarea from firing submit
    });
    SimpleAB.window.Variation.superclass.constructor.call(this,config);
};
Ext.extend(SimpleAB.window.Variation,MODx.Window);
Ext.reg('simpleab-window-variation',SimpleAB.window.Variation);

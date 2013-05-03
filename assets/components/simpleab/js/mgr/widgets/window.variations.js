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

SimpleAB.window.PreviewVariation = function(config) {
    config = config || {};
    config.id = config.id || Ext.id(),
    Ext.applyIf(config,{
        title: _('simpleab.preview_variation'),
        saveBtnText: _('simpleab.preview_variation'),
        autoHeight: true,
        url: SimpleAB.config.connectorUrl,
        baseParams: {
            action: 'mgr/variations/preview'
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
            xtype: 'statictextfield',
            name: 'test_name',
            fieldLabel: _('simpleab.test'),
            anchor: '100%',
            value: SimpleAB.record.name
        },{
            xtype: 'statictextfield',
            name: 'name',
            fieldLabel: _('simpleab.variation'),
            anchor: '100%'
        },{
            xtype: 'textfield',
            name: 'resource',
            fieldLabel: _('simpleab.resource'),
            anchor: '100%',
            value: SimpleAB.record.resources.split(',')[0]
        }],
        listeners: {
            success: {
                fn: function(r) {
                    window.open(r.a.result.message);
                    MODx.msg.alert(_('simpleab.preview_variation'), '<p>The requested preview should have opened in a new window or tab. If not, <a href="' + r.a.result.message + '" target="_blank">please use this link.</a></p>');
                },
                scope: this
            }
        }
    });
    SimpleAB.window.PreviewVariation.superclass.constructor.call(this,config);
};
Ext.extend(SimpleAB.window.PreviewVariation,MODx.Window, {
    previewVariation: function() {
        var form = this.fp.getForm(),
            values = form.getValues();
        console.log(form, values);
    }
});
Ext.reg('simpleab-window-preview-variation',SimpleAB.window.PreviewVariation);

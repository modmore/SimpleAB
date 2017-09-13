SimpleAB.combo.Chunks = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: SimpleAB.config.connectorUrl,
        baseParams: {
            action: 'mgr/chunks/getlist',
            combo: true
        },
        fields: ['id', 'name'],
        hiddenName: config.name,
        paging: true,
        pageSize: 20,
        valueField: 'id',
        displayField: 'name'
    });
    SimpleAB.combo.Chunks.superclass.constructor.call(this,config);
};
Ext.extend(SimpleAB.combo.Chunks, MODx.combo.ComboBox);
Ext.reg('simpleab-combo-chunks', SimpleAB.combo.Chunks);

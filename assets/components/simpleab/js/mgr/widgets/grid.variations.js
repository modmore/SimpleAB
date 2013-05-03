SimpleAB.grid.Variations = function(config) {
    config = config || {};
    Ext.applyIf(config,{
		url: SimpleAB.config.connectorUrl,
		id: 'simpleab-grid-variations',
		baseParams: {
            action: 'mgr/variations/getlist',
            test: SimpleAB.record.id
        },
        emptyText: _('simpleab.error.noresults'),
		fields: [
            {name: 'id', type: 'int'},
            {name: 'test', type: 'int'},
            {name: 'name', type: 'string'},
            {name: 'description', type: 'string'},
            {name: 'active', type: 'bool'},
            {name: 'element', type: 'int'},
            {name: 'picks', type: 'int'},
            {name: 'conversions', type: 'int'},
            {name: 'conversionrate', type: 'float'}
        ],
        paging: true,
		remoteSort: true,
		columns: [{
			header: _('simpleab.id'),
			dataIndex: 'id',
			sortable: true,
			width: .1
		},{
			header: _('simpleab.name'),
			dataIndex: 'name',
		    sortable: true,
			width: .3
		},{
			header: _('simpleab.description'),
			dataIndex: 'description',
		    sortable: true,
			width: .5
		},{
			header: _('simpleab.active'),
			dataIndex: 'active',
		    sortable: true,
			width: .1,
            renderer: MODx.grid.Grid.prototype.rendYesNo
		},{
			header: _('simpleab.picks'),
			dataIndex: 'picks',
		    sortable: false,
			width: .15
		},{
			header: _('simpleab.conversions'),
			dataIndex: 'conversions',
		    sortable: false,
			width: .15
		},{
			header: _('simpleab.conversionrate'),
			dataIndex: 'conversionrate',
		    sortable: false,
			width: .15
		}],
        tbar: [{
            text: _('simpleab.add_variation'),
            handler: this.addVariation,
            scope: this
        }]
    });
    SimpleAB.grid.Variations.superclass.constructor.call(this,config);
};
Ext.extend(SimpleAB.grid.Variations,MODx.grid.Grid,{
    addVariation: function() {
        var win = MODx.load({
            xtype: 'simpleab-window-variation',
            listeners: {
                success: {fn: function(r) {
                    this.refresh();
                    var refreshPanel = Ext.getCmp('simpleab-panel-refresh');
                    if (refreshPanel) {
                        refreshPanel.show();
                    }
                },scope: this},
                scope: this
            }
        });
        win.show();
    },

    updateVariation: function() {
        var win = MODx.load({
            xtype: 'simpleab-window-variation',
            isUpdate: true,
            record: this.menu.record,
            listeners: {
                success: {fn: function(r) {
                    this.refresh();
                    var refreshPanel = Ext.getCmp('simpleab-panel-refresh');
                    if (refreshPanel) {
                        refreshPanel.show();
                    }
                },scope: this},
                scope: this
            }
        });
        win.show();
    },

    clearVariationData: function() {
        MODx.msg.confirm({
            title: _('simpleab.clear_variation_data'),
            text: _('simpleab.clear_variation_data.confirm'),
            url: SimpleAB.config.connectorUrl,
            params: {
                action: 'mgr/variations/cleardata',
                id: this.menu.record.id
            },
            listeners: {
                'success':{fn: function(r) {
                    this.refresh();
                },scope: this}
            }
        });
    },

    getMenu: function() {
        var m = [];

        m.push({
            text: _('simpleab.update_variation'),
            handler: this.updateVariation,
            scope: this
        });

        if (this.menu.record.picks > 0 || this.menu.record.conversions > 0) {
            m.push('-',{
                text: _('simpleab.clear_variation_data'),
                handler: this.clearVariationData,
                scope: this
            });
        }
        return m;
    }
});
Ext.reg('simpleab-grid-variations',SimpleAB.grid.Variations);

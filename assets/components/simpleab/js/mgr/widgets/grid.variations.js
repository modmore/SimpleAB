SimpleAB.grid.Variations = function(config) {
    config = config || {};
    var exp = new Ext.grid.RowExpander({
        tpl : new Ext.Template('<p style="margin-top: 8px">{description}</p>'),
        renderer : function(v, p, record){
            return record.get('description').length > 0 ? '<div class="x-grid3-row-expander">&#160;</div>' : '&#160;';
        },
        expandOnEnter: false,
        expandOnDblClick: false
    });
    Ext.applyIf(config,{
		url: SimpleAB.config.connectorUrl,
		id: 'simpleab-grid-variations',
		baseParams: {
            action: 'mgr/variations/getlist',
            test: SimpleAB.record.id
        },
        actionsColumnWidth: .1,
        autosave: true,
        save_action: 'mgr/variations/update_from_grid',
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
        plugins: [exp],
		columns: [exp, {
			header: _('simpleab.id'),
			dataIndex: 'id',
			sortable: true,
			width: .05
		},{
			header: _('simpleab.name'),
			dataIndex: 'name',
		    sortable: true,
			width: .3
		},{
			header: _('simpleab.description'),
			dataIndex: 'description',
		    sortable: true,
			width: .5,
            hidden: true
		},{
			header: _('simpleab.active'),
			dataIndex: 'active',
		    sortable: true,
			width: .1,
            renderer: MODx.grid.Grid.prototype.rendYesNo,
            editor: {
                xtype: 'modx-combo-boolean'
            }
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
            scope: this,
            hidden: !SimpleAB.config.isAdmin
        }],
        listeners: {
            rowDblClick: function(grid, rowIndex, e) {
                if (!SimpleAB.config.isAdmin) return;

                var row = grid.store.getAt(rowIndex);
                this.menu.record = row.json;
                this.updateVariation();
            }
        }
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

    deleteVariation: function() {
        MODx.msg.confirm({
            title: _('simpleab.delete_variation'),
            text: _('simpleab.delete_variation.confirm'),
            url: SimpleAB.config.connectorUrl,
            params: {
                action: 'mgr/variations/remove',
                id: this.menu.record.id
            },
            listeners: {
                'success':{fn: function(r) {
                    this.refresh();
                },scope: this}
            }
        });
    },

    previewVariation: function() {
        var record = this.menu.record;

        var win = MODx.load({
            xtype: 'simpleab-window-preview-variation',
            record: this.menu.record
        });
        win.show();
    },

    getMenu: function() {
        var m = [];

        m.push({
            text: _('simpleab.preview_variation'),
            handler: this.previewVariation,
            scope: this
        });

        if (SimpleAB.config.isAdmin)
        {
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

            m.push('-',{
                text: _('simpleab.delete_variation'),
                handler: this.deleteVariation,
                scope: this
            });
        }
        return m;
    }
});
Ext.reg('simpleab-grid-variations',SimpleAB.grid.Variations);

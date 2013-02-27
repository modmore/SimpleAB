SimpleAB.grid.Tests = function(config) {
    config = config || {};
    Ext.applyIf(config,{
		url: SimpleAB.config.connectorUrl,
		id: 'simpleab-grid-tests',
		baseParams: {
            action: 'mgr/tests/getlist'
        },
        emptyText: _('simpleab.error.noresults'),
		fields: [
            {name: 'id', type: 'int'},
            {name: 'name', type: 'string'},
            {name: 'description', type: 'string'},
            {name: 'type', type: 'string'},
            {name: 'active', type: 'bool'},
            {name: 'variations', type: 'int'},
            {name: 'conversions', type: 'int'}
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
			header: _('simpleab.type'),
			dataIndex: 'type',
			sortable: true,
			width: .2
		},{
			header: _('simpleab.active'),
			dataIndex: 'active',
		    sortable: true,
			width: .1,
            renderer: MODx.grid.Grid.prototype.rendYesNo
		},{
			header: _('simpleab.variations'),
			dataIndex: 'variations',
		    sortable: false,
			width: .1
		},{
			header: _('simpleab.conversions'),
			dataIndex: 'conversions',
		    sortable: false,
			width: .1
		}],
        tbar: [{
            text: _('simpleab.add_test'),
            handler: this.addTest,
            scope: this
        }]
    });
    SimpleAB.grid.Tests.superclass.constructor.call(this,config);
};
Ext.extend(SimpleAB.grid.Tests,MODx.grid.Grid,{
    addTest: function() {
        var win = MODx.load({
            xtype: 'simpleab-window-test',
            listeners: {
                success: {fn: function(r) {
                    this.refresh();
                },scope: this},
                scope: this
            }
        });
        win.show();
    },

    updateTest: function() {
        var win = MODx.load({
            xtype: 'simpleab-window-test',
            isUpdate: true,
            record: this.menu.record,
            listeners: {
                success: {fn: function(r) {
                    this.refresh();
                },scope: this},
                scope: this
            }
        });
        win.show();
    },

    manageTest: function() {
        MODx.loadPage(MODx.request.a,'action=test&id='+this.menu.record.id);
    },
    getMenu: function() {
        var m = [];

        m.push({
            text: _('simpleab.update_test'),
            handler: this.updateTest,
            scope: this
        },{
            text: _('simpleab.manage_test'),
            handler: this.manageTest,
            scope: this
        });
        return m;
    }
});
Ext.reg('simpleab-grid-tests',SimpleAB.grid.Tests);

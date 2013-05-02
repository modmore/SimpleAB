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
            {name: 'threshold', type: 'int'},
            {name: 'randomize', type: 'int'},
            {name: 'active', type: 'bool'},
            {name: 'archived', type: 'bool'},
            {name: 'variations', type: 'int'},
            {name: 'conversions', type: 'int'},
            {name: 'resources', type: 'string'},
            {name: 'templates', type: 'string'}
        ],
        paging: true,
		remoteSort: true,
		columns: [{
			header: _('simpleab.id'),
			dataIndex: 'id',
			sortable: true,
			width: .05
		},{
			header: _('simpleab.name'),
			dataIndex: 'name',
		    sortable: true,
			width: .2
		},{
			header: _('simpleab.description'),
			dataIndex: 'description',
		    sortable: true,
            hidden: true,
			width: .4
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
			header: _('simpleab.archived'),
			dataIndex: 'archived',
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
        },'->',{
            text: _('simpleab.view_archived_tests'),
            enableToggle: true,
            scope: this,
            toggleHandler: function(btn, pressed) {
                btn.setText(pressed ? _('simpleab.view_current_tests') : _('simpleab.view_archived_tests'));
                this.getStore().baseParams.include_archived = (pressed ? 1 : 0);
                this.getBottomToolbar().changePage(1);
            }
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
            listeners: {
                success: {fn: function(r) {
                    this.refresh();
                },scope: this},
                scope: this
            },
            record: this.menu.record
        });
        win.setValues(this.menu.record);
        win.show();
    },

    manageTest: function() {
        MODx.loadPage(MODx.request.a,'action=test&id='+this.menu.record.id);
    },

    archiveTest: function() {
        var record = this.menu.record;
        MODx.msg.confirm({
            title: _('simpleab.archive_test'),
            text: _('simpleab.archive_test.confirm'),
            url: SimpleAB.config.connectorUrl,
            params: {
                action: 'mgr/tests/archive',
                id: record.id
            },
            listeners: {
                'success':{fn: function(r) {
                    this.refresh();
                },scope: this}
            }
        });
    },

    unArchiveTest: function() {
        var record = this.menu.record;
        MODx.msg.confirm({
            title: _('simpleab.unarchive_test'),
            text: _('simpleab.unarchive_test.confirm'),
            url: SimpleAB.config.connectorUrl,
            params: {
                action: 'mgr/tests/unarchive',
                id: record.id
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
            text: _('simpleab.update_test'),
            handler: this.updateTest,
            scope: this
        },{
            text: _('simpleab.manage_test'),
            handler: this.manageTest,
            scope: this
        }, '-');

        if (this.menu.record.archived) {
            m.push({
                text: _('simpleab.unarchive_test'),
                handler: this.unArchiveTest,
                scope: this
            });
        } else {
            m.push({
                text: _('simpleab.archive_test'),
                handler: this.archiveTest,
                scope: this
            });
        }
        return m;
    }
});
Ext.reg('simpleab-grid-tests',SimpleAB.grid.Tests);

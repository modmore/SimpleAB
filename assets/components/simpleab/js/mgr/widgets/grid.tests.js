SimpleAB.grid.Tests = function(config) {
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
		url: SimpleAB.config.connectorUrl
		,id: 'simpleab-grid-tests'
		,baseParams: {
            action: 'mgr/tests/getlist'
        }
        ,actionsColumnWidth: .1
        ,emptyText: _('simpleab.error.noresults')
		,fields: [
            { name: 'id', type: 'int' }
            ,{ name: 'name', type: 'string' }
            ,{ name: 'description', type: 'string' }
            ,{ name: 'type', type: 'string' }
            ,{ name: 'threshold', type: 'int' }
            ,{ name: 'randomize', type: 'int' }
            ,{ name: 'active', type: 'bool' }
            ,{ name: 'archived', type: 'bool' }
            ,{ name: 'smartoptimize', type: 'bool' }
            ,{ name: 'variations', type: 'int' }
            ,{ name: 'conversions', type: 'int' }
            ,{ name: 'resources', type: 'string' }
            ,{ name: 'templates', type: 'string' }
        ]
        ,paging: true
		,remoteSort: true
        ,plugins: [exp]
		,columns: [exp,{
			header: _('simpleab.id')
			,dataIndex: 'id'
			,sortable: true
			,width: .05
		},{
			header: _('simpleab.name')
			,dataIndex: 'name'
		    ,sortable: true
			,width: .2
		},{
			header: _('simpleab.description')
			,dataIndex: 'description'
		    ,sortable: true
            ,hidden: true
			,width: .4
		},{
			header: _('simpleab.type')
			,dataIndex: 'type'
			,sortable: true
			,width: .2
            ,renderer: this.renderType.createDelegate(this,[this],true)
		},{
			header: _('simpleab.active')
			,dataIndex: 'active'
		    ,sortable: true
			,width: .1
            ,renderer: MODx.grid.Grid.prototype.rendYesNo
		},{
			header: _('simpleab.archived')
			,dataIndex: 'archived'
		    ,sortable: true
			,width: .1
            ,renderer: MODx.grid.Grid.prototype.rendYesNo
		},{
			header: _('simpleab.variations')
			,dataIndex: 'variations'
		    ,sortable: false
			,width: .1
		},{
			header: _('simpleab.conversions')
			,dataIndex: 'conversions'
		    ,sortable: false
			,width: .1
		}]
        ,tbar: [{
            text: _('simpleab.add_template_test')
            ,handler: this.addTemplateTest
            ,scope: this
            ,hidden: !SimpleAB.config.isAdmin
        },'-',{
            text: _('simpleab.add_chunk_test')
            ,handler: this.addChunkTest
            ,scope: this
            ,hidden: !SimpleAB.config.isAdmin
        },'->',{
            text: _('simpleab.view_archived_tests')
            ,enableToggle: true
            ,scope: this
            ,toggleHandler: function(btn, pressed) {
                btn.setText(pressed ? _('simpleab.view_current_tests') : _('simpleab.view_archived_tests'));
                this.getStore().baseParams.include_archived = (pressed ? 1 : 0);
                this.getBottomToolbar().changePage(1);
            }
        }],
        listeners: {
            'rowDblClick': { fn: function(grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.menu.record = {id: row.id};
                this.manageTest();
            } ,scope: this }
        }
    });
    SimpleAB.grid.Tests.superclass.constructor.call(this,config);
};
Ext.extend(SimpleAB.grid.Tests,MODx.grid.Grid,{
    addTemplateTest: function() {
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

    addChunkTest: function() {
        var win = MODx.load({
            xtype: 'simpleab-window-test',
            record: {
                type: 'modChunk'
            },
            listeners: {
                success: {fn: function(r) {
                    this.refresh();
                },scope: this},
                scope: this
            }
        });
        win.setValues({type: 'modChunk'});
        win.show();
    },

    manageTest: function() {
        MODx.loadPage('test&namespace=simpleab&id=' + this.menu.record.id);
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

    deleteTest: function() {
        var record = this.menu.record;
        MODx.msg.confirm({
            title: _('simpleab.delete_test'),
            text: _('simpleab.delete_test.confirm'),
            url: SimpleAB.config.connectorUrl,
            params: {
                action: 'mgr/tests/remove',
                id: record.id
            },
            listeners: {
                'success':{fn: function(r) {
                    this.refresh();
                },scope: this}
            }
        });
    },

    duplicateTest: function() {
        var record = {
            id: this.menu.record.id,
            name: _('simpleab.duplicate_of') + this.menu.record.name
        };
        var win = MODx.load({
            xtype: 'simpleab-window-duplicate-test',
            isUpdate: true,
            record: record,
            listeners: {
                success: {fn: function() {
                    this.refresh();
                },scope: this},
                scope: this
            }
        });
        win.setValues(record);
        win.show();
    },

    getMenu: function() {
        var m = [];

        if (SimpleAB.config.isAdmin) {
            m.push({
                text: _('simpleab.update_test')
                ,handler: this.manageTest
                ,scope: this
            });
        }

        m.push({
            text: _('simpleab.manage_test')
            ,handler: this.manageTest
            ,scope: this
        });

        if (SimpleAB.config.isAdmin) {
            m.push('-',{
                text: _('simpleab.duplicate_test'),
                handler: this.duplicateTest,
                scope: this
            });

            if (this.menu.record.archived) {
                m.push({
                    text: _('simpleab.unarchive_test')
                    ,handler: this.unArchiveTest
                    ,scope: this
                });
            } else {
                m.push({
                    text: _('simpleab.archive_test')
                    ,handler: this.archiveTest
                    ,scope: this
                });
            }

            m.push('-',{
                text: _('simpleab.delete_test')
                ,handler: this.deleteTest
                ,scope: this
            });
        }

        return m;
    }
    /** RENDERS **/
    ,renderType: function(v,md,rec,ri,ci,s,g) {
        return _('simpleab.type_' + v);
    }
});
Ext.reg('simpleab-grid-tests',SimpleAB.grid.Tests);

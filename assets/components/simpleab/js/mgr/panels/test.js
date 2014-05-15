SimpleAB.panel.UpdateTest = function(config) {
    config = config || {};
    Ext.apply(config, {
        id: 'simpleab-panel-test-update'
        ,url: SimpleAB.config.connectorUrl
        ,baseParams: { action: 'mgr/tests/update' ,id: SimpleAB.record.id }

        ,border: false
		,baseCls: 'modx-formpanel'
		,cls: 'container form-with-labels'
		,defaults: { collapsible: false ,autoHeight: true }
        ,forceLayout: true
		,items: [{
			html: '<h2>' + _('simpleab.manage_test.title', { name: SimpleAB.record.name }) + '</h2>'
			,border: false
			,cls: 'modx-page-header'
		},MODx.getPageStructure([{
            title: _('simpleab.test') + ' & ' + _('simpleab.variations')
            ,defaults: { border: false ,msgTarget: 'side' }
            ,layout: 'form'
            ,labelWidth: 150
			,items: this.getPanelItems()
        },{
            title: _('simpleab.statistics')
            ,defaults: { border: false ,msgTarget: 'side' }
			,items: [{
                html: '<p>' + _('simpleab.manage_test.desc') + '</p>'
                ,bodyCssClass: 'panel-desc'
            }]
        }])]
        // only to redo the grid layout after the content is rendered
        // to fix overflow components' panels, especially when scroll bar is shown up
        ,listeners: {
            'setup': { fn: this.setup ,scope: this }
            ,'afterrender': { fn: function(tabPanel) { tabPanel.doLayout(); } ,scope: this }

        }
    });
    SimpleAB.panel.UpdateTest.superclass.constructor.call(this, config);
};

Ext.extend(SimpleAB.panel.UpdateTest, MODx.FormPanel, {
    initialized: false
    ,setup: function() {
        var fp = this.getForm();
        if (!this.initialized) {
            fp.setValues(SimpleAB.record);

            if(SimpleAB.config.isAdmin) {
                fp.findField('smartoptimize').setValue((SimpleAB.record.smartoptimize == 1));
                fp.findField('active').setValue((SimpleAB.record.active == 1));
            }
        }

        this.fireEvent('ready');
        this.initialized = true;
    }
    ,beforeSubmit: function(o) {
        return this.fireEvent('save', {
            values: this.getForm().getValues()
            ,stay: MODx.config.stay
        });
    }
    ,getPanelItems: function() {
        var it = [{
            html: '<p>' + _('simpleab.manage_test.desc'+(SimpleAB.config.isAdmin ? '_admin' : '')) + '</p>'
            ,bodyCssClass: 'panel-desc'
        }];

        if(!SimpleAB.config.isAdmin) {

            // add just name and description
            it.push({
                layout: 'form'
                ,cls: 'main-wrapper'
                ,defaults: {
                    labelAlign: 'top'
                    ,anchor: '100%'
                    ,border: false
                    ,labelSeparator: ''
                    ,msgTarget: 'side'
                }
                ,items: [{
                    xtype: 'statictextfield'
                    ,fieldLabel: _('simpleab.name')
                    ,name: 'name'
                },{
                    xtype: 'statictextfield'
                    ,fieldLabel: _('simpleab.description')
                    ,name: 'description'
                },{
                    xtype: 'statictextfield'
                    ,fieldLabel: _('simpleab.type')
                    ,name: 'type'
                }]
            });
        }
        else {

            // add columns
            it.push({
                layout: 'column'
                ,border: false
                ,defaults: {
                    layout: 'form'
                    ,labelAlign: 'top'
                    ,anchor: '100%'
                    ,border: false
                    ,cls: 'main-wrapper'
                    ,labelSeparator: ''
                }
                ,items: [{
                    columnWidth: .5
                    ,defaults: { msgTarget: 'side' ,border: false ,anchor: '100%' }
                    ,items: [{
                        xtype: 'textfield'
                        ,fieldLabel: _('simpleab.name')
                        ,name: 'name'
                    },{
                        xtype: 'textarea'
                        ,fieldLabel: _('simpleab.description')
                        ,name: 'description'
                    },{
                        xtype: 'xcheckbox'
                        ,name: 'active'
                        ,boxLabel: _('simpleab.active')
                    }]
                },{
                    columnWidth: .5
                    ,defaults: { msgTarget: 'side' ,border: false ,anchor: '100%' }
                    ,items: [{
                        xtype: 'statictextfield'
                        ,fieldLabel: _('simpleab.type')
                        ,name: 'type'
                    },{
                        layout: 'column'
                        ,border: false
                        ,defaults: { layout: 'form' ,border: false }
                        ,hidden: !(SimpleAB.record.type == 'modTemplate')
                        ,items: [{
                            columnWidth: .5
                            ,defaults: { msgTarget: 'side' ,border: false ,anchor: '100%' }
                            ,items: [{
                                xtype: 'textfield'
                                ,name: 'resources'
                                ,id: 'simpleab-test-apply_to_resources'
                                ,fieldLabel: _('simpleab.apply_to_resources')
                                ,description: MODx.expandHelp ? '' : _('simpleab.apply_to_resources.desc')
                                ,allowBlank: true
                            },{
                                xtype: MODx.expandHelp ? 'label' : 'hidden'
                                ,forId: 'simpleab-test-apply_to_resources'
                                ,html: _('simpleab.apply_to_resources.desc')
                                ,cls: 'desc-under'
                            }]
                        },{
                            columnWidth: .5
                            ,defaults: { msgTarget: 'side' ,border: false ,anchor: '100%' }
                            ,items: [{
                                xtype: 'textfield'
                                ,name: 'templates'
                                ,id: 'simpleab-test-apply_to_templates'
                                ,fieldLabel: _('simpleab.apply_to_templates')
                                ,description: MODx.expandHelp ? '' : _('simpleab.apply_to_templates.desc')
                                ,allowBlank: true
                            },{
                                xtype: MODx.expandHelp ? 'label' : 'hidden'
                                ,forId: 'simpleab-test-apply_to_templates'
                                ,html: _('simpleab.apply_to_templates.desc')
                                ,cls: 'desc-under'
                            }]
                        }]
                    },{
                        xtype: 'xcheckbox'
                        ,id: 'simpleab-test-smartoptimize-toggle'
                        ,name: 'smartoptimize'
                        ,boxLabel: _('simpleab.smartoptimize')
                        ,listeners: {
                            'check': { fn: function(fld, checked) {
                                var flds = Ext.getCmp('simpleab-test-smartoptimize');
                                if (checked) {
                                    flds.show();
                                } else {
                                    flds.hide();
                                }
                            } ,scope: this }
                        }
                    },{
                        layout: 'column'
                        ,id: 'simpleab-test-smartoptimize'
                        ,hidden: true
                        ,border: false
                        ,defaults: { layout: 'form' ,border: false }
                        ,items: [{
                            columnWidth: .5
                            ,defaults: { msgTarget: 'side' ,border: false ,anchor: '100%' }
                            ,items: [{
                                xtype: 'numberfield'
                                ,name: 'threshold'
                                ,fieldLabel: _('simpleab.threshold')
                                ,description: _('simpleab.threshold.desc')
                                ,value: 100
                                ,allowBlank: false
                                ,minValue: 0
                            }]
                        },{
                            columnWidth: .5
                            ,defaults: { msgTarget: 'side' ,border: false ,anchor: '100%' }
                            ,items: [{
                                xtype: 'numberfield'
                                ,name: 'randomize'
                                ,fieldLabel: _('simpleab.randomize')
                                ,description: _('simpleab.randomize.desc')
                                ,value: 25
                                ,allowBlank: false
                                ,minValue: 0
                                ,maxValue: 100
                            }]
                        }]
                    }]
                }]
            });
        }

        // add variations grid
        it.push({
            xtype: 'simpleab-grid-variations'
            ,preventRender: true
            ,cls: 'main-wrapper'
        });

        return it;
    }
});
Ext.reg('simpleab-panel-test-update', SimpleAB.panel.UpdateTest);
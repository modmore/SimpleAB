SimpleAB.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config, {
        border: false
		,baseCls: 'modx-formpanel'
		,cls: 'container'
		,defaults: { collapsible: false ,autoHeight: true }
		,items: [{
			html: '<h2>'+_('simpleab.home')+'</h2>'
			,border: false
			,cls: 'modx-page-header'
		},{
			defaults: { border: false, autoHeight: true }
			,items: [{
				html: '<p>' + _('simpleab.tests.desc') + '</p>'
				,bodyCssClass: 'panel-desc'
			},{
				xtype: 'simpleab-grid-tests'
				,preventRender: true
				,cls: 'main-wrapper'
			}]
		},SimpleAB.attribution()]
    });

    SimpleAB.panel.Home.superclass.constructor.call(this, config);
};

Ext.extend(SimpleAB.panel.Home, MODx.Panel);
Ext.reg('simpleab-panel-home', SimpleAB.panel.Home);
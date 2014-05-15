Ext.onReady(function() {
    MODx.load({ xtype: 'simpleab-page-home' });
    MODx.config.help_url = 'https://www.modmore.com/extras/simpleab/documentation/?embed=1';
});

// index page
SimpleAB.page.Home = function(config) {
	config = config || {};

	Ext.applyIf(config,{
		components: [{
			xtype: 'simpleab-panel-home'
			,renderTo: 'simpleab-wrapper-div'
		}]
        ,buttons: [{
            text: _('help_ex')
            ,handler: MODx.loadHelpPane
        }]
	});

	SimpleAB.page.Home.superclass.constructor.call(this, config);
};

Ext.extend(SimpleAB.page.Home, MODx.Component);
Ext.reg('simpleab-page-home', SimpleAB.page.Home);
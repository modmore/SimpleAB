var SimpleAB = function(config) {
    config = config || {};
    SimpleAB.superclass.constructor.call(this,config);
};
Ext.extend(SimpleAB,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},tabs:{},combo:{},
    config: {
        connectorUrl: ''
    },
    attribution: function() {
        return {
            xtype: 'panel',
            bodyStyle: 'text-align: right; background: none; padding: 10px 0;',
            html: '<a href="https://www.modmore.com/extras/simpleab/"><img src="' + SimpleAB.config.assetsUrl + 'img/small_modmore_logo.png" alt="a modmore product" /></a>',
            border: false,
            width: '98%',
            hidden: SimpleAB.config.hideLogo
        };
    }
});
Ext.reg('simpleab',SimpleAB);
SimpleAB = new SimpleAB();

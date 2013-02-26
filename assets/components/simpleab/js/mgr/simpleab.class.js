var SimpleAB = function(config) {
    config = config || {};
    SimpleAB.superclass.constructor.call(this,config);
};
Ext.extend(SimpleAB,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},tabs:{},combo:{},
    config: {
        connectorUrl: ''
    },
    inVersion: false
});
Ext.reg('simpleab',SimpleAB);
SimpleAB = new SimpleAB();

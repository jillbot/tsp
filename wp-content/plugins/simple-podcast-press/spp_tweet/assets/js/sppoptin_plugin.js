(function() {
    tinymce.create('tinymce.plugins.SPPoptin', {
        init: function(ed, url) {
            ed.addButton('sppoptin', {
                title: 'SPP: Insert Opt-in Box',
                image: url.replace("/js", "") + '/img/optin-button.png',
                onclick: function() {

				 ed.execCommand('mceInsertContent', false, '[spp-optin]');
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        },
        getInfo: function() {
            return {
                longname: "SPP OPT in Buttons",
                author: 'HaniMourra',
                authorurl: 'http://simplepodcastpress.com/',
                infourl: 'http://simplepodcastpress.com/',
                version: "1.0"
            };
        }
    });
    tinymce.PluginManager.add('sppoptin', tinymce.plugins.SPPoptin);
})();
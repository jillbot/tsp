(function() {
    tinymce.create('tinymce.plugins.SPPctabuttons', {
        init: function(ed, url) {
            ed.addButton('sppctabuttons', {
                title: 'SPP: Insert Call to Action Buttons',
                image: url.replace("/js", "") + '/img/cta-button.png',
                onclick: function() {

				 ed.execCommand('mceInsertContent', false, '[spp-ctabuttons]');
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        },
        getInfo: function() {
            return {
                longname: "SPP CTA in Buttons",
                author: 'HaniMourra',
                authorurl: 'http://simplepodcastpress.com/',
                infourl: 'http://simplepodcastpress.com',
                version: "1.0"
            };
        }
    });
    tinymce.PluginManager.add('sppctabuttons', tinymce.plugins.SPPctabuttons);
})();
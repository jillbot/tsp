(function() {
    tinymce.create('tinymce.plugins.SPPtranscriptclose', {
        init: function(ed, url) {
            ed.addButton('spptranscriptclose', {
                title: 'SPP: Insert Transcript Closing Shortcode',
                image: url.replace("/js", "") + '/img/transcriptclose-button.png',
                onclick: function() {

				 ed.execCommand('mceInsertContent', false, '[/spp-transcript]');
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        },
        getInfo: function() {
            return {
                longname: "SPP Transcript Closing Shortcode",
                author: 'HaniMourra',
                authorurl: 'http://simplepodcastpress.com/',
                infourl: 'http://simplepodcastpress.com/',
                version: "1.0"
            };
        }
    });
    tinymce.PluginManager.add('spptranscriptclose', tinymce.plugins.SPPtranscriptclose);
})();
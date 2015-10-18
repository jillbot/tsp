(function() {
    tinymce.create('tinymce.plugins.SPPtranscript', {
        init: function(ed, url) {
            ed.addButton('spptranscript', {
                title: 'SPP: Insert Transcript',
                image: url.replace("/js", "") + '/img/transcript-button.png',
                onclick: function() {

				 ed.execCommand('mceInsertContent', false, '[spp-transcript]');
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        },
        getInfo: function() {
            return {
                longname: "SPP Transcript Shortcode",
                author: 'HaniMourra',
                authorurl: 'http://simplepodcastpress.com/',
                infourl: 'http://simplepodcastpress.com/',
                version: "1.0"
            };
        }
    });
    tinymce.PluginManager.add('spptranscript', tinymce.plugins.SPPtranscript);
})();
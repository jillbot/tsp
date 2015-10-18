(function() {
    tinymce.create('tinymce.plugins.SPPepisodes', {
        init: function(ed, url) {
            ed.addButton('sppepisodes', {
                title: 'SPP: Insert Episodes Table',
                image: url.replace("/js", "") + '/img/episodes-button.png',
                onclick: function() {

				 ed.execCommand('mceInsertContent', false, '[spp-episodes]');
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        },
        getInfo: function() {
            return {
                longname: "SPP: Insert Episodes Table",
                author: 'Hani Mourra',
                authorurl: 'http://simplepodcastpress.com/',
                infourl: 'http://simplepodcastpress.com/',
                version: "1.0"
            };
        }
    });
    tinymce.PluginManager.add('sppepisodes', tinymce.plugins.SPPepisodes);
})();
(function() {
    tinymce.create('tinymce.plugins.SPPplayer', {
        init: function(ed, url) {
            ed.addButton('sppplayer', {
                title: 'SPP: Insert Audio Player',
                image: url.replace("/js", "") + '/img/player-button.png',
                onclick: function() {

				 ed.execCommand('mceInsertContent', false, '[spp-player]');
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        },
        getInfo: function() {
            return {
                longname: "SPP: Insert Audio Player",
                author: 'Hani Mourra',
                authorurl: 'http://simplepodcastpress.com/',
                infourl: 'http://simplepodcastpress.com/',
                version: "1.0"
            };
        }
    });
    tinymce.PluginManager.add('sppplayer', tinymce.plugins.SPPplayer);
})();
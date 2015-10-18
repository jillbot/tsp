(function() {
    tinymce.create('tinymce.plugins.SPPreviews', {
        init: function(ed, url) {
            ed.addButton('sppreviews', {
                title: 'SPP: Insert Reviews',
                image: url.replace("/js", "") + '/img/reviews-button.png',
                onclick: function() {

				 ed.execCommand('mceInsertContent', false, '[spp-reviews]');
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        },
        getInfo: function() {
            return {
                longname: "SPP: Insert Reviews",
                author: 'Hani Mourra',
                authorurl: 'http://simplepodcastpress.com/',
                infourl: 'http://simplepodcastpress.com/',
                version: "1.0"
            };
        }
    });
    tinymce.PluginManager.add('sppreviews', tinymce.plugins.SPPreviews);
})();
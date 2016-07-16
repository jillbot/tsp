(function() {
    tinymce.create('tinymce.plugins.SPPTweet', {
        init: function(ed, url) {
            ed.addButton('spptweet', {
                title: 'SPP: Tweet This',
                image: url.replace("/js", "") + '/img/twitter-little-bird-button.png',
                onclick: function() {
                    ed.selection.setContent('[spp-tweet tweet="' + ed.selection.getContent() + '"]');
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        },
        getInfo: function() {
            return {
                longname: "Click To Tweet by Simple Podcast Press",
                author: 'HaniMourra',
                authorurl: 'http://simplepodcastpress.com/',
                infourl: 'http://simplepodcastpress.com/',
                version: "1.0"
            };
        }
    });
    tinymce.PluginManager.add('spptweet', tinymce.plugins.SPPTweet);
})();

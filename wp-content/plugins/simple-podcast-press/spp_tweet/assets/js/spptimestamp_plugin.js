(function() {
    tinymce.create('tinymce.plugins.SPPTimestamp', {
        init: function(ed, url) {
            ed.addButton('spptimestamp', {
                title: 'SPP: Insert Clickable Time Stamp',
                image: url.replace("/js", "") + '/img/timestamp-button.png',
                onclick: function() {
                    ed.selection.setContent('[spp-timestamp time="' + ed.selection.getContent() + '"]');
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        },
        getInfo: function() {
            return {
                longname: "Time Stamp by Simple Podcast Press",
                author: 'HaniMourra',
                authorurl: 'http://simplepodcastpress.com/',
                infourl: 'http://simplepodcastpress.com/',
                version: "1.0"
            };
        }
    });
    tinymce.PluginManager.add('spptimestamp', tinymce.plugins.SPPTimestamp);
})();

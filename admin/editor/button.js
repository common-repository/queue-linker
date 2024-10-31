(function() {
    tinymce.PluginManager.add('gavickpro_tc_button', function( editor, url ) {
        editor.addButton( 'gavickpro_tc_button', {
            title: 'Queue Technologies',
            type: 'menubutton',
            icon: 'icon custom-button-icon',
            menu: [
                {
                    text: 'Sign up Form (horizontal)',
                    value: '[queue-signup]',
                    onclick: function() {
                        editor.insertContent(this.value());
                    }
                },
                {
                    text: 'Sign up Form (vertical)',
                    value: '[queue-signup format="vertical"]',
                    onclick: function() {
                        editor.insertContent(this.value());
                    }
                },
                {
                    text: 'Social Proof',
                    value: '[queue-social-proof]',
                    onclick: function() {
                        editor.insertContent(this.value());
                    }
                },
                {
                    text: 'Greetings Bar',
                    value: '[queue-greetings-bar]',
                    onclick: function() {
                        editor.insertContent(this.value());
                    }
                },
                {
                    text: 'Community',
                    value: '[queue-community]',
                    onclick: function() {
                        editor.insertContent(this.value());
                    }
                },
           ]
        });
    });
})();

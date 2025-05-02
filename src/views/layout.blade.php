<!DOCTYPE html>
<html {{ language_attributes() }} >
    <head>
        <meta charset="{{ bloginfo( 'charset' ) }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{ the_title() }}</title>
        {{ wp_head() }}
        @livewireStyles
    </head>
    <body {{ body_class() }} >
        <!-- MM Dynamic Page Livewire Component -->
        <livewire:meros_dynamic_page.page />
        {{ wp_footer() }}
        @livewireScriptConfig
    </body>
</html>
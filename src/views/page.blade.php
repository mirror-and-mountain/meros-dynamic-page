<div class="wp-site-blocks">
    @foreach($blocks as $block)
        @if($block['blockName'] === 'meros/dynamic-header' || 
            $block['blockName'] === 'core/pattern' 
            && $block['attrs']['slug'] === 'meros-blocks/meros-blocks-header' 
        )
            @persist('header')
                {!! render_block($block) !!}
            @endpersist
        @elseif($block['blockName'] === 'meros/carousel')
            @if($block['attrs']['spaOptions']['persist'] ?? true)
                @persist('meros-carousel')
                    {!! render_block($block) !!}
                @endpersist
            @else
                {!! render_block($block) !!}
            @endif
        @elseif($block['blockName'] === 'core/post-content')
            @php
                $filtered = apply_filters('the_content', render_block($block));
                echo $filtered;
            @endphp
        @else
            {!! render_block($block) !!}
        @endif
    @endforeach
</div>
@script
    <script>
        window.merosWiredPostId = $wire.postId;
    </script>
@endscript
<div class="wp-site-blocks">
    @foreach($blocks as $block)
        @if($block['blockName'] === 'meros/dynamic-header' || 
            ($block['blockName'] === 'core/pattern' && $block['attrs']['slug'] === 'meros-blocks/meros-blocks-header') 
        )
            @persist('header')
                {!! render_block($block) !!}
            @endpersist

        @elseif($block['blockName'] === 'core/block' && isset($block['attrs']['ref']))
            @php
                $ref_id = $block['attrs']['ref'];
                $post = get_post($ref_id);
                $inner_blocks = [];
                if ($post && $post->post_type === 'wp_block') {
                    $inner_blocks = parse_blocks($post->post_content);
                }
            @endphp
            @foreach($inner_blocks as $inner_block)
                @if($inner_block['blockName'] === 'meros/carousel')
                    @php
                        $carouselId = $inner_block['attrs']['carouselId'] ?? 'carousel-no-id';
                    @endphp
                    @if($inner_block['attrs']['spaOptions']['persist'] ?? true)
                        @persist("meros-carousel-{$carouselId}")
                            {!! render_block($inner_block) !!}
                        @endpersist
                    @else
                        {!! render_block($inner_block) !!}
                    @endif
                @endif
            @endforeach

        @elseif($block['blockName'] === 'meros/carousel')
            @php
                $carouselId = $block['attrs']['carouselId'] ?? 'carousel-no-id';
            @endphp
            @if($block['attrs']['spaOptions']['persist'] ?? true)
                @persist("meros-carousel-{$carouselId}")
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

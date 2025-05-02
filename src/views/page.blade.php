<div class="wp-site-blocks">
    @foreach($blocks as $block)
        @if($block['blockName'] === 'meros/carousel')
            @persist('meros-carousel')
                {!! render_block($block) !!}
            @endpersist
        @elseif(isset($block['attrs']['slug']) && $block['attrs']['slug'] === 'header')
            @persist('header')
                {!! render_block($block) !!}
            @endpersist
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

<div class="wp-site-blocks">
    @foreach($blocks as $block)
        @if($block['blockName'] === 'core/post-content')
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
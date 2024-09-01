@php
    $rootTag ??= 'urlset';
@endphp

<?php echo '<?xml version="1.0" encoding="UTF-8" ?>' ?>

<{{ $rootTag }} xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($tags as $tag)
        @include("sitemap-generator::{$tag['tag']}-tag", $tag)
    @endforeach
</{{ $rootTag }}>
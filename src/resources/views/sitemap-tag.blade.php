<sitemap>
    <loc>{!! $loc !!}</loc>
    @isset($lastmod)
        <lastmod>{{ $lastmod }}</lastmod>
    @endisset
</sitemap>
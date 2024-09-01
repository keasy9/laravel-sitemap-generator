<url>
    <loc>{!! $loc !!}</loc>
    @isset($lastmod)
        <lastmod>{{ $lastmod}}</lastmod>
    @endisset
    @isset($changefreq)
        <changefreq>{{ $changefreq}}</changefreq>
    @endisset
    @isset($priority)
        <priority>{{ $priority}}</priority>
    @endisset
</url>
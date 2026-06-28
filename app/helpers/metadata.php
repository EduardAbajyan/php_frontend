<?php

function portfolio_navigation_items(): array
{
    return [
        ['name' => 'Home', 'path' => 'page1'],
        ['name' => 'CV Overview', 'path' => 'page2'],
        ['name' => 'About', 'path' => 'page3'],
        ['name' => 'Education', 'path' => 'page4'],
        ['name' => 'Skills', 'path' => 'page5'],
        ['name' => 'Portfolio Project', 'path' => 'page6'],
        ['name' => 'Contact', 'path' => 'page7'],
    ];
}

function render_structured_data(array $meta = []): void
{
    $navigationItems = portfolio_navigation_items();
    $homeUrl = base_url('page1');
    $path = (string) ($meta['path'] ?? 'page1');
    $canonical = base_url($path);
    $schemaType = $meta['schema_type'] ?? ($path === 'page1' ? 'ProfilePage' : ($path === 'page2' ? 'CollectionPage' : 'WebPage'));

    $graph = [
        [
            '@type' => 'WebSite',
            '@id' => $homeUrl . '#website',
            'url' => $homeUrl,
            'name' => $meta['site_name'],
            'description' => $meta['description'],
            'inLanguage' => 'en',
        ],
        [
            '@type' => 'Person',
            '@id' => $homeUrl . '#person',
            'name' => $meta['author'],
            'url' => $homeUrl,
            'image' => $meta['image'],
            'jobTitle' => 'Full-Stack Web Developer',
            'description' => $meta['description'],
            'sameAs' => [
                'https://www.linkedin.com/in/eduardabajyan/',
                'https://github.com/EduardAbajyan',
                'https://www.instagram.com/eduardabajyan/',
            ],
        ],
        [
            '@type' => $schemaType,
            '@id' => $canonical . '#webpage',
            'url' => $canonical,
            'name' => $meta['title'],
            'description' => $meta['description'],
            'isPartOf' => ['@id' => $homeUrl . '#website'],
            'about' => ['@id' => $homeUrl . '#person'],
            'primaryImageOfPage' => [
                '@type' => 'ImageObject',
                'url' => $meta['image'],
            ],
        ],
    ];

    foreach ($navigationItems as $index => $item) {
        $graph[] = [
            '@type' => 'SiteNavigationElement',
            '@id' => base_url($item['path']) . '#nav',
            'name' => $item['name'],
            'url' => base_url($item['path']),
            'position' => $index + 1,
        ];
    }

    $payload = [
        '@context' => 'https://schema.org',
        '@graph' => $graph,
    ];

    echo '<script type="application/ld+json">' . json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . PHP_EOL;
}

function render_page_metadata(array $meta = []): void
{
    $defaults = [
        'title' => 'Eduard Abajyan | Full-Stack Web Developer Portfolio',
        'description' => 'Portfolio and CV of Eduard Abajyan, a full-stack web developer building practical PHP and JavaScript web applications.',
        'path' => 'page1',
        'type' => 'website',
        'image' => asset('images/aboutMeImage.jpg'),
        'robots' => 'index,follow',
        'author' => 'Eduard Abajyan',
        'site_name' => 'Eduard Abajyan Portfolio',
    ];

    $meta = array_merge($defaults, $meta);

    $title = htmlspecialchars((string) $meta['title'], ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars((string) $meta['description'], ENT_QUOTES, 'UTF-8');
    $canonical = htmlspecialchars(base_url((string) $meta['path']), ENT_QUOTES, 'UTF-8');
    $image = htmlspecialchars((string) $meta['image'], ENT_QUOTES, 'UTF-8');
    $type = htmlspecialchars((string) $meta['type'], ENT_QUOTES, 'UTF-8');
    $robots = htmlspecialchars((string) $meta['robots'], ENT_QUOTES, 'UTF-8');
    $author = htmlspecialchars((string) $meta['author'], ENT_QUOTES, 'UTF-8');
    $siteName = htmlspecialchars((string) $meta['site_name'], ENT_QUOTES, 'UTF-8');

    echo '<title>' . $title . '</title>' . PHP_EOL;
    echo '<meta name="description" content="' . $description . '">' . PHP_EOL;
    echo '<meta name="author" content="' . $author . '">' . PHP_EOL;
    echo '<meta name="robots" content="' . $robots . '">' . PHP_EOL;
    echo '<link rel="canonical" href="' . $canonical . '">' . PHP_EOL;
    echo '<meta property="og:locale" content="en_US">' . PHP_EOL;
    echo '<meta property="og:type" content="' . $type . '">' . PHP_EOL;
    echo '<meta property="og:site_name" content="' . $siteName . '">' . PHP_EOL;
    echo '<meta property="og:title" content="' . $title . '">' . PHP_EOL;
    echo '<meta property="og:description" content="' . $description . '">' . PHP_EOL;
    echo '<meta property="og:url" content="' . $canonical . '">' . PHP_EOL;
    echo '<meta property="og:image" content="' . $image . '">' . PHP_EOL;
    echo '<meta name="twitter:card" content="summary_large_image">' . PHP_EOL;
    echo '<meta name="twitter:title" content="' . $title . '">' . PHP_EOL;
    echo '<meta name="twitter:description" content="' . $description . '">' . PHP_EOL;
    echo '<meta name="twitter:image" content="' . $image . '">' . PHP_EOL;

    render_structured_data($meta);
}
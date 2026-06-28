<?php

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
}
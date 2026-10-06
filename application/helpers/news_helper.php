<?php

function detect_media_type($url)
{
    $url = strtolower($url);

    if (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false) {
        return 'youtube';
    }
    if (strpos($url, 'facebook.com') !== false) {
        return 'facebook';
    }
    if (strpos($url, 'instagram.com') !== false) {
        return 'instagram';
    }
    if (strpos($url, 'twitter.com') !== false || strpos($url, 'x.com') !== false) {
        return 'twitter';
    }
    if (strpos($url, 'linkedin.com') !== false) {
        return 'linkedin';
    }

    return 'website';
}

function preview_media($url, $type, $preview_image = '')
{
    if (empty($url)) {
        return '';
    }

    // YouTube
    if ($type == 'youtube') {
        preg_match("/(youtu\.be\/|v=)([^&]+)/", $url, $matches);

        return isset($matches[2])
            ? '<iframe width="200" height="120"
                src="https://www.youtube.com/embed/' . $matches[2] . '"
                frameborder="0"
                allowfullscreen></iframe>'
            : '';
    }

    // Other media - show saved preview thumbnail
    if (!empty($preview_image)) {
        return '
            <a href="' . htmlspecialchars($url) . '" target="_blank">
                <img src="' . htmlspecialchars($preview_image) . '"
                     alt="Preview"
                     style="
                        width:200px;
                        height:120px;
                        object-fit:cover;
                        border-radius:6px;
                        border:1px solid #ddd;
                     ">
            </a>';
    }

    // Fallback
    return '<a href="' . htmlspecialchars($url) . '" target="_blank">Preview Link</a>';
}

function fetch_link_preview($url)
{
    $context = stream_context_create([
        'http' => [
            'timeout' => 3,
            'user_agent' => 'Mozilla/5.0'
        ]
    ]);

    $html = @file_get_contents($url, false, $context);
    if (!$html) return null;

    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    $doc->loadHTML($html);
    libxml_clear_errors();

    $xpath = new DOMXPath($doc);

    $getMeta = function ($property) use ($xpath) {
        $node = $xpath->query("//meta[@property='$property']")->item(0);
        return $node ? $node->getAttribute('content') : '';
    };

    return [
        'title'       => $getMeta('og:title'),
        'description' => $getMeta('og:description'),
        'image'       => $getMeta('og:image'),
        'url'         => $url
    ];
}

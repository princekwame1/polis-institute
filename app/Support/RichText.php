<?php

namespace App\Support;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

/**
 * Cleans and renders the HTML written in the admin's Quill editors.
 */
class RichText
{
    /**
     * Strip anything the editor can't produce, returning null when no text is left.
     */
    public static function sanitize(?string $value): ?string
    {
        $html = trim(self::sanitizer()->sanitize(self::toHtml($value)));

        return self::isBlank($html) ? null : $html;
    }

    /**
     * Turn older plain-text content into paragraphs, leaving HTML untouched.
     */
    public static function toHtml(?string $value): string
    {
        $value = trim((string) $value);

        if ($value === '' || preg_match('#</?(p|br|strong|em|u|s|h[1-6]|ul|ol|li|a|blockquote)\b[^>]*>#i', $value)) {
            return $value;
        }

        return collect(preg_split('/\R{2,}/', $value))
            ->map(fn (string $paragraph): string => '<p>'.preg_replace('/\R/', '<br>', e(trim($paragraph))).'</p>')
            ->implode('');
    }

    /**
     * Safe HTML ready to echo into a page.
     */
    public static function render(?string $value): HtmlString
    {
        return new HtmlString((string) self::sanitize($value));
    }

    /**
     * The text content with each paragraph, line break and list item on its own line.
     */
    public static function toText(?string $value): string
    {
        $text = preg_replace(['#<br\s*/?>#i', '#</(p|li|h[1-6]|blockquote)>#i'], "\n", (string) $value);

        return trim(html_entity_decode(strip_tags($text), ENT_QUOTES | ENT_HTML5));
    }

    /**
     * The text content on a single line, for previews and meta tags.
     */
    public static function plain(?string $value): string
    {
        return Str::squish(self::toText($value));
    }

    private static function isBlank(string $html): bool
    {
        return trim(str_replace("\u{00A0}", ' ', self::toText($html))) === '';
    }

    private static function sanitizer(): HtmlSanitizer
    {
        static $sanitizer;

        return $sanitizer ??= new HtmlSanitizer(
            (new HtmlSanitizerConfig)
                ->allowElement('p')
                ->allowElement('br')
                ->allowElement('strong')
                ->allowElement('em')
                ->allowElement('u')
                ->allowElement('s')
                ->allowElement('h2')
                ->allowElement('h3')
                ->allowElement('blockquote')
                ->allowElement('ul')
                ->allowElement('ol')
                ->allowElement('li')
                ->allowElement('a', ['href', 'target'])
                ->allowLinkSchemes(['http', 'https', 'mailto', 'tel'])
                ->allowRelativeLinks()
                ->forceAttribute('a', 'rel', 'noopener noreferrer')
                ->withMaxInputLength(100000)
        );
    }
}

<?php

/**
 * DokuWiki Plugin linkfavicon (Renderer Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author Shao Yanmin <shaoyan.alpha@gmail.com>
 */
class renderer_plugin_linkfavicon extends Doku_Renderer_xhtml
{
    function canRender($format) {
        return ($format=='xhtml');
    }

    /**
     * Render an external link
     *
     * @param string $url full URL with scheme
     * @param string|array $name name for the link, array for media file
     * @param bool $returnonly whether to return html or write to doc attribute
     * @return void|string writes to doc attribute or returns html depends on $returnonly
     */
    public function externallink($url, $name = null, $returnonly = false)
    {
        $result = parent::externallink($url, $name, true);

        // Presume that the result contains class="urlextern" when it's an external link
        if (strpos($result, 'urlextern') !== false) {
            $result = preg_replace('/(<a\s[^>]*class="[^"]*)"/', '$1 linkfavicon"', $result, 1);
            $parsedUrl = parse_url($url);
            $domain = $parsedUrl['host'];

            $iconUrl = 'https://www.faviconextractor.com/favicon/' . $domain;
            // $iconUrl = 'https://www.google.com/s2/favicons?domain=' . $domain . '&sz=16';
            // $iconUrl = 'https://icons.duckduckgo.com/ip3/' . $domain . '.ico';

            $result = preg_replace('/(<a\s[^>]*href="[^"]*")/', '$1 data-linkfavicon="' . $iconUrl . '"', $result, 1);
        }

        if ($returnonly) {
            return $result;
        } else {
            $this->doc .= $result;
        }
    }
}

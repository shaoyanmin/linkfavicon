jQuery(document).ready(function () {
    console.log('linkfavicon');
    const faviconCache = {};
    const ICON_NOT_FOUND = -1;
    const ICON_LOADING = 0;
    const ICON_LOADED = 1;

    function load(src) {
        return new Promise(function (resolve, reject) {
            const image = new Image();
            image.addEventListener('load', resolve);
            image.addEventListener('error', reject);
            image.src = src;
        });
    }

    function setIcon(faviconUrl) {
        if (faviconCache[faviconUrl] === ICON_LOADED) {
            jQuery('[data-linkfavicon="' + faviconUrl + '"]').each(function (idx, el) {
                el.style.backgroundImage = 'url(' + faviconUrl + ')';
            })
        }
    }

    jQuery('[data-linkfavicon]').each(function (idx, el) {
        const faviconUrl = el.getAttribute('data-linkfavicon');
        if (faviconCache[faviconUrl] === undefined) {
            faviconCache[faviconUrl] = ICON_LOADING;
            load(faviconUrl).then(function () {
                faviconCache[faviconUrl] = ICON_LOADED;
                setIcon(faviconUrl);
            }).catch(function () {
                faviconCache[faviconUrl] = ICON_NOT_FOUND;
            });
        }
    })

});

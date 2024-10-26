jQuery(document).ready(function () {

    jQuery('[data-linkfavicon]').each(function (idx, el) {
        el.style.backgroundImage = 'url(' + el.getAttribute('data-linkfavicon') + ')';
    })

});

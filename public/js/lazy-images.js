(function () {
    'use strict';

    function toArray(nodeList) {
        return Array.prototype.slice.call(nodeList || []);
    }

    function hydrateLazyImage(img) {
        if (!img) {
            return;
        }

        var dataSrc = img.getAttribute('data-src');
        var dataSrcset = img.getAttribute('data-srcset');
        var dataSizes = img.getAttribute('data-sizes');

        if (dataSrcset) {
            img.setAttribute('srcset', dataSrcset);
            img.removeAttribute('data-srcset');
        }

        if (dataSizes) {
            img.setAttribute('sizes', dataSizes);
            img.removeAttribute('data-sizes');
        }

        if (dataSrc) {
            img.setAttribute('src', dataSrc);
            img.removeAttribute('data-src');
        }
    }

    function getPendingLazyImages() {
        return toArray(document.querySelectorAll('img[loading="lazy"][data-src], img[loading="lazy"][data-srcset]'));
    }

    function initNativeLazyLoading() {
        getPendingLazyImages().forEach(hydrateLazyImage);
    }

    function initIntersectionObserverFallback() {
        var images = getPendingLazyImages();

        if (!images.length) {
            return;
        }

        if (!('IntersectionObserver' in window)) {
            images.forEach(hydrateLazyImage);
            return;
        }

        var observer = new IntersectionObserver(function (entries, io) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) {
                    return;
                }

                hydrateLazyImage(entry.target);
                io.unobserve(entry.target);
            });
        }, {
            rootMargin: '200px 0px',
            threshold: 0.01
        });

        images.forEach(function (img) {
            observer.observe(img);
        });
    }

    function initLazyImages() {
        if ('loading' in HTMLImageElement.prototype) {
            initNativeLazyLoading();
            return;
        }

        initIntersectionObserverFallback();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initLazyImages, { once: true });
        return;
    }

    initLazyImages();
})();

(function () {
    "use strict";

    function initStatisticsAnimation() {
        const counters = document.querySelectorAll(
            "[data-statistics-counter]"
        );

        const ratioFills = document.querySelectorAll(
            "[data-statistics-ratio]"
        );

        if (counters.length === 0 && ratioFills.length === 0) {
            return;
        }

        const formatter = new Intl.NumberFormat("id-ID");

        const reduceMotion = window.matchMedia(
            "(prefers-reduced-motion: reduce)"
        ).matches;

        function showFinalCounter(element) {
            const target = Number(element.dataset.count || 0);
            element.textContent = formatter.format(target);
        }

        function showFinalRatio(element) {
            const width = Number(element.dataset.width || 0);
            element.style.width = width + "%";
        }

        function animateCounter(element) {
            if (element.dataset.animated === "true") {
                return;
            }

            element.dataset.animated = "true";

            const target = Number(element.dataset.count || 0);

            if (reduceMotion || target <= 0) {
                showFinalCounter(element);
                return;
            }

            const duration = 1300;
            const startTime = performance.now();

            element.textContent = "0";

            function updateCounter(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);

                const easedProgress =
                    1 - Math.pow(1 - progress, 3);

                const currentValue = Math.round(
                    target * easedProgress
                );

                element.textContent =
                    formatter.format(currentValue);

                if (progress < 1) {
                    window.requestAnimationFrame(updateCounter);
                }
            }

            window.requestAnimationFrame(updateCounter);
        }

        function animateRatios() {
            ratioFills.forEach(function (element) {
                showFinalRatio(element);
            });
        }

        if (reduceMotion) {
            counters.forEach(showFinalCounter);
            ratioFills.forEach(showFinalRatio);
            return;
        }

        if (!("IntersectionObserver" in window)) {
            counters.forEach(animateCounter);
            animateRatios();
            return;
        }

        const observer = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) {
                        return;
                    }

                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                });
            },
            {
                threshold: 0.3,
            }
        );

        counters.forEach(function (counter) {
            observer.observe(counter);
        });

        window.setTimeout(animateRatios, 180);
    }

    document.addEventListener(
        "DOMContentLoaded",
        initStatisticsAnimation
    );
})();
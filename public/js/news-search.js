(function () {
    "use strict";

    function initNewsSearch() {
        const searchInput = document.querySelector("[data-news-search]");
        const newsCards = Array.from(
            document.querySelectorAll("[data-news-card]")
        );
        const emptyMessage = document.querySelector(
            "[data-news-filter-empty]"
        );

        if (!searchInput || newsCards.length === 0) {
            return;
        }

        function filterNews() {
            const keyword = searchInput.value
                .trim()
                .toLocaleLowerCase("id-ID");

            let visibleNews = 0;

            newsCards.forEach(function (card) {
                const searchableText = (
                    card.dataset.search || ""
                ).toLocaleLowerCase("id-ID");

                const isMatch = searchableText.includes(keyword);

                card.hidden = !isMatch;

                if (isMatch) {
                    visibleNews += 1;
                }
            });

            if (emptyMessage) {
                emptyMessage.hidden = visibleNews !== 0;
            }
        }

        searchInput.addEventListener("input", filterNews);
        searchInput.addEventListener("search", filterNews);
    }

    document.addEventListener("DOMContentLoaded", initNewsSearch);
})();
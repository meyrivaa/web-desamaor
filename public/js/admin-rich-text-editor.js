(function () {
    "use strict";

    function escapeHtml(value) {
        const element = document.createElement("div");

        element.textContent = value;

        return element.innerHTML;
    }

    function prepareInitialContent(value) {
        const content = value.trim();

        if (content === "") {
            return "";
        }

        /*
         * Data berita baru sudah berbentuk HTML.
         */
        if (/<[a-z][\s\S]*>/i.test(content)) {
            return content;
        }

        /*
         * Data berita lama masih berupa teks biasa.
         * Setiap baris diubah menjadi paragraf.
         */
        return content
            .split(/\r?\n/)
            .map(function (line) {
                if (line.trim() === "") {
                    return "<p><br></p>";
                }

                return "<p>" + escapeHtml(line) + "</p>";
            })
            .join("");
    }

    function initializeRichTextEditors() {
        const editorContainers = document.querySelectorAll(
            "[data-rich-text-editor]"
        );

        editorContainers.forEach(function (container) {
            const form = container.closest("form");
            const editorElement = container.querySelector(
                "[data-rich-text-area]"
            );
            const inputSelector = container.dataset.input;

            if (
                !form ||
                !editorElement ||
                !inputSelector ||
                typeof window.Quill === "undefined"
            ) {
                return;
            }

            const hiddenInput = form.querySelector(inputSelector);

            if (!hiddenInput) {
                return;
            }

            const quill = new window.Quill(editorElement, {
                theme: "snow",

                placeholder:
                    container.dataset.placeholder ||
                    "Tulis isi berita lengkap di sini...",

                modules: {
                    toolbar: [
                        [
                            {
                                header: [2, 3, false],
                            },
                        ],

                        [
                            "bold",
                            "italic",
                            "underline",
                            "strike",
                        ],

                        [
                            {
                                list: "ordered",
                            },
                            {
                                list: "bullet",
                            },
                        ],

                        [
                            "blockquote",
                            "link",
                        ],

                        [
                            "clean",
                        ],
                    ],
                },

                formats: [
                    "header",
                    "bold",
                    "italic",
                    "underline",
                    "strike",
                    "list",
                    "blockquote",
                    "link",
                ],
            });

            const initialContent = prepareInitialContent(
                hiddenInput.value
            );

            if (initialContent !== "") {
                quill.clipboard.dangerouslyPasteHTML(
                    initialContent
                );
            }

            /*
             * Sebelum formulir dikirim, salin isi editor
             * ke textarea tersembunyi yang dibaca Laravel.
             */
            form.addEventListener("submit", function () {
                const plainText = quill
                    .getText()
                    .replace(/\s/g, "");

                hiddenInput.value =
                    plainText.length > 0
                        ? quill.getSemanticHTML()
                        : "";
            });
        });
    }

    if (document.readyState === "loading") {
        document.addEventListener(
            "DOMContentLoaded",
            initializeRichTextEditors
        );
    } else {
        initializeRichTextEditors();
    }
})();
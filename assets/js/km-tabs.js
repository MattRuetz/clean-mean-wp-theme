document.addEventListener("DOMContentLoaded", function () {
    const tabItems = document.querySelectorAll(".km-tab-item");
    const tabPanels = document.querySelectorAll(".km-tab-panel");

    tabItems.forEach((tab) => {
        tab.addEventListener("click", () => {
            const tabId = tab.getAttribute("data-tab");

            // Remove active class from all tabs and panels
            tabItems.forEach((item) => item.classList.remove("active"));
            tabPanels.forEach((panel) => panel.classList.remove("active"));

            // Add active class to clicked tab and corresponding panel
            tab.classList.add("active");
            document
                .querySelector(`.km-tab-panel[data-tab="${tabId}"]`)
                .classList.add("active");
        });
    });
});

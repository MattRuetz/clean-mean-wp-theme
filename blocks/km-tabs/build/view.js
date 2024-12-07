/******/ (() => {
	// webpackBootstrap
	/*!*********************!*\
  !*** ./src/view.js ***!
  \*********************/
	/**
	 * Use this file for JavaScript code that you want to run in the front-end
	 * on posts/pages that contain this block.
	 *
	 * When this file is defined as the value of the `viewScript` property
	 * in `block.json` it will be enqueued on the front end of the site.
	 *
	 * Example:
	 *
	 * ```js
	 * {
	 *   "viewScript": "file:./view.js"
	 * }
	 * ```
	 *
	 * If you're not making any changes to this file because your project doesn't need any
	 * JavaScript running in the front-end, then you should delete this file and remove
	 * the `viewScript` property from `block.json`.
	 *
	 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/#view-script
	 */

	document.addEventListener("DOMContentLoaded", function () {
		const tabBlocks = document.querySelectorAll(".wp-block-km-tabs");
		tabBlocks.forEach((block) => {
			const buttons = block.querySelectorAll(".km-tab-button");
			const panels = block.querySelectorAll(".km-tab-panel");
			buttons.forEach((button) => {
				button.addEventListener("click", () => {
					const tabIndex = button.dataset.tabIndex;

					// Remove active class from all buttons and panels
					buttons.forEach((btn) => btn.classList.remove("active"));
					panels.forEach((panel) => panel.classList.remove("active"));

					// Add active class to clicked button and corresponding panel
					button.classList.add("active");
					panels[tabIndex].classList.add("active");
				});
			});
		});
	});
	/******/
})();
//# sourceMappingURL=view.js.map

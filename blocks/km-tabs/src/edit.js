/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {
	useBlockProps,
	RichText,
	MediaUpload,
	MediaUploadCheck,
	InspectorControls,
} from "@wordpress/block-editor";

import { PanelBody, Button } from "@wordpress/components";

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import "./editor.scss";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps();
	const { tabs, activeTab } = attributes;

	const handleTabClick = (tabId) => {
		setAttributes({ activeTab: tabId });
	};

	const updateTabContent = (field, value, tabId) => {
		const updatedTabs = tabs.map((tab) =>
			tab.tabId === tabId ? { ...tab, [field]: value } : tab,
		);
		setAttributes({ tabs: updatedTabs });
	};

	const onSelectImage = (image, tabId) => {
		const updatedTabs = tabs.map((tab) =>
			tab.tabId === tabId
				? {
						...tab,
						imageUrl: image.url,
						imageId: image.id,
				  }
				: tab,
		);
		setAttributes({ tabs: updatedTabs });
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title={__("Tab Settings", "km-tabs")}>
					{tabs.map((tab) => (
						<PanelBody key={tab.tabId} title={tab.title} initialOpen={false}>
							<MediaUploadCheck>
								<MediaUpload
									onSelect={(image) => onSelectImage(image, tab.tabId)}
									allowedTypes={["image"]}
									value={tab.imageId}
									render={({ open }) => (
										<Button
											onClick={open}
											variant="secondary"
											className="editor-post-featured-image__toggle"
										>
											{tab.imageUrl
												? __("Replace Image", "km-tabs")
												: __("Add Image", "km-tabs")}
										</Button>
									)}
								/>
							</MediaUploadCheck>
						</PanelBody>
					))}
				</PanelBody>
			</InspectorControls>

			<div {...blockProps}>
				<div className="wp-block-group km-tabs">
					<div className="wp-block-group km-tabs-container container-wide">
						<div className="wp-block-columns km-tabs-content">
							<div
								className="wp-block-column km-tabs-nav"
								style={{ flexBasis: "30%" }}
							>
								<ul className="km-tabs-list">
									{tabs.map((tab) => (
										<li
											key={tab.tabId}
											className={`km-tab-item ${
												tab.tabId === activeTab ? "active" : ""
											}`}
											onClick={() => handleTabClick(tab.tabId)}
										>
											<RichText
												tagName="span"
												value={tab.title}
												onChange={(value) =>
													updateTabContent("title", value, tab.tabId)
												}
												placeholder={__("Tab title...", "km-tabs")}
											/>
										</li>
									))}
								</ul>
							</div>
							<div
								className="wp-block-column km-tabs-panels"
								style={{ flexBasis: "70%" }}
							>
								{tabs.map((tab) => (
									<div
										key={tab.tabId}
										className={`wp-block-group km-tab-panel ${
											tab.tabId === activeTab ? "active" : ""
										}`}
										data-tab={tab.tabId}
									>
										<RichText
											tagName="h3"
											value={tab.heading}
											onChange={(value) =>
												updateTabContent("heading", value, tab.tabId)
											}
											placeholder={__("Tab heading...", "km-tabs")}
										/>
										<RichText
											tagName="p"
											value={tab.content}
											onChange={(value) =>
												updateTabContent("content", value, tab.tabId)
											}
											placeholder={__("Tab content...", "km-tabs")}
										/>
										<div className="km-tab-panel-image">
											{tab.imageUrl && (
												<figure className="wp-block-image size-large is-style-rounded tight-shadow">
													<img
														src={tab.imageUrl}
														alt=""
														style={{
															height: "300px",
															width: "100%",
															objectFit: "cover",
														}}
													/>
												</figure>
											)}
										</div>
									</div>
								))}
							</div>
						</div>
					</div>
				</div>
			</div>
		</>
	);
}

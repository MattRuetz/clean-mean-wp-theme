/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from "@wordpress/block-editor";

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {Element} Element to render.
 */
export default function save({ attributes }) {
	const { tabs, activeTab } = attributes;
	const blockProps = useBlockProps.save();

	return (
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
										data-tab={tab.tabId}
									>
										{tab.title}
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
									<h3>{tab.heading}</h3>
									<p>{tab.content}</p>
									{tab.imageUrl && (
										<div className="km-tab-panel-image">
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
										</div>
									)}
								</div>
							))}
						</div>
					</div>
				</div>
			</div>
		</div>
	);
}

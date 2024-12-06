import {
    useBlockProps,
    InspectorControls,
    MediaUpload,
    RichText,
} from "@wordpress/block-editor";
import { PanelBody, TextControl, Button } from "@wordpress/components";

export default function Edit({ attributes, setAttributes }) {
    const { tabs } = attributes;
    const blockProps = useBlockProps();

    const updateTab = (index, field, value) => {
        const newTabs = [...tabs];
        newTabs[index] = { ...newTabs[index], [field]: value };
        setAttributes({ tabs: newTabs });
    };

    const addTab = () => {
        const newTabs = [
            ...tabs,
            {
                title: "New Tab",
                heading: "",
                description: "",
                imageUrl: "",
                imageAlt: "",
            },
        ];
        setAttributes({ tabs: newTabs });
    };

    const removeTab = (index) => {
        const newTabs = tabs.filter((_, i) => i !== index);
        setAttributes({ tabs: newTabs });
    };

    return (
        <div {...blockProps}>
            <InspectorControls>
                <PanelBody title="Tabs Settings">
                    {tabs.map((tab, index) => (
                        <div key={index} className="km-tab-settings">
                            <TextControl
                                label={`Tab ${index + 1} Title`}
                                value={tab.title}
                                onChange={(value) =>
                                    updateTab(index, "title", value)
                                }
                            />
                            <TextControl
                                label="Heading"
                                value={tab.heading}
                                onChange={(value) =>
                                    updateTab(index, "heading", value)
                                }
                            />
                            <TextControl
                                label="Description"
                                value={tab.description}
                                onChange={(value) =>
                                    updateTab(index, "description", value)
                                }
                            />
                            <MediaUpload
                                onSelect={(media) => {
                                    updateTab(index, "imageUrl", media.url);
                                    updateTab(index, "imageAlt", media.alt);
                                }}
                                allowedTypes={["image"]}
                                render={({ open }) => (
                                    <Button onClick={open}>
                                        {tab.imageUrl
                                            ? "Change Image"
                                            : "Select Image"}
                                    </Button>
                                )}
                            />
                            <Button
                                isDestructive
                                onClick={() => removeTab(index)}
                            >
                                Remove Tab
                            </Button>
                        </div>
                    ))}
                    <Button isPrimary onClick={addTab}>
                        Add Tab
                    </Button>
                </PanelBody>
            </InspectorControls>

            <div className="km-tabs-container">
                <div className="km-tabs-content">
                    <div className="km-tabs-nav">
                        <ul className="km-tabs-list">
                            {tabs.map((tab, index) => (
                                <li key={index} className="km-tab-item">
                                    <RichText
                                        tagName="div"
                                        value={tab.title}
                                        onChange={(value) =>
                                            updateTab(index, "title", value)
                                        }
                                        placeholder="Tab title..."
                                    />
                                </li>
                            ))}
                        </ul>
                    </div>
                    <div className="km-tabs-panels">
                        {tabs.map((tab, index) => (
                            <div key={index} className="km-tab-panel">
                                <h3>{tab.heading}</h3>
                                <p>{tab.description}</p>
                                {tab.imageUrl && (
                                    <img
                                        src={tab.imageUrl}
                                        alt={tab.imageAlt}
                                    />
                                )}
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </div>
    );
}

<?php

/**
 * Server-side rendering of the `km/tabs` block.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The block content.
 * @param WP_Block $block      The block instance.
 *
 * @return string The rendered output.
 */
function render_km_tabs_block($attributes, $content, $block)
{
    if (! isset($attributes['tabs']) || empty($attributes['tabs'])) {
        return '';
    }

    $tabs = $attributes['tabs'];

    ob_start();
?>
    <div class="km-tabs">
        <div class="km-tabs-container">
            <div class="km-tabs-content">
                <div class="km-tabs-nav">
                    <ul class="km-tabs-list">
                        <?php foreach ($tabs as $index => $tab) : ?>
                            <li class="km-tab-item <?php echo $index === 0 ? 'active' : ''; ?>" data-tab="tab-<?php echo esc_attr($index); ?>">
                                <?php echo esc_html($tab['title']); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="km-tabs-panels">
                    <?php foreach ($tabs as $index => $tab) : ?>
                        <div class="km-tab-panel <?php echo $index === 0 ? 'active' : ''; ?>" data-tab="tab-<?php echo esc_attr($index); ?>">
                            <h3><?php echo esc_html($tab['heading']); ?></h3>
                            <p><?php echo esc_html($tab['description']); ?></p>
                            <?php if (! empty($tab['imageUrl'])) : ?>
                                <img src="<?php echo esc_url($tab['imageUrl']); ?>" alt="<?php echo esc_attr($tab['imageAlt']); ?>" />
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var tabItems = document.querySelectorAll(".km-tab-item");
            var tabPanels = document.querySelectorAll(".km-tab-panel");

            tabItems.forEach(function(tab) {
                tab.addEventListener("click", function() {
                    var tabId = tab.getAttribute('data-tab');

                    tabItems.forEach(function(item) {
                        item.classList.remove('active');
                    });

                    tabPanels.forEach(function(panel) {
                        panel.classList.remove('active');
                    });

                    tab.classList.add('active');
                    document.querySelector('.km-tab-panel[data-tab="' + tabId + '"]').classList.add('active');
                });
            });
        });
    </script>
<?php
    return ob_get_clean();
}

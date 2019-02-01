<?php
defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="store-product-filter-block" >

    <form class="<?= ($updateType == 'auto' ? 'store-product-filter-block-auto' : ''); ?>" <?= ($jumpAnchor ? 'id="filter-'. $bID .'"' : ''); ?>>

        <?php
        if (!empty($filterData)) {
            foreach ($filterData as $akhandle => $data) { ?>
                <div class="form-group">
                    <?php if ($data['type'] == 'attr') { ?>
                        <?php
                        $optiondata = $data['data'];

                        $ak = $attributes[$akhandle];
                        $matchingType = $attrFilterTypes[$akhandle]['matchingType'];
                        $invalidHiding = $attrFilterTypes[$akhandle]['invalidHiding'];

                        ?>
                        <h3><?= t($data['label'] ? $data['label'] : $ak->getAttributeKeyName()); ?></h3>

                        <?php

                        // Use to fetch type of attribute for different display
                        // $type = $ak->getAttributeType()->getAttributeTypeHandle();

                    foreach ($optiondata as $option => $count) {
                        $checked = false;
                        $disabled = false;
                        $show = true;

                        if (isset($selectedAttributes[$akhandle]) && in_array($option, $selectedAttributes[$akhandle])) {
                            $checked = true;
                        } else {
                            if ($count == 0 && $matchingType == 'and') {
                                $disabled = true;
                                if ($invalidHiding == 'hide') {
                                    $show = false;
                                }
                            }
                        }
                        ?>

                        <?php if ($show) { ?>
                        <div class="<?= ($disabled ? 'disabled' : ''); ?>">
                            <label>
                                <input type="checkbox" data-matching="<?= $matchingType; ?>"
                                    <?= ($disabled ? 'disabled="disabled"' : ''); ?>
                                    <?= ($checked ? 'checked="checked"' : ''); ?>

                                       value="<?php echo h($option); ?>" name="<?php echo $akhandle; ?>[]"/>
                                <span class="store-product-filter-block-option"><?php echo $option; ?>
                                    <?php if ($showTotals && ($matchingType == 'and' || ($matchingType == 'or' && !key_exists($akhandle, $selectedAttributes)))) { ?>
                                    <span class="store-product-filter-block-count">(<?php echo $count; ?>)</span>
                                    <?php } ?>

                                </span></label>
                        </div>
                    <?php } ?>
                    <?php }
                    } elseif ($data['type'] == 'price') { ?>

                        <?php if ($minPrice != $maxPrice) { ?>

                        <h3><?= t($data['label'] ? $data['label']  : t('Price')); ?></h3>

                        <div data-role="rangeslider">

                            <input type="hidden" class="js-range-slider" name="price" value=""
                                   data-type="double"
                                   data-min="<?= $minPrice; ?>"
                                   data-max="<?= $maxPrice; ?>"
                                   data-from="<?= $minPriceSelected; ?>"
                                   data-to="<?= $maxPriceSelected; ?>"
                                   data-input-values-separator="-"
                                   data-skin="round"
                                   data-prefix="<?= \Config::get('community_store.symbol'); ?>"
                                   data-force-edges="true"
                            />

                        </div>

                        <script>
                            $(document).ready(function () {
                                $(".js-range-slider").ionRangeSlider({
                                    <?php if ($updateType == 'auto') { ?>
                                    onFinish: function() {
                                        communityStore.submitProductFilter($('.js-range-slider'));
                                    }
                                    <?php } ?>
                                });
                            });

                        </script>
                    <?php } ?>

                    <?php } ?>

                </div>


            <?php } ?>

        <?php } ?>

        <?php if ($updateType == 'button') { ?>
            <p><button type="submit"
                    class="store-btn-filter btn btn-default btn-block"><?= ($filterButtonText ? t($filterButtonText) : t('Filter')); ?></button></p>
        <?php } ?>

        <?php if ($displayClear && (!empty($selectedAttributes) || $priceFiltering)) { ?>
            <p><button type="submit"
                    class="store-btn-filter-clear btn btn-default btn-block"><?= ($clearButtonText ? t($clearButtonText) : t('Clear')); ?></button></p>
        <?php } ?>
    </form>
</div>

<div class="form-group">
    <label class="control-label col-lg-2">
        {l s='Product Badges' mod='productbadges'}
    </label>
    <div class="col-lg-10">
        <div class="product-badges-selector">
            {if $badges|count > 0}
                {foreach $badges as $badge}
                    <label class="checkbox-inline" style="margin-right: 15px; margin-bottom: 10px; display: inline-block;">
                        <input type="checkbox" 
                               name="product_badges[]" 
                               value="{$badge.id_productbadge|intval}"
                               {if in_array($badge.id_productbadge, $selected_badges)}checked{/if}>
                        <span style="background-color: {$badge.background_color|escape:'htmlall'}; 
                                     color: {$badge.text_color|escape:'htmlall'};
                                     padding: 5px 12px;
                                     border-radius: 3px;
                                     font-size: 12px;
                                     font-weight: bold;
                                     display: inline-block;
                                     margin-left: 5px;">
                            {$badge.text|escape:'htmlall'}
                        </span>
                    </label>
                {/foreach}
            {else}
                <div class="alert alert-info">
                    {l s='No badges created yet. Create one from Catalog → Product Badges' mod='productbadges'}
                </div>
            {/if}
        </div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-lg-2">Badges</label>
    <div class="col-lg-10">
        {foreach $badges as $badge}
            <label class="checkbox-inline" style="margin-right:10px">
                <input type="checkbox" name="product_badges[]" value="{$badge.id_productbadge}" {if in_array($badge.id_productbadge, $selected_badges)}checked{/if}>
                <span style="background:{$badge.background_color};color:{$badge.text_color};padding:4px 10px;border-radius:3px;font-size:12px">
                    {$badge.text}
                </span>
            </label>
        {/foreach}
    </div>
</div>
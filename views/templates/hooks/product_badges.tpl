<div class="product-badges">
    {foreach $badges as $badge}
        <span class="product-badge" style="background:{$badge.background_color};color:{$badge.text_color}">
            {$badge.text}
        </span>
    {/foreach}
</div>
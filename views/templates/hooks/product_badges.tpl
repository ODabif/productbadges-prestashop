{if !empty($badges)}
<div class="product-badges-container listing-badges" style="position: relative; z-index: 10;">
    {foreach $badges as $badge}
        <div class="product-badge 
                    {if $badge.position == 0}badge-top-left{else}badge-top-right{/if}"
             style="background-color: {$badge.background_color|escape:'htmlall'}; 
                    color: {$badge.text_color|escape:'htmlall'};
                    position: absolute;
                    top: 10px;
                    {if $badge.position == 0}left: 10px;{else}right: 10px;{/if}
                    padding: 5px 10px;
                    font-size: 12px;
                    font-weight: bold;
                    border-radius: 3px;
                    z-index: 5;
                    box-shadow: 0 1px 3px rgba(0,0,0,0.2);">
            {$badge.text|escape:'htmlall'}
        </div>
    {/foreach}
</div>
{/if}
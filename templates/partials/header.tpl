<header class="site-header">
    <div class="container site-header__inner">
        <a href="/" class="site-header__logo">
            Pure Blog
        </a>

        <nav class="site-header__nav">
            <a href="/">Home</a>

            {if isset($navCategories) && $navCategories|count > 0}
                {foreach from=$navCategories item=navCategory}
                    <a href="/category/{$navCategory.slug}">
                        {$navCategory.name}
                    </a>
                {/foreach}
            {/if}
        </nav>
    </div>
</header>
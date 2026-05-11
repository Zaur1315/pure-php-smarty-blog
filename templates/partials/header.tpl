<header class="site-header">
    <div class="container site-header__inner">
        <a href="/" class="site-header__logo">
            <img src="/assets/images/logo.png" alt="Pure Blog">
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
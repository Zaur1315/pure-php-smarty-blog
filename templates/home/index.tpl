{extends file="layouts/base.tpl"}

{block name="content"}
    <section class="home-page">
        <div class="container">
            <div class="page-heading">
                <h1>{$title|default:'Blog'}</h1>
                <p>Latest articles by category</p>
            </div>

            {foreach from=$categories item=category}
                <section class="category-section">
                    <div class="category-section__header">
                        <div>
                            <h2>{$category.name}</h2>

                            {if $category.description}
                                <p>{$category.description}</p>
                            {/if}
                        </div>

                        <a href="/category/{$category.slug}" class="button button--outline">
                            All articles
                        </a>
                    </div>

                    {if $category.posts|count > 0}
                        <div class="post-grid">
                            {foreach from=$category.posts item=post}
                                <article class="post-card">
                                    {if $post.image}
                                        <a href="/post/{$post.slug}" class="post-card__image">
                                            <img src="{$post.image}" alt="{$post.title|escape}">
                                        </a>
                                    {/if}

                                    <div class="post-card__body">
                                        <h3>
                                            <a href="/post/{$post.slug}">
                                                {$post.title}
                                            </a>
                                        </h3>

                                        {if $post.description}
                                            <p>{$post.description}</p>
                                        {/if}

                                        <div class="post-card__meta">
                                            <span>{$post.published_at}</span>
                                            <span>{$post.views} views</span>
                                        </div>
                                    </div>
                                </article>
                            {/foreach}
                        </div>
                    {else}
                        <p>No posts found in this category.</p>
                    {/if}
                </section>
            {/foreach}
        </div>
    </section>
{/block}
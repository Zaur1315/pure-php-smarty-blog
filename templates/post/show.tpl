{extends file="layouts/base.tpl"}

{block name="content"}
    <article class="post-page">
        <div class="container container--narrow">
            <header class="post-page__header">
                <h1>{$post.title}</h1>

                <div class="post-page__meta">
                    <span>{$post.published_at}</span>
                    <span>{$post.views} views</span>
                </div>
            </header>

            {if $post.image}
                <figure class="post-page__image">
                    <img src="{$post.image}" alt="{$post.title|escape}">
                </figure>
            {/if}

            {if $post.description}
                <p class="post-page__description">
                    {$post.description}
                </p>
            {/if}

            <div class="post-page__content">
                {$post.content nofilter}
            </div>
        </div>
    </article>
    {if $relatedPosts|count > 0}
        <section class="related-posts">
            <div class="container">
                <div class="related-posts__header">
                    <h2>Related posts</h2>
                    <p>More articles from similar categories.</p>
                </div>

                <div class="post-grid">
                    {foreach from=$relatedPosts item=relatedPost}
                        <article class="post-card">
                            {if $relatedPost.image}
                                <a href="/post/{$relatedPost.slug}" class="post-card__image">
                                    <img src="{$relatedPost.image}" alt="{$relatedPost.title|escape}">
                                </a>
                            {/if}

                            <div class="post-card__body">
                                <h3>
                                    <a href="/post/{$relatedPost.slug}">
                                        {$relatedPost.title}
                                    </a>
                                </h3>

                                {if $relatedPost.description}
                                    <p>{$relatedPost.description}</p>
                                {/if}

                                <div class="post-card__meta">
                                    <span>{$relatedPost.published_at}</span>
                                    <span>{$relatedPost.views} views</span>
                                </div>
                            </div>
                        </article>
                    {/foreach}
                </div>
            </div>
        </section>
    {/if}
{/block}
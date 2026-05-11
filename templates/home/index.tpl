{extends file="layouts/base.tpl"}

{block name="content"}
    <section class="home-page">
        <div class="container">
            {if isset($sliderPosts) && $sliderPosts|count > 0}
                <section class="hero-slider js-hero-slider">
                    <div class="hero-slider__track">
                        {foreach from=$sliderPosts item=sliderPost name=sliderLoop}
                            <article class="hero-slider__slide {if $smarty.foreach.sliderLoop.first}is-active{/if}">
                                <div class="hero-slider__content">
                        <span class="hero-slider__category">
                            {$sliderPost.category_name}
                        </span>

                                    <h2>{$sliderPost.title}</h2>

                                    {if $sliderPost.description}
                                        <p>{$sliderPost.description}</p>
                                    {/if}

                                    <div class="hero-slider__meta">
                                        <span>{$sliderPost.views} views</span>
                                        <span>{$sliderPost.published_at}</span>
                                    </div>

                                    <a href="/post/{$sliderPost.slug}" class="button">
                                        Read article
                                    </a>
                                </div>

                                {if $sliderPost.image}
                                    <div class="hero-slider__image">
                                        <img src="{$sliderPost.image}" alt="{$sliderPost.title|escape}">
                                    </div>
                                {/if}
                            </article>
                        {/foreach}
                    </div>

                    {if $sliderPosts|count > 1}
                        <div class="hero-slider__controls">
                            <button type="button" class="hero-slider__button js-hero-slider-prev">
                                Previous
                            </button>

                            <div class="hero-slider__dots">
                                {foreach from=$sliderPosts item=sliderPost name=dotsLoop}
                                    <button
                                            type="button"
                                            class="hero-slider__dot js-hero-slider-dot {if $smarty.foreach.dotsLoop.first}is-active{/if}"
                                            data-slide-index="{$smarty.foreach.dotsLoop.index}"
                                            aria-label="Go to slide {$smarty.foreach.dotsLoop.iteration}"
                                    ></button>
                                {/foreach}
                            </div>

                            <button type="button" class="hero-slider__button js-hero-slider-next">
                                Next
                            </button>
                        </div>
                    {/if}
                </section>
            {/if}

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
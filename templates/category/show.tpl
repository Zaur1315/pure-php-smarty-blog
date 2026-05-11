{extends file="layouts/base.tpl"}

{block name="content"}
    <section class="category-page">
        <div class="container">
            <div class="page-heading">
                <h1>{$category.name}</h1>

                {if $category.description}
                    <p>{$category.description}</p>
                {/if}
            </div>

            <form method="get" class="filter-bar">
                <label>
                    Sort by
                    <select name="sort">
                        <option value="published_at" {if $sort === 'published_at'}selected{/if}>Date</option>
                        <option value="views" {if $sort === 'views'}selected{/if}>Views</option>
                        <option value="title" {if $sort === 'title'}selected{/if}>Title</option>
                    </select>
                </label>

                <label>
                    Direction
                    <select name="direction">
                        <option value="desc" {if $direction === 'desc'}selected{/if}>Desc</option>
                        <option value="asc" {if $direction === 'asc'}selected{/if}>Asc</option>
                    </select>
                </label>

                <button type="submit" class="button">
                    Apply
                </button>
            </form>

            {if $posts|count > 0}
                <div class="post-grid">
                    {foreach from=$posts item=post}
                        <article class="post-card">
                            {if $post.image}
                                <a href="/post/{$post.slug}" class="post-card__image">
                                    <img src="{$post.image}" alt="{$post.title|escape}">
                                </a>
                            {/if}

                            <div class="post-card__body">
                                <h2>
                                    <a href="/post/{$post.slug}">
                                        {$post.title}
                                    </a>
                                </h2>

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
                {if $totalPages > 1}
                    <nav class="pagination">
                        {if $currentPage > 1}
                            <a href="?page={$currentPage - 1}&sort={$sort}&direction={$direction}">
                                Previous
                            </a>
                        {/if}

                        {section name=page start=1 loop=$totalPages + 1}
                            <a
                                    href="?page={$smarty.section.page.index}&sort={$sort}&direction={$direction}"
                                    class="{if $smarty.section.page.index === $currentPage}is-active{/if}"
                            >
                                {$smarty.section.page.index}
                            </a>
                        {/section}

                        {if $currentPage < $totalPages}
                            <a href="?page={$currentPage + 1}&sort={$sort}&direction={$direction}">
                                Next
                            </a>
                        {/if}
                    </nav>
                {/if}
            {else}
                <p>No posts found in this category.</p>
            {/if}
        </div>
    </section>
{/block}
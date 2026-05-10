<h1>{$category.name}</h1>

{if $category.description}
    <p>{$category.description}</p>
{/if}

<hr>

<div>
    <strong>Sort by:</strong>

    <a href="/category/{$category.slug}?sort=published_at&direction=DESC">Newest</a> |
    <a href="/category/{$category.slug}?sort=views&direction=DESC">Most viewed</a> |
    <a href="/category/{$category.slug}?sort=title&direction=ASC">Title A-Z</a>
</div>

<hr>

{if $posts|count > 0}
    <ul>
        {foreach from=$posts item=post}
            <li>
                <h2>
                    <a href="/post/{$post.slug}">{$post.title}</a>
                </h2>
                <p>{$post.description}</p>

                <small>
                    Views: {$post.views} |
                    Published: {$post.published_at}
                </small>
            </li>
        {/foreach}
    </ul>
{else}
    <p>No posts found.</p>
{/if}

{if $pagination.pages > 1}
    <nav>
        {section name=page start=1 loop=$pagination.pages+1}
            {assign var=pageNumber value=$smarty.section.page.index}

            {if $pageNumber == $pagination.page}
                <strong>{$pageNumber}</strong>
            {else}
                <a href="/category/{$category.slug}?page={$pageNumber}&sort={$sorting.sort}&direction={$sorting.direction}">
                    {$pageNumber}
                </a>
            {/if}
        {/section}
    </nav>
{/if}

<p>
    <a href="/">Back to home</a>
</p>
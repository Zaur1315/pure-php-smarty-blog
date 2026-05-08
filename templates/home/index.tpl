<h1>Blog</h1>

{foreach from=$categories item=category}
    <section>
        <h2>{$category.name}</h2>

        {if $category.description}
            <p>{$category.description}</p>
        {/if}

        {if $category.posts|count > 0}
            <ul>
                {foreach from=$category.posts item=post}
                    <li>
                        <h3>{$post.title}</h3>
                        <p>{$post.description}</p>
                        <small>
                            Views: {$post.views} |
                            Published: {$post.published_at}
                        </small>
                    </li>
                {/foreach}
            </ul>
        {else}
            <p>No posts yet.</p>
        {/if}

        <a href="/category/{$category.slug}">All articles</a>
    </section>
{/foreach}

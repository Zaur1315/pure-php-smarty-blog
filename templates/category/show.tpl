<h1>{$category.name}</h1>

<p>{$category.description}</p>

<hr>

{if $posts|count > 0}
    <ul>
        {foreach from=$posts item=post}
            <li>
                <h2>{$post.title}</h2>

                <p>{$post.description}</p>

                <small>
                    Views: {$post.views}
                </small>
            </li>
        {/foreach}
    </ul>
{else}
    <p>No posts found.</p>
{/if}

<article>
    <h1>{$post.title}</h1>

    <p>
        <small>
            Views: {$post.views} |
            Published: {$post.published_at}
        </small>
    </p>

    {if $post.description}
        <p>{$post.description}</p>
    {/if}

    <hr>

    <div>
        {$post.content}
    </div>
</article>

<h2>Related posts</h2>

{if $relatedPosts|count > 0}
    <ul>
        {foreach from=$relatedPosts item=relatedPost}
            <li>
                <h3>
                    <a href="/post/{$relatedPost.slug}">
                        {$relatedPost.title}
                    </a>
                </h3>

                <p>{$relatedPost.description}</p>

                <small>
                    Views: {$relatedPost.views} |
                    Published: {$relatedPost.published_at}
                </small>
            </li>
        {/foreach}
    </ul>
{else}
    <p>No related posts found.</p>
{/if}

<p>
    <a href="/">Back to home</a>
</p>
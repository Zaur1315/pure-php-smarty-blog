{extends file="layouts/base.tpl"}

{block name="content"}
    <section class="error-page">
        <div class="container container--narrow">
            <h1>404</h1>
            <p>{$message|default:'Page not found'}</p>

            <a href="/" class="button">
                Back to home
            </a>
        </div>
    </section>
{/block}
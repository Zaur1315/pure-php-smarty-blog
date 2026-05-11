{extends file="layouts/base.tpl"}

{block name="content"}
    <section class="error-page">
        <div class="container container--narrow">
            <div class="error-page__card">
                <span class="error-page__code">404</span>

                <h1>Page not found</h1>

                <p>
                    {$message|default:'The page you are looking for does not exist or has been moved.'}
                </p>

                <a href="/" class="button">
                    Back to home
                </a>
            </div>
        </div>
    </section>
{/block}
{if $vCaptcha == 2 && $visible == false}
    <button class="btn btn-primary g-recaptcha" data-sitekey="{$secret_client}" data-callback='onSubmit'>Enviar</button>
{elseif $vCaptcha == 2}
    <div id="html_element"></div>
    <button type="submit" class="btn btn-primary">Enviar</button>
{else}
    <button class="btn btn-primary g-recaptcha"
            data-sitekey="{$secret_client}"
            data-callback='onSubmit'
            data-action='submit'>Enviar
    </button>
{/if}
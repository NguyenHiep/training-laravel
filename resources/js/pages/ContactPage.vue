<template>
    <section class="container main-content">
        <div class="row">
            <div class="col-12 col-lg-12">
                <article class="message is-info">
                    <div class="message-header">
                        <h1 class="title is-size-4 has-text-white">{{ $t('Terms of use - Disclaimer') }}</h1>
                    </div>
                    <div class="message-body is-size-5 help-section" v-html="$t('content_page_tnc')"></div>
                </article>
            </div>
        </div>
    </section>
</template>
<script>
    export default {}
</script>

<template>
    <!-- Begin .main-nav -->
    <nav class="main-nav navbar p-0">
        <div class="container">
            <div class="logo">
                <a href="/"><img class="logo-img" src="/images/logo.png" alt="logo" /></a>
                <h1 class="logo-title"><a href="/">{{ $t('Company Review') }}</a></h1>
            </div>
            <div class="list-languages">
                <ul class="list-unstyled m-0">
                    <li class="nav-item dropdown">
                        <a id="dropdown_select_language" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-language"></i>
                            <span class="country-name"> {{ $t('selector.language.' + $root.$i18n.locale + '.label') }}</span>
                        </a>
                        <div v-if="$t('selector.language')" class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown_select_language">
                            <a class="dropdown-item" href="javascript:void(0)"
                               v-for="(language, key) in $t('selector.language')"
                               :key="key"
                               @click="switcherLanguage(key); $root.$i18n.locale = key"
                            >
                                <span v-html="language.flag"></span>
                                <span class="country-name">{{ language.label }}</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End .main-nav -->
</template>
<script>
  export default {
    methods: {
      switcherLanguage: function (language) {
        moment.locale(language); // Set location moment
        axios.get('/language/' + language).then(response => {
        }).catch(error => {
          console.log(error);
        }).finally(function () {
        })
      }
    }
  }
</script>

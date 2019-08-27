import VueRecaptcha from 'vue-recaptcha';
import _ from 'lodash';

// TODO: move site key
const SITE_KEY = '6LfNBrQUAAAAAO8s0CWXvr8IsXFvATYatJ01Hor1';

export default {
    components: {
        VueRecaptcha
    },
    props: {
        apiList: {
            storedComment: {
                type: String,
                required: true
            }
        },
        company: {
            type: Object,
            required: true
        }
    },
    data: function() {
        return this.resetData();
    },
    methods: {
        onVerify: function (response) {
            if (!_.isEmpty(response)) { // If Verify success
                this.verifyReCaptcha = true;
                this.g_recaptcha_response = response;
            }
        },
        onExpired: function () {  // Expired reCaptCha
            this.g_recaptcha_response = '';
            this.verifyReCaptcha = false;
        },
        resetRecaptcha() {
            this.$refs.recaptcha.reset(); // Direct call reset method
            this.verifyReCaptcha = false;
            this.g_recaptcha_response = '';
        },
        resetData: function () {
            return {
                siteKey: SITE_KEY,
                comment: {
                    reviewer: '',
                    position: '',
                    content: '',
                    store: '3',
                },
                verifyReCaptcha: false,
                g_recaptcha_response: '',
                loading: false,
                errored: false
            }
        },
    },
};

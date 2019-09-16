export default {
    filters: {
        showTimeAgo: function (dateTime) {
            return moment(dateTime).fromNow();
        }
    }
};

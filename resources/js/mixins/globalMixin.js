export default {
    filters: {
        showTimeAgo: function (dateTime) {
            return moment(dateTime).fromNow();
        },
        limitWord: function (txtContent, numberWord = 150, separator = '...') {
            return _.truncate(txtContent, {
                'length': numberWord,
                'separator': separator
            });
        }
    }
};

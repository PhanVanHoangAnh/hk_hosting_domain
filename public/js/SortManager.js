// sort
var SortManager = function() {
    var theList;
    var sortButtons;
    var currentSortBy;
    var currentSortDirection;

    var sort = function(sortBy, sortDirection) {
        setSort(sortBy, sortDirection);

        // // load list
        theList.load();
    };

    var setSort = function(sortBy, sortDirection) {
        currentSortBy = sortBy;
        currentSortDirection = sortDirection;
    };

    var getButtonBySortBy = function(sortBy) {
        var selectedButton;

        sortButtons.forEach(button => {
            if (sortBy == button.getAttribute('sort-by')) {
                selectedButton = button;
                return;
            }
        });

        return selectedButton;
    };

    var isCurrentButton = function(button) {
        var sortBy = button.getAttribute('sort-by');

        return currentSortBy == sortBy;
    };

    return {
        init: function(list) {
            theList = list;
            sortButtons = theList.getContent().querySelectorAll('[list-action="sort"]');

            // click on sort buttons
            sortButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    var sortBy = button.getAttribute('sort-by');
                    var sortDirection = button.getAttribute('sort-direction');

                    // đảo chiều sort nếu đang current
                    if (currentSortBy == sortBy) {
                        if (sortDirection == 'asc') {
                            sortDirection = 'desc';
                        } else {
                            sortDirection = 'asc';
                        }
                    }

                    sort(sortBy, sortDirection);
                });
            });
        },

        getSortBy: function() {
            return currentSortBy;
        },

        getSortDirection: function() {
            return currentSortDirection;
        },

        setSort: setSort,
    };
}();
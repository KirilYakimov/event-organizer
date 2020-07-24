$(document).ready(function() {
    $(document).on("click", 'a[data-toggle="collapse"]', function(onclick) {
        onclick.stopPropagation();
    });
});
require.config({
    paths: {
        "jquery": "https://code.jquery.com/jquery-3.6.0.min",
        "DataTable": "https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min"
    },
    waitSeconds: 10
});

require( ["jquery","DataTable"], function ($) {
    $(document).ready(function() {
        $('#news_table').DataTable({
            paging: false
        })
    })
})

$(document).ready(function() {
    $('.select-all').click(function(event) {
        $(this).closest('.grid').find('[type="checkbox"]').prop('checked', true);
    });
    $('.select-none').click(function(event) {
        $(this).closest('.grid').find('[type="checkbox"]').prop('checked', false);
    });
});
$(document).ready(function() {
    // Initialize datepickers
    $('input[type="date"]').each(function() {
        if (!$(this).val()) {
            $(this).val(new Date().toISOString().substr(0, 10));
        }
    });

    // Initialize DataTables
    $('table#dataTable').DataTable({
        responsive: true,
        dom: '<"top"f>rt<"bottom"lip><"clear">',
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search...",
        }
    });

    // Initialize Select2
    $('.select2').select2({
        width: '100%',
        placeholder: 'Select an option'
    });

    // Toggle filter visibility
    $('.toggle-filters').click(function() {
        $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
        $('.report-filter').slideToggle();
    });

    // Print report
    $('.btn-print').click(function() {
        window.print();
    });
});
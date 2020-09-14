$(function () {
    const fields = ['vehicle_type_id', 'vehicle_make_id'];

    function refreshOptions() {
        const query = $('#create_vehicle_form').serializeArray()
            .filter(o => o.name && o.name !== '_token')
            .map(o => `${encodeURIComponent(o.name)}=${encodeURIComponent(o.value)}`)
            .join('&');
        window.location.href = `?${query}`;
    }

    // when a field changes, refresh the options
    fields.forEach(field => {
        $(`#${field}`).on('change', refreshOptions);
    });

    $('#create_vehicle_form').on('submit', function(e) {
        $('#btn-create').attr('disabled', true);
    });
});

jQuery(document).ready(function ($) {
  function loadCleaners(page = 1) {
    const wrapper = $('#cleaner-table-wrapper');
    const file = wrapper.data('file');
    const perPage = wrapper.data('per-page');

    $.ajax({
      url: cp_ajax.ajax_url,
      method: 'POST',
      data: {
        action: 'load_cleaners',
        file: file,
        per_page: perPage,
        page: page
      },
      beforeSend: function () {
        wrapper.html('<div class="cp-loader">Loading...</div>');
      },
      success: function (res) {
        if (res.success) {
          wrapper.html(res.data);
        } else {
          wrapper.html('<p>Error loading data</p>');
        }
      }
    });
  }

  // Initial load
  loadCleaners();

  // Delegate pagination clicks
  $(document).on('click', '#cleaner-table-wrapper button[data-page]', function () {
    const page = $(this).data('page');
    loadCleaners(page);
  });
});

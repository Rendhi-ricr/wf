<?= $this->extend('bo_layouts/base/bo') ?>
<?= $this->section('title') ?>Agenda<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Ajax Sourced Server-side -->
    <div class="card">
        <div class="card-datatable text-nowrap">
            <table class="datatables-ajax table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Date Post</th>
                        <th>User</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!--/ Ajax Sourced Server-side -->
</div>
<?= $this->endSection() ?>



<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" href="<?= base_url()?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
<link rel="stylesheet" href="<?= base_url()?>assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
<link rel="stylesheet" href="<?= base_url()?>assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
<link rel="stylesheet" href="<?= base_url()?>assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
<?= $this->endSection() ?>

<?= $this->section('vendorJS') ?>
<script src="<?= base_url()?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<?= $this->endSection() ?>

<?= $this->section('pageJS') ?>
<script>
    'use strict';

    $(function () {
        var dt_ajax_table = $('.datatables-ajax');

        if (dt_ajax_table.length) {
            var dt_ajax = dt_ajax_table.dataTable({
                processing: true,
                serverSide: true,
                ordering: false,  // Menonaktifkan sorting secara global
                ajax: {
                    url: '<?= site_url("panel/agenda/fetch");?>',
                    type: "POST",
                    data: function(d) {
                        // console.log(d); // Tambahkan ini untuk debugging
                        return d;
                    }
                },
                dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-6 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end mt-n6 mt-md-0"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                // dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end mt-n6 mt-md-0"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                language: {
                    paginate: {
                        next: '<i class="ti ti-chevron-right ti-sm"></i>',
                        previous: '<i class="ti ti-chevron-left ti-sm"></i>'
                    }
                },
                buttons: [
                    {
                        extend: 'collection',
                        className: 'btn btn-label-primary dropdown-toggle me-4 waves-effect waves-light border-none',
                        text: '<i class="ti ti-file-export ti-xs me-sm-1"></i> <span class="d-none d-sm-inline-block">Export</span>',
                        buttons: [
                            {
                            extend: 'print',
                            text: '<i class="ti ti-printer me-1" ></i>Print',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5],
                                // prevent avatar to be display
                                format: {
                                body: function (inner, coldex, rowdex) {
                                    if (inner.length <= 0) return inner;
                                    var el = $.parseHTML(inner);
                                    var result = '';
                                    $.each(el, function (index, item) {
                                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                                        result = result + item.lastChild.firstChild.textContent;
                                    } else if (item.innerText === undefined) {
                                        result = result + item.textContent;
                                    } else result = result + item.innerText;
                                    });
                                    return result;
                                }
                                }
                            },
                            customize: function (win) {
                                //customize print view for dark
                                $(win.document.body)
                                .css('color', config.colors.headingColor)
                                .css('border-color', config.colors.borderColor)
                                .css('background-color', config.colors.bodyBg);
                                $(win.document.body)
                                .find('table')
                                .addClass('compact')
                                .css('color', 'inherit')
                                .css('border-color', 'inherit')
                                .css('background-color', 'inherit');
                            }
                            },
                            {
                            extend: 'csv',
                            text: '<i class="ti ti-file-text me-1" ></i>Csv',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5],
                                // prevent avatar to be display
                                format: {
                                body: function (inner, coldex, rowdex) {
                                    if (inner.length <= 0) return inner;
                                    var el = $.parseHTML(inner);
                                    var result = '';
                                    $.each(el, function (index, item) {
                                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                                        result = result + item.lastChild.firstChild.textContent;
                                    } else if (item.innerText === undefined) {
                                        result = result + item.textContent;
                                    } else result = result + item.innerText;
                                    });
                                    return result;
                                }
                                }
                            }
                            },
                            {
                            extend: 'excel',
                            text: '<i class="ti ti-file-spreadsheet me-1"></i>Excel',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5],
                                // prevent avatar to be display
                                format: {
                                body: function (inner, coldex, rowdex) {
                                    if (inner.length <= 0) return inner;
                                    var el = $.parseHTML(inner);
                                    var result = '';
                                    $.each(el, function (index, item) {
                                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                                        result = result + item.lastChild.firstChild.textContent;
                                    } else if (item.innerText === undefined) {
                                        result = result + item.textContent;
                                    } else result = result + item.innerText;
                                    });
                                    return result;
                                }
                                }
                            }
                            },
                            {
                            extend: 'pdf',
                            text: '<i class="ti ti-file-description me-1"></i>Pdf',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5],
                                // prevent avatar to be display
                                format: {
                                body: function (inner, coldex, rowdex) {
                                    if (inner.length <= 0) return inner;
                                    var el = $.parseHTML(inner);
                                    var result = '';
                                    $.each(el, function (index, item) {
                                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                                        result = result + item.lastChild.firstChild.textContent;
                                    } else if (item.innerText === undefined) {
                                        result = result + item.textContent;
                                    } else result = result + item.innerText;
                                    });
                                    return result;
                                }
                                }
                            }
                            },
                            {
                            extend: 'copy',
                            text: '<i class="ti ti-copy me-1" ></i>Copy',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5],
                                // prevent avatar to be display
                                format: {
                                body: function (inner, coldex, rowdex) {
                                    if (inner.length <= 0) return inner;
                                    var el = $.parseHTML(inner);
                                    var result = '';
                                    $.each(el, function (index, item) {
                                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                                        result = result + item.lastChild.firstChild.textContent;
                                    } else if (item.innerText === undefined) {
                                        result = result + item.textContent;
                                    } else result = result + item.innerText;
                                    });
                                    return result;
                                }
                                }
                            }
                            }
                        ]
                    },
                    {
                        text: '<i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New Record</span>',
                        className: 'create-new btn btn-primary waves-effect waves-light',
                        action: function (e, dt, button, config) {
                            window.location = '<?= site_url("panel/agenda/tambah") ?>';
                        }
                    }
                ],
            });

            $('div.head-label').html('<h5 class="card-title mb-0">Ajax Sourced Server-side</h5>');
        }
    });
</script>
<?= $this->endSection() ?>
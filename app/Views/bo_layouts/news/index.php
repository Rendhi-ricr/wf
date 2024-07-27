<?= $this->extend('bo_layouts/base/bo') ?>
<?= $this->section('title') ?>News<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid p-0">

    <div class="mb-3">
        <div class="row">
            <div class="col-md-6">
                <h1 class="h3 d-inline align-middle">News</h1>
            </div>
            <div class="col-md-6">
                <div class="text-end">
                    <button id="refreshButton" class="btn btn-secondary me-2" title="Refresh"><i class="ti ti-refresh ti-sm"></i> Refresh Data</button>
                    <a href="<?= site_url('panel/news/tambah') ?>" class="btn btn-primary"><i class="ti ti-plus ti-sm"></i> Tambah</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">

                    <?= $this->include('bo_layouts/alerts/success'); ?>

                    <ul class="nav nav-pills text-end mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="publish-tab" data-bs-toggle="pill" data-bs-target="#publish" type="button" role="tab" aria-controls="publish" aria-selected="true">Publish</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="draft-tab" data-bs-toggle="pill" data-bs-target="#draft" type="button" role="tab" aria-controls="draft" aria-selected="false">Draft</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="trash-tab" data-bs-toggle="pill" data-bs-target="#trash" type="button" role="tab" aria-controls="trash" aria-selected="false">Trash</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="publish" role="tabpanel" aria-labelledby="publish-tab" tabindex="0">

                            <button id="trash-btn-publish" class="btn btn-danger"><i class="ti ti-trash ti-sm"></i></button>
                            <div class="table-responsive">
                                <table id="news-publish-ajax" class="table">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="select-all-publish"></th>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Status</th>
                                            <th>Date Post</th>
                                            <th>User</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="draft" role="tabpanel" aria-labelledby="draft-tab" tabindex="0">

                            <button id="trash-btn-draft" class="btn btn-danger"><i class="ti ti-trash ti-sm"></i></button>
                            <div class="table-responsive">
                                <table id="news-draft-ajax" class="table">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="select-all-draft"></th>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Status</th>
                                            <th>Date Post</th>
                                            <th>User</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="trash" role="tabpanel" aria-labelledby="trash-tab" tabindex="0">

                            <div class="table-responsive">
                                <table id="news-trash-ajax" class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Status</th>
                                            <th>Date Post</th>
                                            <th>User</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <!-- Modal Delete -->
            <div class="modal fade" id="konfirmasiHapusData" tabindex="-1" aria-labelledby="konfirmasiHapusDataLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="konfirmasiHapusDataLabel">Hapus Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="title-delete text-danger"></span>
                            <p>Apakah Data Ini Akan di Hapus ?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                            <a class="btn btn-danger btn-ok">Ya, Hapus data</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmModalLabel">Konfirmasi penghapusan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin membuang data yang dipilih?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" id="confirm-delete-btn" class="btn btn-danger">Ya, Hapus data</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('pageCSS') ?>
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.1.0/b-3.1.0/b-html5-3.1.0/b-print-3.1.0/sl-2.0.3/datatables.min.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('pageJS') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.1.0/b-3.1.0/b-html5-3.1.0/b-print-3.1.0/sl-2.0.3/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        var tablePublish = $('#news-publish-ajax').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: {
                url: '<?= site_url("panel/news/fetch-publish"); ?>',
                type: "POST",
                data: function(d) {
                    // console.log(d); // Tambahkan ini untuk debugging
                    return d;
                }
            },
            language: {
                "search": "",
                "lengthMenu": "_MENU_"
            },
            columnDefs: [{
                "targets": [1], // Indeks kolom yang akan disembunyikan
                "visible": false // Atur visibilitas kolom menjadi false
            }],
        });

        // Handle row checkbox click
        $('#news-publish-ajax tbody').on('click', 'input.row-select', function() {
            $(this).closest('tr').toggleClass('selected');
        });

        // Handle select all checkbox
        $('#select-all-publish').on('click', function() {
            var isChecked = $(this).is(':checked');
            $('input.row-select').prop('checked', isChecked).closest('tr').toggleClass('selected', isChecked);
        });

        // Handle delete button click
        $('#trash-btn-publish').on('click', function() {
            var ids = tablePublish.rows('.selected').data().pluck(1).toArray();
            if (ids.length > 0) {
                $('#confirmModal').modal('show');
            }
        });

        // Handle confirm delete button click
        $('#confirm-delete-btn').on('click', function() {
            var ids = tablePublish.rows('.selected').data().pluck(1).toArray();
            if (ids.length > 0) {
                $.ajax({
                    url: "<?= site_url('panel/news/trash-selected'); ?>",
                    method: 'POST',
                    data: {
                        ids: ids
                    },
                    success: function(response) {
                        $('#confirmModal').modal('hide');
                        tablePublish.ajax.reload();
                    }
                });
            }
        });



        // newsDraft
        var tableDraft = $('#news-draft-ajax').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: {
                url: '<?= site_url("panel/news/fetch-draft"); ?>',
                type: "POST",
                data: function(d) {
                    // console.log(d); // Tambahkan ini untuk debugging
                    return d;
                }
            },
            language: {
                "search": "",
                "lengthMenu": "_MENU_"
            },
            columnDefs: [{
                "targets": [1], // Indeks kolom yang akan disembunyikan
                "visible": false // Atur visibilitas kolom menjadi false
            }],
        });

        // Handle row checkbox click
        $('#news-draft-ajax tbody').on('click', 'input.row-select', function() {
            $(this).closest('tr').toggleClass('selected');
        });

        // Handle select all checkbox
        $('#select-all-draft').on('click', function() {
            var isChecked = $(this).is(':checked');
            $('input.row-select').prop('checked', isChecked).closest('tr').toggleClass('selected', isChecked);
        });

        // Handle delete button click
        $('#trash-btn-draft').on('click', function() {
            var ids = tableDraft.rows('.selected').data().pluck(1).toArray();
            if (ids.length > 0) {
                $('#confirmModal').modal('show');
            } else {
                alert('No rows selected');
            }
        });

        // Handle confirm delete button click
        $('#confirm-delete-btn').on('click', function() {
            var ids = tableDraft.rows('.selected').data().pluck(1).toArray();
            if (ids.length > 0) {
                $.ajax({
                    url: "<?= site_url('panel/news/trash-selected'); ?>",
                    method: 'POST',
                    data: {
                        ids: ids
                    },
                    success: function(response) {
                        $('#confirmModal').modal('hide');
                        tableDraft.ajax.reload();
                    }
                });
            } else {
                alert('No rows selected');
            }
        });



        // newsTrash
        var tableTrash = $('#news-trash-ajax').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: {
                url: '<?= site_url("panel/news/fetch-trash"); ?>',
                type: "POST",
                data: function(d) {
                    // console.log(d); // Tambahkan ini untuk debugging
                    return d;
                }
            },
            language: {
                "search": "",
                "lengthMenu": "_MENU_"
            },
            columnDefs: [{
                "targets": [0], // Indeks kolom yang akan disembunyikan
                "visible": false // Atur visibilitas kolom menjadi false
            }],
        });

        // Handle row checkbox click
        $('#news-trash-ajax tbody').on('click', 'input.row-select', function() {
            $(this).closest('tr').toggleClass('selected');
        });

        // Handle select all checkbox
        $('#select-all-trash').on('click', function() {
            var isChecked = $(this).is(':checked');
            $('input.row-select').prop('checked', isChecked).closest('tr').toggleClass('selected', isChecked);
        });

        // Handle delete button click
        $('#trash-btn-trash').on('click', function() {
            var ids = tableTrash.rows('.selected').data().pluck(1).toArray();
            if (ids.length > 0) {
                $.ajax({
                    url: "<?= site_url('panel/news/trash-selected'); ?>",
                    method: 'POST',
                    data: {
                        ids: ids
                    },
                    success: function(response) {
                        tableTrash.ajax.reload();
                    }
                });
            } else {
                alert('No rows selected');
            }
        });

        // Handle delete button click
        $('#trash-btn-trash').on('click', function() {
            var ids = tableTrash.rows('.selected').data().pluck(1).toArray();
            if (ids.length > 0) {
                $('#confirmModal').modal('show');
            } else {
                alert('No rows selected');
            }
        });

        // Handle confirm delete button click
        $('#confirm-delete-btn').on('click', function() {
            var ids = tableTrash.rows('.selected').data().pluck(1).toArray();
            if (ids.length > 0) {
                $.ajax({
                    url: "<?= site_url('panel/news/trash-selected'); ?>",
                    method: 'POST',
                    data: {
                        ids: ids
                    },
                    success: function(response) {
                        $('#confirmModal').modal('hide');
                        tableTrash.ajax.reload();
                    }
                });
            } else {
                alert('No rows selected');
            }
        });

        // Fungsi untuk refresh DataTable
        $('#refreshButton').on('click', function() {
            tablePublish.ajax.reload();
            tableDraft.ajax.reload();
            tableTrash.ajax.reload(); // Jika menggunakan Ajax untuk memuat data
            // table.draw(); // Jika hanya ingin menyegarkan tampilan tabel
        });

    });
</script>

<script>
    $('#konfirmasiHapusData').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        $('.title-delete').html($(e.relatedTarget).data('title'));
    });
</script>
<?= $this->endSection() ?>
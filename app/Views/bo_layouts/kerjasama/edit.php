<?= $this->extend('bo_layouts/base/bo') ?>
<?= $this->section('title') ?>ks<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="mb-3">
        <div class="row">
            <div class="col-md-12">
                <h1 class="h3 d-inline align-middle">ks</h1>
            </div>
        </div>
    </div>

    <!-- Tambah::Start -->
    <form id="editor-form" action="<?= site_url('panel/ks/' . $dataKs['id_ks'] . '/edit') ?>" method="post" enctype="multipart/form-data">
        <div class="card">
            <div class="card-body">

                <?= $this->include('bo_layouts/alerts/errors'); ?>

                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label" for="judul">Judul</label>
                                <input type="text" name="title_ks" value="<?= $dataKs['title_ks'] ?>" id="judul" class="form-control mb-3" />
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div>
                            <label class="form-label" for="foto">Foto</label>
                            <input type="file" name="photo_cover" class="form-control mb-3" id="foto" onchange="previewImage(event)">
                        </div>
                        <?php if ($dataKs['photo_cover']) : ?>
                            <img id="preview" src="<?= base_url('uploads/kerjasama/' . $dataKs['photo_cover']) ?>" alt="Preview Image" class="img-thumbnail mb-3" style="max-width: 100%; height: auto;">
                        <?php else : ?>
                            <img id="preview" src="#" alt="Preview Image" class="img-thumbnail mb-3" style="display: none; max-width: 100%; height: auto;">
                        <?php endif ?>

                    </div>
                </div>

            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </div>
    </form>
    <!--/ Tambah::End -->
</div>
<?= $this->endSection() ?>



<?= $this->section('pageCSS') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">
<link href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css" rel="stylesheet" />
<?= $this->endSection() ?>

<?= $this->section('pageJS') ?>
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>

<script>
    $('#sta, #eta').flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i", // Format 24 jam
        time_24hr: true
    });

    $('#da').flatpickr({
        altInput: true,
        altFormat: 'Y-m-d',
        dateFormat: 'Y-m-d'
    });

    const snowEditor = new Quill('#snow-editor', {
        bounds: '#snow-editor',
        placeholder: 'Type Something...',
        modules: {
            formula: false,
            toolbar: [
                [{
                    header: [1, 2, 3, false]
                }],
                ['bold', 'italic', 'underline'],
                [{
                    'align': []
                }],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                [{
                    'indent': '-1'
                }, {
                    'indent': '+1'
                }],
                ['link', 'image', 'video'],
            ]
        },
        theme: 'snow'
    });

    document.getElementById('editor-form').addEventListener('submit', function() {
        // Salin konten dari editor Quill ke dalam textarea sebelum form disubmit
        document.getElementById('content').value = snowEditor.root.innerHTML;
        console.log('Form data:', document.getElementById('content').value);
    });

    function previewImage(event) {
        const input = event.target;
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('preview');
            preview.src = reader.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
</script>
<?= $this->endSection() ?>
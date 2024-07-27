<?= $this->extend('bo_layouts/base/bo') ?>
<?= $this->section('title') ?>Agenda<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Tambah::Start -->
    <form id="editor-form" action="" method="post">
    <div class="card">
        <h5 class="card-header">Form Tambah Agenda</h5>
        <div class="card-body">
            
            <div class="row mb-3">
                <div class="col-md-8">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label" for="judul">Judul</label>
                            <input type="text" name="title_agenda" id="judul" class="form-control mb-3" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="sta">Start Time Agenda</label>
                            <input type="text" name="starttime_agenda" id="sta" class="form-control mb-3" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="eta">End Time Agenda</label>
                            <input type="text" name="endtime_agenda" id="eta" class="form-control mb-3" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="da">Date Agenda</label>
                            <input type="text" name="date_agenda" id="da" class="form-control mb-3" />
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="location">Location</label>
                            <input type="text" name="location" id="location" class="form-control mb-3" />
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="snow-editor">Description</label>
                            <div id="snow-editor"></div>
                            <textarea name="desc_agenda" id="content" class="d-none"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div>
                        <label class="form-label" for="form-repeater-1-4">Kategori</label>
                        <select name="id_category" id="form-repeater-1-4" class="form-select mb-3">
                            <option value="0">-- Kategori --</option>
                            <option value="kategori1">Kategori 1</option>
                            <option value="kategori2">Kategori 2</option>
                            <option value="kategori3">Kategori 3</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <div class="form-check">
                            <input type="radio" id="status-publish" name="status" value="publish" class="form-check-input" />
                            <label class="form-check-label badge bg-primary mb-3" for="status-publish">Publish</label>
                        </div>
                    </div>
                    <div class="form-check">
                        <input type="radio" id="status-draft" name="status" value="draft" class="form-check-input" />
                        <label class="form-check-label badge bg-warning mb-3" for="status-draft">Draft</label>
                    </div>
                    <div>
                        <label class="form-label" for="foto">Foto</label>
                        <input type="file" name="photo_cover" class="form-control mb-3" id="foto" onchange="previewImage(event)">
                    </div>
                    <img id="preview" src="#" alt="Preview Image" class="img-thumbnail mb-3" style="display: none; max-width: 100%; height: auto;">
                    <div>
                        <label class="form-label" for="pd">Photo Description</label>
                        <textarea name="photo_desc" id="pd" class="form-control "></textarea>
                    </div>

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



<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" href="<?= base_url()?>assets/vendor/libs/flatpickr/flatpickr.css" />
<link href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css" rel="stylesheet"/>
<?= $this->endSection() ?>

<?= $this->section('vendorJS') ?>
<script src="<?= base_url()?>assets/vendor/libs/moment/moment.js"></script>
<script src="<?= base_url()?>assets/vendor/libs/flatpickr/flatpickr.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>
<?= $this->endSection() ?>

<?= $this->section('pageJS') ?>
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
                [{ header: [1, 2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'align': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                ['link', 'image', 'video'],
            ]
        },
        theme: 'snow'
    });

    document.getElementById('editor-form').addEventListener('submit', function() {
      // Salin konten dari editor Quill ke dalam textarea sebelum form disubmit
      document.getElementById('content').value = snowEditor.root.innerHTML;
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
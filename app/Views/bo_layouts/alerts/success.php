<?php if(!empty(session()->getFlashdata('message'))): ?>
<div class="alert alert-success alert-dismissible fade show p-3" role="alert">
    <?= session()->getFlashdata('message') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif ?>
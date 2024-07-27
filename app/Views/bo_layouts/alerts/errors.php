<?php if(isset($validation) || isset($error)): ?> 
<div class="alert alert-danger alert-dismissible fade show p-3" role="alert">
    <?php 
        echo $validation->listErrors();
        echo $error ?? '';
    ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif ?>

<div class="wrap">
    <h2><?= __('Automatski cenovnici') ?></h2>
    <?php if (isset($_GET['message'])) {
        echo '<div class="notice notice-success is-dismissible">
                        <p><strong>Uspešno ste izvršili promene!</strong></p>
                        <button type="button" class="notice-dismiss">
                            <span class="screen-reader-text">Dismiss this notice.</span>
                        </button>
                   </div>';
    } ?>
    <p>1. Izaberite dokument (.CSV) klikom na dugme "Choose File"</p>
    <p>2. Kliknite na dugme "Submit" kako bi izvršili promene</p>

    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" value="" name="automatskiCenovnikFile">
        <input type="hidden" value="success" name="success-message">
        <input type="submit">
    </form>
</div>
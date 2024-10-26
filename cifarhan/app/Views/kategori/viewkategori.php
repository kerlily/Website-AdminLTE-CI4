<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
ini adalah menu kategori
<?= $this->endSection('judul') ?>
Tambah kategori
<?= $this->section('subjudul') ?>
<?= form_button('', '<i class ="fa fa-plus-circle"></i>Tambah Data', [
    'class' => 'btn btn-primary',
    'onclick' => "location.href=('" . site_url('kategori/formtambah') . "')"
]) ?>
<?= $this->endSection('subjudul') ?>

<?= $this->section('isi') ?>
<?= session()->getFlashdata('sukses'); ?>
<!-- searching -->
<?= form_open('kategori/index') ?>
<div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="Cari Data Kategori" aria-label="cari data kategori" aria-describedby="button-addon2" name="cari">
    <button class="btn btn-outline-primary" type="submit" id="tombolcari" name="tombolcari">
        <i class="fa fa-search"></i>
    </button>
</div>
<?= form_close(); ?>
<!-- membuat table -->
<table class="table table-striped table-bordered" style="width : 100%;">
    <thead>
        <tr>
            <th style="width: 5%; ">NO</th>
            <th>kategori</th>
            <th style="width: 15%; ">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $nomor = 1 + (($nohalaman - 1) * 5);
        foreach ($tampildata as $row) : ?>

            <tr>
                <td><?= $nomor++; ?></td>
                <td><?= $row['katnama']; ?></td>
                <td>
                    <!-- tombol edit -->
                    <button class="btn btn-info" type="button" title="Edit Data" onclick="edit('<?= $row['katid'] ?>')"><i class="fa fa-edit"></i></button>
                    <!-- javascript-->
                    <script>
                        // function edit
                        function edit(id) {
                            window.location = ('/kategori/formedit/' + id);
                        }

                        // function hapus
                        function hapus() {
                            //jendela konfirmasi
                            pesan = confirm('Yakin data Kategori akan dihapus?');

                            if (pesan) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    </script>

                    <!-- method spoofing -->
                    <form method="POST" action="/kategori/hapus/<?= $row['katid'] ?>" style="display: inline;" onsubmit="return hapus()">
                        <input type="hidden" value="DELETE" name="_method">
                        <!-- tombol hapus -->
                        <button class="btn btn-danger" type="submit" title="Hapus Data"><i class="fa fa-trash"></i></button>

                    </form>
                </td>
            </tr>
        <?php endforeach; ?>

    </tbody>
</table>
<!-- pagination -->
<div class="float-center">
    <?= $pager->links('kategori', 'paging'); ?>
</div>
<?= $this->endSection('isi') ?>
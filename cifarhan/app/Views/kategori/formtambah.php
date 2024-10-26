<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Tambah Data Kategori
<?= $this->endSection('judul') ?>

<?= $this->section('subjudul') ?>
<?= form_button('', '<i class ="fa fa-backward"></i>kembali', [
    'class' => 'btn btn-warning',
    'onclick' => "location.href=('" . site_url('kategori/index') . "')"
]) ?>
<?= $this->endSection('subjudul') ?>

<?= $this->section('isi') ?>
<!-- flashdata berhasil ditambahkan -->
<?= session()->getFlashdata('sukses'); ?>

<?= form_open('kategori/simpandata') ?>
<div class="form-group">
    <label for="namakategori">Nama Kategori</label>
    <?= form_input('namakategori', '', [
        'class' => 'form-control',
        'id' => 'namakategori',
        'autofocus' => 'true',
        'placeholder' => 'isikan nama kategori'
    ]) ?>
    <?= session()->getFlashdata('errorNamaKategori'); ?>
</div>
<div class="form-group">
    <?= form_submit('', 'simpan', [
        'class' => 'btn btn-success'
    ]) ?>

</div>
<?= form_close(); ?>
<?= $this->endSection('isi') ?>
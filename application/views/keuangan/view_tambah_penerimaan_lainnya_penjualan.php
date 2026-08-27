<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('keuangan/penjualan') ?>">
                        <button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button>
                    </a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('keuangan/penjualan/simpan_penerimaan_lainnya') ?>" method="POST" enctype="multipart/form-data">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Transaksi</label>
                                    <input type="text" class="form-control" value="<?= date('d-m-Y', strtotime(date('Y-m-d'))); ?>" readonly>
                                    <input type="hidden" name="tanggal" value="<?= date('Y-m-d'); ?>">
                                    <small class="text-muted">Hanya bisa input untuk hari ini</small>
                                </div>
                                <div class="mb-3">
                                    <label for="id_produk" class="form-label">Jenis Penerimaan</label>
                                    <select class="form-control" id="id_produk" name="id_produk" required>
                                        <option value="">-- Pilih --</option>
                                        <?php foreach ($produk_lainnya as $produk) : ?>
                                            <option value="<?= $produk->id_produk; ?>"><?= $produk->nama_produk; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="id_pelanggan" class="form-label">Nama Pembeli</label>
                                    <select class="form-control" id="id_pelanggan" name="id_pelanggan" required>
                                        <option value="">-- Pilih Pelanggan --</option>
                                        <?php foreach ($pelanggan as $plg) : ?>
                                            <option value="<?= $plg->id_pelanggan; ?>"><?= $plg->nama_pelanggan; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="nota_beli" class="form-label">Upload Kwitansi / Nota</label>
                                    <input type="file" class="form-control" id="nota_beli" name="nota_beli" accept="image/*,.pdf" required>
                                    <small class="text-muted">Format: JPG, JPEG, PNG, PDF (Maks 2MB)</small>
                                </div>
                                <div class="mb-3">
                                    <label for="total" class="form-label">Total (Rp)</label>
                                    <input type="number" class="form-control" id="total" name="total" min="0" required placeholder="Masukkan jumlah rupiah">
                                </div>
                                <div class="text-center mt-4">
                                    <button type="submit" class="neumorphic-button"><i class="fas fa-save"></i> Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

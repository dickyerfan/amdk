<button id="btn-up"><i class="fas fa-chevron-circle-up logo"></i></button>
<footer class="py-2 bg-light mt-auto logo">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Built With <span class="text-danger">&hearts;</span> by DIE Art'S Production <?= date('Y'); ?></div>
        </div>
    </div>
</footer>
</div>
</div>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="exampleModalLabel">Yakin Mau Logout.?</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">Pilih "Logout" jika anda yakin mau keluar</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Sweetalert2 -->
<script src="<?php echo base_url('assets/'); ?>sweetalert2.all.min.js"></script>

<script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url() ?>assets/js/scripts.js"></script>
<script src="<?= base_url() ?>assets/js/Chart.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url() ?>assets/demo/chart-area-demo.js"></script>
<script src="<?= base_url() ?>assets/demo/chart-bar-demo.js"></script>
<script src="<?= base_url() ?>assets/js/datatables-simple-demo.js"></script>

<!-- datatable bootstrap5 -->
<script src="<?= base_url(); ?>assets/datatables/bootstrap5/jquery-3.5.1.js"></script>
<script src="<?= base_url(); ?>assets/datatables/bootstrap5/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/datatables/bootstrap5/dataTables.bootstrap5.min.js"></script>
<!-- select2 js -->
<script src="<?= base_url() ?>assets/select2/select2.min.js"></script>
<script src="<?= base_url('assets/js/bootstrap-datepicker.js') ?>"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>

<script>
    $('.select2').select2({
        theme: 'bootstrap-5'
    });
</script>
<script>
    $(document).ready(function() {
        $('#tanggal').change(function(event) {
            event.preventDefault();
            var selectedDate = $(this).val(); // Mengambil nilai tanggal dari elemen #tanggal
            var currentDate = new Date().toISOString().slice(0, 10); // Mengambil tanggal saat ini
            if (selectedDate === currentDate) {
                window.location.href = $('#form_tanggal').attr('action');
            } else {
                $('#form_tanggal').submit();
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#bulan').change(function() {
            $('#form_bulan').submit();
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#id_produk').change(function() {
            $('#form_produk').submit();
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#id_pelanggan').change(function() {
            $('#form_pelanggan').submit();
        });
    });
</script>
<script>
    $("#btn-up").click(function() {
        $("html,body").animate({
            scrollTop: 0
        }, 500);
    });
</script>

<script>
    function showUploadWarning(uploadAllowed) {
        if (!uploadAllowed) {
            Swal.fire({
                title: 'Tidak bisa Upload data lagi',
                icon: 'warning',
                confirmButtonText: 'Tutup'
            });
            return false; // Mencegah tautan mengarahkan ke URL
        }
    }
</script>

<script>
    $('.tombolHapus').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        Swal.fire({
            title: 'Yakin mau Di Hapus?',
            text: 'Jika yakin tekan Hapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
            }
        })
    })
</script>

<script>
    tampil_data_barang(); //pemanggilan fungsi tampil barang pertama kali.

    //melakukan pembaruan data dengan AJAX setiap 5 detik
    // setInterval(function() {
    //     tampil_data_barang(); // Pemanggilan fungsi tampil_data_barang
    // }, 5000); // 5000 milidetik (5 detik)
    $('#example').dataTable();


    //fungsi tampil barang
    function tampil_data_barang() {
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>barang_baku/barang_keluar/get_permintaan_barang',
            dataType: 'json',
            success: function(data) {
                let textHtml = '';
                let no = 1;
                for (i = 0; i < data.length; i++) {
                    var jumlahKeluar = data[i].jumlah_keluar;
                    var jumlahKeluarDiformat = jumlahKeluar.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                    var tanggalKeluar = new Date(data[i].tanggal_keluar);
                    // Mendapatkan informasi tanggal, bulan, dan tahun
                    var tanggal = tanggalKeluar.getDate();
                    var bulan = tanggalKeluar.getMonth() + 1; // Perlu ditambah 1 karena indeks bulan dimulai dari 0
                    var tahun = tanggalKeluar.getFullYear();

                    // Membuat string dengan format "d-m-Y"
                    var tanggalDalamFormat = tanggal + '-' + bulan + '-' + tahun;

                    textHtml += '<tr>' +
                        '<td class="text-center">' + no++ + '</td>' +
                        '<td class="text-center">' + tanggalDalamFormat + '</td>' +
                        '<td>' + data[i].kode_barang + '</td>' +
                        '<td class="text-center">' + data[i].no_nota.toUpperCase() + '</td>' +
                        '<td>' + data[i].nama_barang_baku + '</td>' +
                        '<td class="text-end">' + jumlahKeluarDiformat + '</td>' +
                        '<td>' + data[i].input_status_keluar + '</td>' +
                        // '<td class="text-center">' + (data[i].status_keluar == 0 ? '<span class="btn btn-primary btn-sm">Menunggu</span>' : '<span class="btn btn-success btn-sm">Stok Produksi</span>') + '</td>';

                        '<td class="text-center">' +
                        (data[i].status_keluar == 0 ?
                            '<span class="btn btn-primary btn-sm">Menunggu</span>' :
                            (data[i].bagian === 'produksi' ? '<span class="btn btn-success btn-sm">Stok Produksi</span>' : '<span class="btn btn-warning btn-sm">Stok Brg Jadi</span>')
                        ) +
                        '</td>';

                    if (data[i].status_keluar == 0) {
                        textHtml += '<td class="text-center">' +
                            '<a href="#" style="color:blue; text-decoration:none;" onclick="editData(' + data[i].id_keluar_baku + ')"><span class="neumorphic-button btn-sm">Terima</span></a>' + ' ' +
                            '<a href="#" style="color:red; text-decoration:none;" onclick="tolakData(' + data[i].id_keluar_baku + ')"><span class="neumorphic-button btn-sm">Tolak</span></a>' +
                            '</td>';
                    } else {
                        textHtml += '<td class="text-center">';
                        var detailUrl = '<?= base_url('barang_baku/barang_keluar/detail_status_keluar/') ?>' + data[i].id_keluar_baku;
                        textHtml += '<a href="' + detailUrl + '" style="color:green; text-decoration:none;" ><span class="neumorphic-button btn-sm">Detail</span></a>';
                        textHtml += '</td>';
                    }
                    textHtml += '</tr>';

                }
                $('#example').DataTable().destroy();
                $('#show_data').html(textHtml);
                $('#example').DataTable({
                    "lengthMenu": [10, 25, 50, 75, 100],
                    "pageLength": 10
                });
            }
        });
    }

    function editData(id_keluar_baku) {

        $.ajax({
            type: 'POST',
            url: '<?= base_url('barang_baku/barang_keluar/update_status_keluar') ?>',
            data: {
                id_keluar_baku: id_keluar_baku
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    tampil_data_barang()
                    $("#pesan2").html(
                        `<div class="alert alert-success alert-dismissible fade show" role="alert" id="alert">
                    	        <strong>Sukses,</strong> Status Berhasil diupdate.
                    	        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    	        </div>`
                    );
                    setTimeout(function() {
                        $("#alert").animate({
                            left: "0",
                            width: "80%"
                        }, 3000, function() {}).fadeTo(1000, 0).slideUp(1000, function() {
                            $(this).remove();
                        });
                    }, 1000);

                } else {
                    $("#pesan2").html(
                        `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert">
                    	        <strong>Maaf,</strong> Status Gagal diupdate.
                    	        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    	        </div>`
                    );
                    setTimeout(function() {
                        $("#alert").animate({
                            left: "0",
                            width: "80%"
                        }, 3000, function() {}).fadeTo(1000, 0).slideUp(1000, function() {
                            $(this).remove();
                        });
                    }, 1000);
                }
            },
            error: function(xhr, status, error) {}
        });
    }

    function tolakData(id_keluar_baku) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Anda yakin akan menolak Permintaan.?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, tolak permintaan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kode untuk menghapus data
                $.ajax({
                    type: 'POST',
                    data: 'id_keluar_baku=' + id_keluar_baku,
                    url: '<?= base_url('barang_produksi/Permintaan_barang_baku/tolak_pesanan') ?>',
                    dataType: 'json',
                    success: function(hasil) {
                        $("#pesan").html(hasil.pesan);
                        if (hasil.pesan == 'Data ditolak') {
                            $('#mydata').dataTable().fnDestroy();
                            tampil_data_barang();
                            $('#mydata').dataTable({
                                "lengthMenu": [10, 25, 50, 75, 100],
                                "pageLength": 10
                            });
                            $("#pesan2").html(
                                `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert">
                    	        <strong>Maaf</strong> Permintaan Barang ditolak.
                    	        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    	        </div>`
                            );

                            setTimeout(function() {
                                $("#alert").animate({
                                    left: "0",
                                    width: "80%"
                                }, 5000, function() {}).fadeTo(1000, 0).slideUp(1000, function() {
                                    $(this).remove();
                                });
                            }, 1000);

                        } else {
                            $("#pesan2").html(
                                `<div class="alert alert-success alert-dismissible fade show" role="alert" id="alert">
                    	        <strong>Sukses</strong> Permintaan Barang diterima.
                    	        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    	        </div>`
                            );
                            setTimeout(function() {
                                $("#alert").animate({
                                    left: "0",
                                    width: "80%"
                                }, 5000, function() {}).fadeTo(1000, 0).slideUp(1000, function() {
                                    $(this).remove();
                                });
                            }, 1000);
                        }
                    }
                });
            }
        });
    }

    function detailData(id_keluar_baku) {

        $.ajax({
            type: 'POST',
            url: '<?= base_url('barang_baku/barang_keluar/detail_status_keluar') ?>',
            data: {
                id_keluar_baku: id_keluar_baku
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $("#pesan2").html(
                        `<div class="alert alert-success alert-dismissible fade show" role="alert" id="alert">
                        <strong>Sukses,</strong> Status Berhasil diupdate.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`
                    );
                    setTimeout(function() {
                        $("#alert").animate({
                            left: "0",
                            width: "80%"
                        }, 3000, function() {}).fadeTo(1000, 0).slideUp(1000, function() {
                            $(this).remove();
                        });
                    }, 1000);

                } else {
                    $("#pesan2").html(
                        `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert">
                        <strong>Maaf,</strong> Status Gagal diupdate.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`
                    );
                    setTimeout(function() {
                        $("#alert").animate({
                            left: "0",
                            width: "80%"
                        }, 3000, function() {}).fadeTo(1000, 0).slideUp(1000, function() {
                            $(this).remove();
                        });
                    }, 1000);
                }
            },
            error: function(xhr, status, error) {}
        });
    }

    function checkStatus() {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('barang_baku/barang_keluar/cek_status_permintaan_barang') ?>',
            dataType: 'json',
            success: function(response) {
                if (response.success === true) {
                    // Ada data dengan status 0, ubah warna ikon dan tampilkan pesan
                    $('#bellIcon').css('color', 'red');
                    $('#permintaanBarang').show();
                } else {
                    // Tidak ada data dengan status 0, kembalikan warna ikon ke semula dan sembunyikan pesan
                    $('#bellIcon').css('color', '');
                    $('#permintaanBarang').hide();
                }
            }
        });
    }

    // Memanggil fungsi checkStatus setiap 5 detik

    setInterval(function() {
        checkStatus(); // Pemanggilan fungsi tampil_data_barang
    }, 5000); // 5000 milidetik (5 detik)
</script>

<script>
    window.setTimeout(function() {
        $(".alert").animate({
            left: "0",
            width: "80%"
        }, 5000, function() {}).fadeTo(1000, 0).slideUp(1000, function() {
            $(this).remove();
        });
    }, 1000);
</script>

</body>

</html>
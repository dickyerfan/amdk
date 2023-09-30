<button id="btn-up"><i class="fas fa-chevron-circle-up logo"></i></button>
<footer class="py-2 bg-light mt-auto logo">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Built With <span class="text-danger">&hearts;</span> by DIE Art'S Production 2022</div>
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
    tampil_data_barang(); //pemanggilan fungsi tampil barang.
    setInterval(function() {
        tampil_data_barang(); // Pemanggilan fungsi tampil_data_barang
    }, 5000); // 5000 milidetik (5 detik)
    $('#example').dataTable();


    //fungsi tampil barang
    function tampil_data_barang() {
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>barang_produksi/permintaan_barang_baku/getDataBarang',
            dataType: 'json',
            success: function(data) {
                let textHtml = '';
                let no = 1;
                for (i = 0; i < data.length; i++) {
                    textHtml += '<tr>' +
                        '<td class="text-center">' + no++ + '</td>' +
                        '<td>' + data[i].tanggal_keluar + '</td>' +
                        '<td>' + data[i].kode_barang + '</td>' +
                        '<td>' + data[i].nama_barang_baku + '</td>' +
                        '<td>' + data[i].jumlah_keluar + '</td>' +
                        '<td>' + data[i].input_status_keluar + '</td>';
                    // '<td>' + data[i].status_keluar + '</td>' +
                    if (data[i].status_keluar == 0) {
                        textHtml += '<td class="text-center">' +
                            '<a href="#" data-bs-toggle="modal" data-bs-target="#ubahData" style="color:green; text-decoration:none;" onclick="editData(' + data[i].id_keluar_baku + ')"><span class="btn btn-success btn-sm">Edit</span></a>' + ' ' +
                            '<a href="#" style="color:red; text-decoration:none;" onclick="hapusData(' + data[i].id_keluar_baku + ')"><span class="btn btn-danger btn-sm">Hapus</span></a>' +
                            '</td > ';
                    } else {
                        textHtml += '<td class="text-center">' +
                            '<span class="btn btn-success btn-sm">Stok Barang Baku</span>' +
                            '</td>';
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

    function tambahData() {

        var input = "<?= $this->session->userdata('nama_lengkap'); ?>";

        let id_barang_baku = $("[name='id_barang_baku']").val();
        // let kode_barang = kode_barang_baku;
        let jumlah_keluar = $("[name='jumlah_keluar']").val();
        let tanggal_keluar = $("[name='tanggal_keluar']").val();
        let input_status_keluar = input;

        $.ajax({
            type: 'POST',
            data: 'id_barang_baku=' + id_barang_baku + '&jumlah_keluar=' + jumlah_keluar + '&tanggal_keluar=' + tanggal_keluar + '&input_status_keluar=' + input,
            url: '<?= base_url('barang_produksi/Permintaan_barang_baku/upload') ?>',
            dataType: 'json',
            success: function(hasil) {
                $("#pesan").html(hasil.pesan);
                if (hasil.pesan == '') {
                    $("#tambahData").modal('hide');
                    $('#example').dataTable().fnDestroy(); // menghancurkan datatable
                    tampil_data_barang()
                    $('#example').dataTable({ // inisialisasi datatable kembali
                        "lengthMenu": [10, 25, 50, 75, 100], // menentukan jumlah data yang ingin ditampilkan
                        "pageLength": 10, // menentukan jumlah data yang ditampilkan secara default
                    });

                    $("#pesan2").html(
                        `<div class="alert alert-primary alert-dismissible fade show" role="alert" id="alert">
                    	        <strong>Sukses</strong> Data Berhasil ditambah.
                    	        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    	        </div>`
                    );

                    window.setTimeout(function() {
                        $(".alert").animate({
                            left: "0",
                            width: "80%"
                        }, 5000, function() {}).fadeTo(1000, 0).slideUp(1000, function() {
                            $(this).remove();
                        });
                    }, 1000);

                    // Swal.fire({
                    //     icon: 'success',
                    //     title: 'Sukses',
                    //     text: 'Data berhasil diupload.'
                    // });
                    $("[name='id_barang_baku']").val('');
                    // $("[name='kode_barang']").val('');
                    $("[name='jumlah_keluar']").val('');
                    $("[name='tanggal_keluar']").val('');
                }
            }
        });
    }

    function batalData() {
        $.ajax({
            success: function(hasil) {
                $("#pesan").html("");
                $("[name='id_barang_baku']").val('');
                // $("[name='kode_barang']").val('');
                $("[name='jumlah_keluar']").val('');
                $("[name='tanggal_keluar']").val('');
            }
        })
    }

    function editData(id_keluar_baku) {
        $.ajax({
            type: "POST",
            data: 'id_keluar_baku=' + id_keluar_baku,
            url: '<?= base_url('barang_produksi/Permintaan_barang_baku/ambil_id_barang') ?>',
            dataType: 'JSON',
            success: function(hasil) {
                console.log(hasil);
                $('[name="id_keluar_baku"]').val(hasil[0].id_keluar_baku);
                $('[name="id_barang_bakuUp"]').val(hasil[0].id_barang_baku);
                $('[name="kode_barangUp"]').val(hasil[0].kode_barang);
                $('[name="jumlah_keluarUp"]').val(hasil[0].jumlah_keluar);
                $('[name="tanggal_keluarUp"]').val(hasil[0].tanggal_keluar);

            }
        })
    }


    function ubahData() {
        var input = "<?= $this->session->userdata('nama_lengkap'); ?>";

        let id_keluar_baku = $("[name='id_keluar_baku']").val();
        let id_barang_baku = $("[name='id_barang_bakuUp']").val();
        let kode_barang = $("[name='kode_barangUp']").val();
        let jumlah_keluar = $("[name='jumlah_keluarUp']").val();
        let tanggal_keluar = $("[name='tanggal_keluarUp']").val();
        let created_by = input;

        $.ajax({
            type: 'POST',
            data: 'id_keluar_baku=' + id_keluar_baku + '&id_barang_baku=' + id_barang_baku + '&kode_barang=' + kode_barang + '&jumlah_keluar=' + jumlah_keluar + '&tanggal_keluar=' + tanggal_keluar + '&created_by=' + input,
            url: '<?= base_url('barang_produksi/Permintaan_barang_baku/update') ?>',
            dataType: 'JSON',
            success: function(hasil) {
                if (hasil.pesan == '') {
                    $("#pesan").html(hasil.pesan);
                    $("#ubahData").modal('hide');
                    $('#mydata').dataTable().fnDestroy(); // menghancurkan datatable
                    tampil_data_barang()
                    $('#mydata').dataTable({ // inisialisasi datatable kembali
                        "lengthMenu": [10, 25, 50, 75, 100], // menentukan jumlah data yang ingin ditampilkan
                        "pageLength": 10, // menentukan jumlah data yang ditampilkan secara default
                    });
                    $("#pesan2").html(
                        `<div class="alert alert-success alert-dismissible fade show" role="alert" id="alert">
                    	        <strong>Sukses,</strong> Data Berhasil diupdate.
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

                    $('[name="id_keluar_baku"]').val('');
                    $('[name="id_barang_bakuUp"]').val('');
                    $('[name="kode_barangUp"]').val('');
                    $('[name="jumlah_keluarUp"]').val('');
                    $('[name="tanggal_keluarUp"]').val('');

                } else if (hasil.pesan == 'Tidak ada update') {
                    $("#ubahData").modal('hide');
                    $('#mydata').dataTable().fnDestroy(); // menghancurkan datatable
                    tampil_data_barang()
                    $('#mydata').dataTable({ // inisialisasi datatable kembali
                        "lengthMenu": [10, 25, 50, 75, 100], // menentukan jumlah data yang ingin ditampilkan
                        "pageLength": 10, // menentukan jumlah data yang ditampilkan secara default
                    });
                    $("#pesan2").html(
                        `<div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert">
                    	        <strong>Gagal,</strong> Tidak ada Perubahan data.
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

                    $('[name="id_keluar_baku"]').val('');
                    $('[name="id_barang_bakuUp"]').val('');
                    $('[name="kode_barangUp"]').val('');
                    $('[name="jumlah_keluarUp"]').val('');
                    $('[name="tanggal_keluarUp"]').val('');
                }
            }
        })
    }

    function hapusData(id_keluar_baku) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah anda yakin akan menghapus data.?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus data!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kode untuk menghapus data
                $.ajax({
                    type: 'POST',
                    data: 'id_keluar_baku=' + id_keluar_baku,
                    url: '<?= base_url('barang_produksi/Permintaan_barang_baku/hapus') ?>',
                    dataType: 'json',
                    success: function(hasil) {
                        $("#pesan").html(hasil.pesan);
                        if (hasil.pesan == 'Data berhasil dihapus.') {
                            $('#mydata').dataTable().fnDestroy();
                            tampil_data_barang();
                            $('#mydata').dataTable({
                                "lengthMenu": [10, 25, 50, 75, 100],
                                "pageLength": 10
                            });
                            $("#pesan2").html(
                                `<div class="alert alert-success alert-dismissible fade show" role="alert" id="alert">
                    	        <strong>Sukses</strong> Data Berhasil dihapus.
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
                    	        <strong>Maaf</strong> Data Gagal dihapus.
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
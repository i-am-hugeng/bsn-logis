@extends('layouts.main', ['title' => 'Identifikasi SNI'])

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Identifikasi SNI</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
@endsection

@section('content')
    <input type="hidden" id="level" value="{{ Auth::user()->level }}">
    <input type="hidden" id="id_admin" value="{{ Auth::user()->id }}">
    <div id="konten"></div>

    <!-- {{-- Modal Identifikasi Komtek dan Penerap SNI --}} -->
    <div class="modal fade" id="modal-identifikasi-edit">
        <form id="form-identifikasi-edit" enctype="multipart/form-data">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Identifikasi / Edit Komtek dan Penerap SNI</h4>
                    <button type="button" class="close tutup-modal-identifikasi" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- {{-- Start : id counter untuk menambah field penerap SNI --}} -->
                    <input type="hidden" id="counter-penerap" value="0">
                    <!-- {{-- End : id counter --}} -->

                    <div class="form-group">
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="status_proses_pic" id="status_proses_pic">
                    </div>

                    <table class="mb-3">
                        <tr class="form-group">
                            <th class="col-sm-3">PIC</th>
                            <td>:</td>
                            <td class="col-sm-9 reset-value" id="pic"></td>
                        </tr>
                        <tr class="form-group">
                            <th class="col-sm-3">Nomor SK</th>
                            <td>:</td>
                            <td class="col-sm-9 reset-value" id="nmr_sk_sni"></td>
                        </tr>
                        <tr class="form-group">
                            <th class="col-sm-3">Tanggal SK</th>
                            <td>:</td>
                            <td class="col-sm-9 reset-value"  id="tanggal_sk"></td>
                        </tr>
                        <tr class="form-group">
                            <th class="col-sm-3 align-text-top">Uraian SK</th>
                            <td class="align-text-top">:</td>
                            <td class="col-sm-9 reset-value" id="uraian_sk"></td>
                        </tr>
                        <tr class="form-group">
                            <th class="col-sm-3">Nomor SNI Baru</th>
                            <td>:</td>
                            <td class="col-sm-9 reset-value" id="nmr_sni_baru"></td>
                        </tr>
                        <tr class="form-group">
                            <th class="col-sm-3 align-text-top">Judul SNI Baru</th>
                            <td class="align-text-top">:</td>
                            <td class="col-sm-9 reset-value" id="jdl_sni_baru"></td>
                        </tr>
                        <tr class="form-group">
                            <th class="col-sm-3">Tahun SNI Baru</th>
                            <td>:</td>
                            <td class="col-sm-9 reset-value" id="tahun_sni_baru"></td>
                        </tr>
                    </table>
                    <table class="mb-3 table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nomor SNI Lama</th>
                                <th class="text-center">Judul SNI Lama</th>
                            </tr>
                        </thead>
                        <tbody id="tabel-sni-lama">

                        </tbody>
                    </table>
                    <div class="form-group">
                        <label class="form-label">Sifat SNI</label>
                        <select id="sifat_sni" class="form-control" name="sifat_sni">
                            <option value="0" selected>Wajib</option>
                            <option value="1">Sukarela</option>
                        </select>
                    </div>
                    <div id="komtek-penerap">

                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger tutup-modal-identifikasi" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="tambah-data-identifikasi">Simpan</button>
                </div>
                </div>
                <!-- /.modal-content -->
            </div>
        </form>
        <!-- /.modal-dialog -->
    </div>
    <!-- {{-- End of - Modal Identifikasi Komtek dan Penerap SNI --}} -->

    {{-- Modal Konfirmasi Ubah sifat SNI yang berimplikasi pada terhapusnya data identifikasi komtek dan penerap SNI --}}
    <div class="modal fade" id="modal-konfirmasi-ubah-sifat-sni">
        <form id="form-konfirmasi-ubah-sifat-sni">
            <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Ubah Sifat SNI</h4>
                    <button type="button" class="close tutup-modal-konfirmasi-ubah-sifat-sni" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" id="body-konfirmasi-ubah-sifat-sni">
                      
                      
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default tutup-modal-konfirmasi-ubah-sifat-sni" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger tombol-ubah-sifat-sni">Ubah</button>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
        </form>
        <!-- /.modal-dialog -->
    </div>
    {{-- End of - Modal Konfirmasi Ubah sifat SNI yang berimplikasi pada terhapusnya data identifikasi komtek dan penerap SNI --}}
@endsection

@push('css')
    
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            //define Toast
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                iconColor: 'white',
                customClass: {
                    popup: 'colored-toast'
                },
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });

            if($('#level').val() == 0) {
                $.ajax({
                    type: "get",
                    url: "/identifikasi-sni/konten-super-admin",
                    dataType: "JSON",
                    success: function (response) {
                        $.each(response.data_pic, function(key, item) {
                            $('#konten').append(
                                '<div class="card">\
                                    <div class="card-header">\
                                        <h3 class="card-title">Identifikasi Data Komite Teknis dan Penerap SNI | <strong>'+ item.name +'</strong></h3>\
                                    </div>\
                                    <div class="card-body">\
                                        <table class="table table-bordered table-hover" id="identifikasi-'+item.id+'-dt">\
                                            <thead class="bg-dark text-white">\
                                                <tr>\
                                                    <th>No</th>\
                                                    <th>Nomor SK</th>\
                                                    <th>Tanggal SK</th>\
                                                    <th>Waktu Disposisi</th>\
                                                    <th>Waktu Proses</th>\
                                                    <th>Status</th>\
                                                </tr>\
                                            </thead>\
                                        </table>\
                                    </div>\
                                    <!-- /.card-body -->\
                                </div>'
                            );
                            $('#identifikasi-'+item.id+'-dt').DataTable({
                                language: {
                                    url: "/json/id.json"
                                },
                                serverside: true,
                                ajax: {
                                    url: "/identifikasi-sni/konten-super-admin/dt-"+item.id+"",
                                    type: "GET",
                                },
                                columns: [
                                    {
                                        data : 'DT_RowIndex',
                                        name : 'DT_RowIndex',
                                        orderable : false,
                                        searchable : false,
                                    },
                                    {
                                        data : 'nmr_sk_sni',
                                        name : 'nmr_sk_sni',
                                        // render : function(data, type, row, meta) {
                                        //     return '<a href="javascript:void(0)" data-id="'+ row.id +'" class="lihat-detail-kegiatan">'+ row.judul +'</a>';
                                        // }
                                    },
                                    {
                                        data : 'tanggal_sk',
                                        name : 'tanggal_sk',
                                        // render: function ( data, type, row ) {
                                        //     return data.substr( 0, 50 )+'...';
                                        // }

                                    },
                                    {
                                        data : 'waktu_disposisi',
                                        name : 'waktu_disposisi',
                                    },
                                    {
                                        data : 'waktu_proses',
                                        name : 'waktu_proses',
                                    },
                                    {
                                        data : 'status_proses_pic',
                                        name : 'status_proses_pic',
                                        render : 
                                            function(data, type, row) {
                                                if(row.status_proses_pic == 0) {
                                                    return row.status_proses_pic = '<span class="badge badge-warning">Menunggu</span>';
                                                }
                                                else {
                                                    return row.status_proses_pic = '<span class="badge badge-success">Terproses</span>';
                                                }
                                            }
                                    },
                                ],
                                order : [[3, 'desc']],
                            });
                        });
                    }
                });
            }
            else {
                var id_admin = $('#id_admin').val();

                $.ajax({
                    type: "get",
                    url: "/identifikasi-sni/konten-admin",
                    dataType: "JSON",
                    success: function (response) {
                        $('#konten').append(
                            '<div class="card">\
                                <div class="card-header">\
                                    <h3 class="card-title">Identifikasi Data Komite Teknis dan Penerap SNI</h3>\
                                </div>\
                                <div class="card-body">\
                                    <table class="table table-bordered table-hover" id="identifikasi-dt">\
                                        <thead class="bg-dark text-white">\
                                            <tr>\
                                                <th>No</th>\
                                                <th>Nomor SK</th>\
                                                <th>Tanggal SK</th>\
                                                <th>Waktu Disposisi</th>\
                                                <th>Waktu Proses</th>\
                                                <th>Status</th>\
                                                <th>Aksi</th>\
                                            </tr>\
                                        </thead>\
                                    </table>\
                                </div>\
                                <!-- /.card-body -->\
                            </div>'
                        );

                        identifikasi_dt();

                        function identifikasi_dt() {
                            $('#identifikasi-dt').DataTable({
                                language: {
                                    url: "/json/id.json"
                                },
                                serverside: true,
                                ajax: {
                                    url: "/identifikasi-sni/"+id_admin,
                                    type: "GET",
                                },
                                columns: [
                                    {
                                        data : 'DT_RowIndex',
                                        name : 'DT_RowIndex',
                                        orderable : false,
                                        searchable : false,
                                    },
                                    {
                                        data : 'nmr_sk_sni',
                                        name : 'nmr_sk_sni',
                                        // render : function(data, type, row, meta) {
                                        //     return '<a href="javascript:void(0)" data-id="'+ row.id +'" class="lihat-detail-kegiatan">'+ row.judul +'</a>';
                                        // }
                                    },
                                    {
                                        data : 'tanggal_sk',
                                        name : 'tanggal_sk',
                                        // render: function ( data, type, row ) {
                                        //     return data.substr( 0, 50 )+'...';
                                        // }

                                    },
                                    {
                                        data : 'created_at',
                                        name : 'created_at',
                                    },
                                    {
                                        data : 'updated_at',
                                        name : 'updated_at',
                                    },
                                    {
                                        data : 'status_proses_pic',
                                        name : 'status_proses_pic',
                                        render : 
                                            function(data, type, row) {
                                                if(row.status_proses_pic == 0) {
                                                    return row.status_proses_pic = '<span class="badge badge-warning">Menunggu</span>';
                                                }
                                                else {
                                                    return row.status_proses_pic = '<span class="badge badge-success">Terproses</span>';
                                                }
                                            }
                                    },
                                    {
                                        data : 'aksi',
                                        name : 'aksi',
                                        orderable : false,
                                        searchable : false,
                                    },
                                ],
                                // columnDefs: [
                                //     { 
                                //         targets: 2,
                                //         width: "25%",
                                //     },
                                // ],
                                order : [[3, 'desc']],
                            });
                        }
                    }
                });

                $('body').off('click').on('click','.identifikasi', function() {
                    if($(this).hasClass('disabled')) {
                        Toast.fire({
                            icon : "warning",
                            title: "Data tidak dapat diubah, sudah terdaftar dalam bahan rapat.",
                        });
                    }
                    else {
                        function sukarela() {
                            if($('#komtek-penerap').length != 0) {
                                $('#komtek-penerap').html('');
                                $('#komtek-penerap').append(
                                    '<div class="form-group">\
                                        <input type="hidden" name="id_identifikasi" id="id_identifikasi">\
                                        <label for="komtek">Komite Teknis</label>\
                                        <input type="text" class="form-control reset-value" id="komtek" name="komtek" placeholder="Masukkan data komtek...">\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="sekretariat_komtek">Sekretariat Komite Teknis</label>\
                                        <textarea rows="5" id="sekretariat_komtek" name="sekretariat_komtek" class="form-control reset-value" placeholder="Masukkan data Sekretariat komtek..."></textarea>\
                                    </div>\
                                    <div class="form-group row">\
                                        <div class="col-md-6">\
                                            <button type="button" id="tombol-tambah-penerap" class="form-control btn btn-secondary">Tambah Data Penerap</button>\
                                        </div>\
                                    </div>\
                                    <div id="div_tambah_penerap">\
                                    </div>'
                                );
                            }
                        }

                        function tambah_penerap() {
                            var counter_penerap = parseInt($('#counter-penerap').val());
                            var html = '<div id="record-penerap['+ counter_penerap +']" class="record-penerap row">\
                                            <div class="col-sm-9">\
                                                <div class="form-group">\
                                                    <input type="hidden" class="id_penerap" name="id_penerap['+ counter_penerap +']" value="">\
                                                    <input type="text" class="form-control penerap" placeholder="Masukkan data penerap SNI..." name="penerap['+ counter_penerap +']">\
                                                </div>\
                                            </div>\
                                            <div class="col-md-3">\
                                                <button type="button" class="btn btn-dark form-control hapus-penerap">Hapus</button>\
                                            </div>\
                                        </div>';

                            $('#div_tambah_penerap').append(html);
                            $('#counter-penerap').val( counter_penerap + 1 );
                        }

                        var data_id = $(this).attr('id');

                        $('#modal-identifikasi-edit').modal('show');

                        //menampilkan input data komtek dan penerap bila pilihan sifat SNI adalah 'Sukarela'
                        $('#sifat_sni').off('change').on('change', function() {
                            if($('#sifat_sni').val() == 1) {
                                sukarela();

                                //{{-- Tambah baris penerap SNI --}}
                                $('#tombol-tambah-penerap').off('click').on('click',function() {
                                    tambah_penerap();
                                });
                            }
                            else {
                                //mengubah sifat SNI yang berimplikasi pada terhapusnya data identifikasi komtek dan penerap SNI
                                var id_konfirmasi_ubah_sifat_sni = $('#id_identifikasi').val();

                                if(id_konfirmasi_ubah_sifat_sni != '') {
                                    $.ajax({
                                        type: "GET",
                                        url: "/identifikasi-sni/konten-admin/konfirmasi-ubah-sifat-sni/"+id_konfirmasi_ubah_sifat_sni,
                                        success: function(response) {
                                            console.log(response.data);
                                            $('#body-konfirmasi-ubah-sifat-sni').append(
                                                '<input type="hidden" id="id_ubah-sifat-sni">\
                                                <h6>Apakah anda yakin untuk mengubah sifat SNI?</h6>\
                                                <p>Apabila sifat SNI diubah, maka data hasil identifikasi komtek dan penerap SNI akan terhapus.</p>'
                                            );

                                            $('#id_ubah-sifat-sni').val(response.data.id);

                                            $('#modal-konfirmasi-ubah-sifat-sni').modal('show');

                                            $('.tombol-ubah-sifat-sni').on('click', function(e) {

                                                $.ajaxSetup({
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    }
                                                });

                                                e.preventDefault();

                                                var id_ubah_sifat_sni = $('#id_ubah-sifat-sni').val();

                                                $(this).html('<i class="spinner-border spinner-border-sm text-light" role="status"></i> Mengubah...');
                                                $(this).attr('disabled', true);

                                                $.ajax({
                                                    type: "DELETE",
                                                    url: "/identifikasi-sni/konten-admin/ubah-sifat-sni/"+id_ubah_sifat_sni,
                                                    success: function(response) {
                                                        Toast.fire({
                                                            icon : "success",
                                                            title: "Sifat SNI telah berubah menjadi wajib.",
                                                        });
                                                        $('#modal-konfirmasi-ubah-sifat-sni').modal('hide');
                                                        $('#body-konfirmasi-ubah-sifat-sni').html('');
                                                        $('#komtek-penerap').html('');
                                                    }
                                                });
                                            });
                                        }
                                    });
                                }
                                else {
                                    $('#komtek-penerap').html('');
                                }
                            }
                        });

                        $.ajax({
                            type: "GET",
                            url: "/identifikasi-sni/konten-admin/modal-identifikasi-edit/"+data_id,
                            success: function(response) {
                                $('#id').val(response.data_sk.id);
                                $('#status_proses_pic').val(response.data_sk.status_proses_pic);
                                $('#pic').html(response.data_sk.pic);
                                $('#nmr_sk_sni').html(response.data_sk.nmr_sk_sni);
                                $('#tanggal_sk').html(response.data_sk.tanggal_sk);
                                $('#uraian_sk').html(response.data_sk.uraian_sk);
                                $('#nmr_sni_baru').html(response.data_sk.nmr_sni_baru);
                                $('#jdl_sni_baru').html(response.data_sk.jdl_sni_baru);
                                $('#tahun_sni_baru').html(response.data_sk.tahun_sni_baru);

                                $.each(response.data_sni_lama, function(key, item) {
                                    $('#tabel-sni-lama').append(
                                        '<tr>\
                                            <td class="text-center align-text-top">'+(key+1)+'</td>\
                                            <td class="align-text-top">'+item.nmr_sni_lama+'</td>\
                                            <td>'+item.jdl_sni_lama+'</td>\
                                        </tr>'
                                    );
                                })

                                if(response.data_identifikasi_komtek != null) {
                                    $('#sifat_sni').val(response.data_sk.sifat_sni);
                                    sukarela();
                                    $('#id_identifikasi').val(response.data_identifikasi_komtek.id);
                                    $('#komtek').val(response.data_identifikasi_komtek.komtek);
                                    $('#sekretariat_komtek').val(response.data_identifikasi_komtek.sekretariat_komtek);
                                    var str = $("#sekretariat_komtek").val();
                                    var regex = /<br\s*[\/]?>/gi;
                                    $("#sekretariat_komtek").val(str.replace(regex, ""));

                                    $.each(response.data_identifikasi_penerap, function(key, item) {
                                        $('#div_tambah_penerap').append(
                                            '<div id="record-penerap['+ key +']" class="record-penerap row">\
                                                <div class="col-sm-9">\
                                                    <div class="form-group">\
                                                        <input type="hidden" name="id_penerap['+ key +']" class="id_penerap" value="'+ item.id +'">\
                                                        <input type="text" class="form-control penerap" value="'+ item.penerap +'" name="penerap['+ key +']">\
                                                    </div>\
                                                </div>\
                                                <div class="col-md-3">\
                                                    <button type="button" class="btn btn-dark form-control hapus-penerap">Hapus</button>\
                                                </div>\
                                            </div>'
                                        )
                                        $('#counter-penerap').val(key + 1);

                                        //{{-- Tambah baris penerap SNI --}}
                                        $('#tombol-tambah-penerap').off('click').on('click',function() {
                                            tambah_penerap();
                                        });
                                    })
                                }
                            }
                        })
                    }

                    //{{-- hapus baris penerap yang berisi data --}}
                    $(document).off('click').on('click','.hapus-penerap', function() {
                        // alert($(this).closest('.record-penerap').find('.id_penerap').val());
                        id_penerap = $(this).closest('.record-penerap').find('.id_penerap').val();
                        if($('.record-penerap').length <= 1) {
                            Toast.fire({
                                icon : "warning",
                                title: "Minimal terdapat satu data penerap SNI.",
                            });
                        }
                        else {
                            if(id_penerap != '') {
                                $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                });

                                $(this).html('<i class="spinner-border spinner-border-sm text-light" role="status"></i> Menghapus...');
                                $(this).attr('disabled', true);

                                $.ajax({
                                    type        : "DELETE",
                                    dataType    : "JSON",
                                    url         : "/identifikasi-sni/hapus-penerap/"+id_penerap,
                                    success: function(response) {
                                        Toast.fire({
                                            icon : "success",
                                            title: "Data penerap SNI telah terhapus.",
                                        });                     
                                    },
                                    error: function(response) {
                                        Toast.fire({
                                            icon : "error",
                                            title: "Gagal hapus data.",
                                        });
                                    },
                                    complete: function(response) {
                                        $('#div_tambah_penerap').html('');
                                        //memuat ulang data tabel SNI lama dan data penerap SNI 
                                        $.ajax({
                                            type: "GET",
                                            url: "/identifikasi-sni/konten-admin/modal-identifikasi-edit/"+data_id,
                                            success: function(response) {
                                                if(response.data_identifikasi_komtek != null) {
                                                    $.each(response.data_identifikasi_penerap, function(key, item) {
                                                        $('#div_tambah_penerap').append(
                                                            '<div id="record-penerap['+ key +']" class="record-penerap row">\
                                                                <div class="col-sm-9">\
                                                                    <div class="form-group">\
                                                                        <input type="hidden" name="id_penerap['+ key +']" class="id_penerap" value="'+ item.id +'">\
                                                                        <input type="text" class="form-control penerap" value="'+ item.penerap +'" name="penerap['+ key +']">\
                                                                    </div>\
                                                                </div>\
                                                                <div class="col-md-3">\
                                                                    <button type="button" class="btn btn-dark form-control hapus-penerap">Hapus</button>\
                                                                </div>\
                                                            </div>'
                                                        )
                                                        $('#counter-penerap').val(key + 1);
                                                    })
                                                }
                                            }
                                        })
                                    }
                                }); 
                            }
                            else {
                                $(this).closest('.record-penerap').remove();
                            }
                        }
                    });

                    $('.tutup-modal-identifikasi').click(function() {
                        $('#div_tambah_penerap').html('');
                        $('#tabel-sni-lama tr').html('');
                        $('#sifat_sni').prop('selectedIndex',0);
                        $('#komtek-penerap').html('');
                        $('.reset-value').html('');
                        $('#form-identifikasi-edit').find('input').val('');
                        $('#counter-penerap').val(0);
                    });
                })

                /******** Tambah Data identifikasi SNI *********/
                $('#tambah-data-identifikasi').off('click').on('click', function(e) {

                    if($('#sifat_sni').val() == 1) {
                        if($('.record-penerap').length == 0) {
                            e.preventDefault();
                            Toast.fire({
                                icon : "warning",
                                title: "Tambah minimal satu data penerap SNI.",
                            });
                        }
                        else {
                            /******** Validasi penambahan data penerap SNI *********/
                            $('#form-identifikasi-edit').on('click', '#tambah-data-identifikasi', function(e){
                                $('.penerap').each(function() {
                                    $(this).rules('add',
                                        {
                                            required: true,
                                            messages: {
                                                required: "Masukkan penerap SNI.",
                                            }
                                        }
                                    )
                                })
                            }).validate({
                                rules: {
                                    komtek: {
                                        required: true,
                                    },
                                    sekretariat_komtek: {
                                        required: true,
                                    },
                                },
                                messages: {
                                    komtek: {
                                        required: "Masukkan nama Komite Teknis.",
                                    },
                                    sekretariat_komtek: {
                                        required: "Masukkan alamat email Komite Teknis.",
                                    },
                                },
                                errorElement: 'span',
                                errorPlacement: function (error, element) {
                                    error.addClass('invalid-feedback');
                                    element.closest('.form-group').append(error);
                                },
                                highlight: function (element, errorClass, validClass) {
                                    $(element).addClass('is-invalid');
                                },
                                unhighlight: function (element, errorClass, validClass) {
                                    $(element).removeClass('is-invalid');
                                },
                                submitHandler: function(form) {

                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    $('#tambah-data-identifikasi').html('<i class="spinner-border spinner-border-sm text-light" role="status"></i> Menyimpan...');
                                    $('#tambah-data-identifikasi').attr('disabled', true);

                                    $.ajax({
                                        type        : "POST",
                                        dataType    : "JSON",
                                        url         : "/identifikasi-sni/identifikasi-edit",
                                        contentType : false,
                                        processData : false,
                                        cache       : false,
                                        data        : new FormData($(form)[0]),
                                        success: function(response) {
                                            Toast.fire({
                                                icon : "success",
                                                title: "Data identifikasi SNI telah tersimpan.",
                                            });                     
                                        },
                                        error: function(response) {
                                            Toast.fire({
                                                icon : "error",
                                                title: "Gagal upload data.",
                                            });
                                        },
                                        complete: function(response) {
                                            $('#modal-identifikasi-edit').modal('hide');
                                            $('#form-identifikasi-edit').find('input').val('');
                                            $('#form-identifikasi-edit').find('textarea').val('');
                                            $('#sifat_sni').prop('selectedIndex',0);
                                            $('.record-penerap').html('');
                                            $('#tambah-data-identifikasi').html('');
                                            $('#tambah-data-identifikasi').text('Simpan');
                                            $('#tambah-data-identifikasi').attr('disabled', false);
                                            $('#div_tambah_penerap').html('');
                                            $('#tabel-sni-lama tr').html('');
                                            $('#komtek-penerap').html('');
                                            $('.reset-value').html('');
                                            $('.reset-value').val('');
                                            $('#counter-penerap').val(0);
                                            $('#identifikasi-dt').DataTable().ajax.reload();
                                        }
                                    });
                                    
                                    return false;

                                }
                            })
                        }
                    }
                    else {
                        $('#form-identifikasi-edit').validate({
                            submitHandler: function(form) {

                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });

                                $('#tambah-data-identifikasi').html('<i class="spinner-border spinner-border-sm text-light" role="status"></i> Menyimpan...');
                                $('#tambah-data-identifikasi').attr('disabled', true);

                                $.ajax({
                                    type        : "POST",
                                    dataType    : "JSON",
                                    url         : "/identifikasi-sni/identifikasi-edit",
                                    contentType : false,
                                    processData : false,
                                    cache       : false,
                                    data        : new FormData($(form)[0]),
                                    success: function(response) {
                                        Toast.fire({
                                            icon : "success",
                                            title: "Data identifikasi SNI telah tersimpan.",
                                        });                     
                                    },
                                    error: function(response) {
                                        Toast.fire({
                                            icon : "error",
                                            title: "Gagal upload data.",
                                        });
                                    },
                                    complete: function(response) {
                                        $('#modal-identifikasi-edit').modal('hide');
                                        $('#form-identifikasi-edit').find('input').val('');
                                        $('#form-identifikasi-edit').find('textarea').val('');
                                        $('#sifat_sni').prop('selectedIndex',0);
                                        $('.record-penerap').html('');
                                        $('#tambah-data-identifikasi').html('');
                                        $('#tambah-data-identifikasi').text('Simpan');
                                        $('#tambah-data-identifikasi').attr('disabled', false);
                                        $('#div_tambah_penerap').html('');
                                        $('#tabel-sni-lama tr').html('');
                                        $('#komtek-penerap').html('');
                                        $('.reset-value').html('');
                                        $('.reset-value').val('');
                                        $('#counter-penerap').val(0);
                                        $('#identifikasi-dt').DataTable().ajax.reload();
                                    }
                                });

                                return false;

                            }
                        });
                    }
                });
            }
        });
    </script> 
@endpush
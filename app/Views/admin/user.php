<?= $this->extend('admin/layout/content') ?>

<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <button class="btn btn-primary float-right" data-toggle="modal" data-target=".bd-example-modal-lg-user"><i class="fa fa-plus mr-2"></i>Tambah User</button>
        <div class="modal fade bd-example-modal-lg-user" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="<?= base_url('/simpan-user') ?>" method="post">
                    <?php csrf_field() ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Produk Baru</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Nama*</label>
                                <input type="text" class="form-control" name="nama" placeholder="Masukkan nama user" required>                                
                            </div>
                            <div class="form-group">
                                <label for="">Username**</label>
                                <input type="text" class="form-control" name="username" placeholder="Masukkan username" required>                                
                            </div>
                            <div class="form-group">
                                <label for="">Role*</label>
                                <select class="form-control" name="role" id="roleAction">
                                    <option value="administrator">Administrator</option>
                                    <option value="gudang_1"> Gesit </option>
                                    <option value="gudang_2"> Gudang Lovish </option>
                                </select>
                            </div>
                            <div id="gesit-access" style="display: none">
                                <table style="width: 100%">
                                    <td>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="gesit[]" value="1" id="customSwitch1">
                                                <label class="custom-control-label" for="customSwitch1" style="padding-top: 5px;">Input Data Kain & Produk</label>
                                            </div>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="gesit[]" value="2"  id="customSwitch2">
                                                <label class="custom-control-label" for="customSwitch2" style="padding-top: 5px;">Cetak QR Kain & Produk</label>
                                            </div>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="gesit[]" value="3"  id="customSwitch3">
                                                <label class="custom-control-label" for="customSwitch3" style="padding-top: 5px;">QR Scanner Kain (IN)</label>
                                            </div>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="gesit[]" value="7" id="customSwitch30">
                                                <label class="custom-control-label" for="customSwitch30" style="padding-top: 5px;">QR Scanner Pola (IN)</label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="gesit[]" value="4" id="customSwitch4">
                                                <label class="custom-control-label" for="customSwitch4" style="padding-top: 5px;">QR Scanner Pola (OUT)</label>
                                            </div>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="gesit[]" value="5" id="customSwitch5">
                                                <label class="custom-control-label" for="customSwitch5" style="padding-top: 5px;">QR Scanner Produk (IN)</label>
                                            </div>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="gesit[]" value="6" id="customSwitch6">
                                                <label class="custom-control-label" for="customSwitch6" style="padding-top: 5px;">Laporan</label>
                                            </div>
                                        </div>
                                    </td>
                                </table>
                            </div>
                            
                            <div id="lovish-access" style="display: none">
                                <table style="width: 100%">
                                    <td>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="lovish[]" value="1" id="customSwitch7">
                                                <label class="custom-control-label" for="customSwitch7" style="padding-top: 5px;">Input Data Produk & Stok</label>
                                            </div>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="lovish[]" value="2" id="customSwitch8">
                                                <label class="custom-control-label" for="customSwitch8" style="padding-top: 5px;">Cetak QR Pengiriman</label>
                                            </div>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="lovish[]" value="3" id="customSwitch9">
                                                <label class="custom-control-label" for="customSwitch9" style="padding-top: 5px;">QR Scanner Produk (OUT)</label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="lovish[]" value="4" id="customSwitch10">
                                                <label class="custom-control-label" for="customSwitch10" style="padding-top: 5px;">QR Scanner Pengiriman (OUT)</label>
                                            </div>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="lovish[]" value="5" id="customSwitch11">
                                                <label class="custom-control-label" for="customSwitch11" style="padding-top: 5px;">QR Scanner Retur Produk (IN)</label>
                                            </div>
                                        </div>
                                    </td>
                                </table>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </span>
                                    <input type="password" name="new_password" class="form-control" autocomplete="false" id="password" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </span>
                                    <input type="password" name="confirm_password" class="form-control" autocomplete="false" id="confirm_password" value="">

                                </div>
                                <div class="message">
                                    <span id='message'></span>
                                </div>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable3" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Username</th>
                        <th class="text-center">Role</th>
                        <th class="text-right" style="width: 15%;"><i class="fa fa-fas fa-angle-down"></i></th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php $no = 1; ?>
                    <?php if ($users->getNumRows() > 0) : ?>
                        <?php foreach ($users->getResultObject() as $user) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class=""><?= $user->name ?></td>
                                <td><?= $user->username ?></td>
                                <td class="text-center">
                                    <?php if ($user->role == 'administrator') : ?>
                                        <b>Administrator</b>
                                    <?php elseif ($user->role == 'gudang_1') : ?>
                                        <b>Gesit</b>
                                    <?php else : ?>
                                        <b>Gudang Lovish</b>
                                    <?php endif ?>
                                </td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-warning btn-icon-split btn-sm btn-edit-user" data-id='<?= $user->id ?>'>
                                        <span class="icon text-white-25">
                                            <i class="fas fa-pen"></i>
                                        </span>
                                        <span class="text">Edit</span>
                                    </a>
                                    <?php if ($user->role != 'administrator') : ?>
                                        <a href="#" class="btn btn-danger btn-icon-split btn-sm btn-hapus-user" data-id='<?= $user->id ?>'>
                                            <span class="icon text-white-25">
                                                <i class="fas fas fa-trash"></i>
                                            </span>
                                            <span class="text">Hapus</span>
                                        </a>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
            <div class="modal fade bd-example-modal-lg-user-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="<?= base_url('/update-user') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            <div class="form-group">
                                <label for="">Nama*</label>
                                <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan nama user" required>                                
                            </div>
                            <div class="form-group">
                                <label for="">Username**</label>
                                <input type="hidden" id="id-user" name="id">
                                <input type="text" class="form-control" readonly name="username" id="username" placeholder="Masukkan username" required>                                
                            </div>
                            <div class="form-group">
                                <label for="">Role*</label>
                                <select class="form-control" id="role" name="role"">
                                    <option value="administrator">Administrator</option>
                                    <option value="gudang_1">Gesit </option>
                                    <option value="gudang_2">Gudang Lovish </option>
                                </select>
                            </div>
                            <div id="gesit-access-edit" style="display: none">
                                <table style="width: 100%">
                                    <td>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="gesit[]" value="1" id="customSwitch13">
                                                <label class="custom-control-label" for="customSwitch13" style="padding-top: 5px;">Input Data Kain & Produk</label>
                                            </div>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="gesit[]" value="2" id="customSwitch14">
                                                <label class="custom-control-label" for="customSwitch14" style="padding-top: 5px;">Cetak QR Kain & Produk</label>
                                            </div>
                                            <!-- <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="gesit[]" value="3" id="customSwitch15">
                                                <label class="custom-control-label" for="customSwitch15" style="padding-top: 5px;">QR Scanner Kain (IN)</label>
                                            </div> -->
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="gesit[]" value="7" id="customSwitch31">
                                                <label class="custom-control-label" for="customSwitch31" style="padding-top: 5px;">QR Scanner Pola (IN)</label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="gesit[]" value="4" id="customSwitch16">
                                                <label class="custom-control-label" for="customSwitch16" style="padding-top: 5px;">QR Scanner Pola (OUT)</label>
                                            </div>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="gesit[]" value="5" id="customSwitch17">
                                                <label class="custom-control-label" for="customSwitch17" style="padding-top: 5px;">QR Scanner Produk (IN)</label>
                                            </div>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="gesit[]" value="6" id="customSwitch18">
                                                <label class="custom-control-label" for="customSwitch18" style="padding-top: 5px;">Laporan</label>
                                            </div>
                                        </div>
                                    </td>
                                </table>
                            </div>
                            
                            <div id="lovish-access-edit" style="display: none">
                                <table style="width: 100%">
                                    <td>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="lovish[]" value="1" id="customSwitch20">
                                                <label class="custom-control-label" for="customSwitch20" style="padding-top: 5px;">Input Data Produk & Stok</label>
                                            </div>                                            
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="lovish[]" value="3"  id="customSwitch22">
                                                <label class="custom-control-label" for="customSwitch22" style="padding-top: 5px;">QR Scanner Produk (OUT)</label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="lovish[]" value="4"  id="customSwitch23">
                                                <label class="custom-control-label" for="customSwitch23" style="padding-top: 5px;">QR Scanner Pengiriman (OUT)</label>
                                            </div>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="lovish[]" value="5"  id="customSwitch24">
                                                <label class="custom-control-label" for="customSwitch24" style="padding-top: 5px;">QR Scanner Retur Produk (IN)</label>
                                            </div>
                                        </div>
                                    </td>
                                </table>
                            </div>
   
                            
                            
                        </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        $('#password, #confirm_password').on('keyup', function() {
            if ($('#password').val() == $('#confirm_password').val()) {
                $('#message').html('Password Matching').css('color', 'green');
                $('#btnAdd').removeClass('disabled');
            } else
                $('#message').html('Password not matching!').css('color', 'red');
        });

        $('.btn-edit-user').click(function(){
            const id = $(this).data('id');
            $('.bd-example-modal-lg-user-edit').modal('show');
            $.get('/get-user', {user_id: id})
                .done(function(data) {
                    const user = JSON.parse(data);
                    const access = JSON.parse(user['accessibility']);
                    $('#id-user').val(user['id']);
                    $('#nama').val(user['name']);
                    $('#username').val(user['username']);
                    $('#role').val(user['role']);
                    
                    $('.custom-control-input').prop('checked', false);
                    if (user['role'] == 'gudang_1') {
                        if (access !== null) {
                            for (var i=0; i < access.length; i++) {
                                switch(access[i]) {
                                    case "1": 
                                            $('#customSwitch13').prop('checked', true);
                                        break;
                                    case "2": 
                                            $('#customSwitch14').prop('checked', true);
                                        break;
                                    case "3": 
                                            $('#customSwitch15').prop('checked', true);
                                        break;
                                    case "4": 
                                            $('#customSwitch16').prop('checked', true);
                                        break;
                                    case "5": 
                                            $('#customSwitch17').prop('checked', true);
                                        break;
                                    case "6": 
                                            $('#customSwitch18').prop('checked', true);
                                        break;
                                    case "7": 
                                            $('#customSwitch31').prop('checked', true);
                                        break;
                                }
                            }
                        }
                    } else if (user['role'] == 'gudang_2') {
                        if (access !== null) {
                            for (var i=0; i < access.length; i++) {
                                switch(access[i]) {
                                    case "1": 
                                            $('#customSwitch20').prop('checked', true);
                                        break;
                                    case "2": 
                                            $('#customSwitch21').prop('checked', true);
                                        break;
                                    case "3": 
                                            $('#customSwitch22').prop('checked', true);
                                        break;
                                    case "4": 
                                            $('#customSwitch23').prop('checked', true);
                                        break;
                                    case "5": 
                                            $('#customSwitch24').prop('checked', true);
                                        break;
                                    case "6": 
                                            $('#customSwitch25').prop('checked', true);
                                        break;
                                }
                            }
                        }
                    }

                    if (user['role'] == 'gudang_1') {
                        $("#gesit-access-edit").css("display", "block");
                        $("#lovish-access-edit").css("display", "none");
                    } else if(user['role'] == 'gudang_2') {
                        $("#gesit-access-edit").css("display", "none");
                        $("#lovish-access-edit").css("display", "block");
                    } else {
                        $("#gesit-access-edit").css("display", "none");
                        $("#lovish-access-edit").css("display", "none");
                    }
            });
        });

        $('.btn-hapus-user').click(function() {
            const id = $(this).data('id');
            swal({
                    title: "Apakah anda yakin?",
                    text: "User yang anda hapus tidak akan kembali lagi",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("Poof! Data berhasil dihapus!", {
                        icon: "success",
                        });
                        $.post('/delete-user', {user_id: id})
                            .done(function(data) {
                                setTimeout(location.reload.bind(location), 1000);
                            });
                    } else {
                        swal("Data tidak jadi dihapus!");
                    }
                });
        });

        $('#roleAction').on('change', function() {
            const role = $(this).val();
            if (role == 'gudang_1') {
                $("#gesit-access").css("display", "block");
                $("#lovish-access").css("display", "none");
            } else if (role == 'gudang_2') {
                $("#gesit-access").css("display", "none");
                $("#lovish-access").css("display", "block");
            } else {
                $("#gesit-access").css("display", "none");
                $("#lovish-access").css("display", "none");
            }
        });

        $('#role').on('change', function() {
            const role = $(this).val();
            console.log(role);
            if (role == 'gudang_1') {
                $("#gesit-access-edit").css("display", "block");
                $("#lovish-access-edit").css("display", "none");
            } else if (role == 'gudang_2') {
                $("#gesit-access-edit").css("display", "none");
                $("#lovish-access-edit").css("display", "block");
            } else {
                $("#gesit-access-edit").css("display", "none");
                $("#lovish-access-edit").css("display", "none");
            }
        });
    })
</script>

<?= $this->endSection() ?>
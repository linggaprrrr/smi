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
                                <select class="form-control" name="role">
                                    <option value="administrator">Administrator</option>
                                    <option value="gudang_1"> Gudang 1 (Gesit) </option>
                                    <option value="gudang_2"> Gudang 2 (Lovish) </option>
                                </select>
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
                                <td class="text-center"><b><?= $user->role ?></b></td>
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
                                <h5 class="modal-title" id="exampleModalLabel">Edit Produk</h5>
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
                                <select class="form-control" id="role" name="role">
                                    <option value="administrator">Administrator</option>
                                    <option value="gudang_1"> Gudang 1 (Gesit) </option>
                                    <option value="gudang_2"> Gudang 2 (Lovish) </option>
                                </select>
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
                    $('#id-user').val(user['id']);
                    $('#nama').val(user['name']);
                    $('#username').val(user['username']);
                    $('#role').val(user['role']);
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

    })
</script>

<?= $this->endSection() ?>
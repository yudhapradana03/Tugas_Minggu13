<?php
    include("../../db/koneksi.php");

    $id = $_GET['id']; //mengambil id user yang ingin diubah

    //menampilkan user berdasarkan id
    $data = mysqli_query($koneksi, "select * from user where id = '$id'");
    $row = mysqli_fetch_assoc($data);
?>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" method="POST" action="pages/user/update_user.php">
                    <div class="form-group">
                        <label for="editUsername">Username</label>
                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                        <input type="text" class="form-control" id="editUsername" name="username" value="<?= $row['username']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="editRole">Role</label>
                        <select class="form-control" id="editRole" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="Super Admin" <?= ($row['role'] == 'Super Admin') ? 'selected' : ''; ?>>Super Admin</option>
                            <option value="Admin" <?= ($row['role'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                            <option value="User" <?= ($row['role'] == 'User') ? 'selected' : ''; ?>>User</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editPassword">Password</label>
                        <input type="password" class="form-control" id="editPassword" name="password" required>
                    </div>
                    <input type="submit" name="submit" value="Update" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>
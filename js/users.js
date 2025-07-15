$(document).ready(function () {

  // LOAD ALL USERS
  function loadUsers() {
    $.ajax({
      url: '../api/users_api.php',
      method: 'GET',
      data: { action: 'fetch' },
      dataType: 'json',
      success: function (response) {
        let rows = '';
        let i = 1;
        $.each(response.data, function (index, user) {
          let profile = user.profile
            ? `<img src="../assets/img/profiles/${user.profile}" class="rounded-circle" width="40" height="40">`
            : `<div class="bg-secondary text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">${user.initials}</div>`;
          rows += `
            <tr>
              <td>${i++}</td>
              <td>${profile}</td>
              <td>${user.full_name}</td>
              <td>${user.username}</td>
              <td><span class="badge bg-primary">${user.role}</span></td>
              <td><span class="badge ${user.status == 'active' ? 'bg-success' : 'bg-danger'}">${user.status}</span></td>
              <td>${user.created_date}</td>
              <td>
                <button 
                  class="btn btn-sm btn-warning btn-edit-user"
                  data-id="${user.user_id}"
                  data-fullname="${user.full_name}"
                  data-username="${user.username}"
                  data-role="${user.role}"
                  data-status="${user.status}"
                >
                  <i class="bi bi-pencil-fill"></i>
                </button>
                <button 
                class="btn btn-sm btn-danger btn-delete-user" 
                data-id="${user.user_id}"
                >
                <i class="bi bi-trash-fill"></i>
                </button>
              </td>
            </tr>
          `;
        });
        $("#usersTable").html(rows);
      },
      error: function (xhr) {
        console.error(xhr.responseText);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to load users.'
        });
      }
    });
  }

  loadUsers();

  // SUBMIT ADD USER FORM
  $("#addUserForm").submit(function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    formData.append("action", "add");

    $.ajax({
      url: '../api/users_api.php',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function (response) {
        if (response.success) {
          $("#addUserModal").modal('hide');
          $("#addUserForm")[0].reset();
          loadUsers();
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'User added successfully!'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: response.message
          });
        }
      },
      error: function (xhr) {
        console.error(xhr.responseText);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'An error occurred while adding the user.'
        });
      }
    });
  });


  // OPEN EDIT MODAL
  $(document).on('click', '.btn-edit-user', function () {
    let btn = $(this);
    $('#edit_user_id').val(btn.data('id'));
    $('#edit_full_name').val(btn.data('fullname'));
    $('#edit_username').val(btn.data('username'));
    $('#edit_role').val(btn.data('role'));
    $('#edit_status').val(btn.data('status'));

    $('#editUserModal').modal('show');
  });


  // SUBMIT EDIT USER FORM
  $("#editUserForm").submit(function (e) {
    e.preventDefault();

    let formData = $(this).serialize();
    formData += '&action=update';

    $.ajax({
      url: '../api/users_api.php',
      type: 'POST',
      data: formData,
      dataType: 'json',
      success: function (response) {
        if (response.success) {
          $("#editUserModal").modal('hide');
          loadUsers();
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'User updated successfully!'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: response.message
          });
        }
      },
      error: function (xhr) {
        console.error(xhr.responseText);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'An error occurred while updating the user.'
        });
      }
    });
  });




  $(document).on('click', '.btn-delete-user', function () {
  let userId = $(this).data('id');

  Swal.fire({
    title: 'Are you sure?',
    text: "This user will be permanently deleted!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: '../api/users_api.php',
        type: 'POST',
        data: { action: 'delete', user_id: userId },
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            loadUsers();
            Swal.fire({
              icon: 'success',
              title: 'Deleted!',
              text: 'User has been deleted.'
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: response.message
            });
          }
        },
        error: function (xhr) {
          console.error(xhr.responseText);
          Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'An error occurred while deleting the user.'
          });
        }
      });
    }
  });
});
});


$(document).ready(function() {
  // Load users dynamically:
  $.ajax({
    url: "../api/users_api.php",
    method: "POST",
    data: { action: "fetch_users" },
    dataType: "json",
    success: function(response) {
      if (response.success) {
        let $select = $("#userSelect");
        $select.empty();
        $select.append('<option value="">-- Select User --</option>');

        response.users.forEach(function(user) {
          let optionText = `${user.full_name} (${user.role})`;
          $select.append(
            `<option value="${user.user_id}">${optionText}</option>`
          );
        });
      }
    }
  });
});






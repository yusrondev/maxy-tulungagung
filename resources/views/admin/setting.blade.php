@extends('layouts.backoffice')
@section('menu-setting', 'active')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-body">
          <button id="openModal" class="btn btn-primary">
              <i class='bx bxs-user-plus'></i> Create User
          </button><br><br>
          <table id="users-table" class="display">
              <thead>
                  <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>

              </tbody>
          </table>

          <div id="createUserModal" class="modal">
            <div class="modal-content">
                <span style="text-align:right" class="close">&times;</span>
                <h2>Create User</h2>
                <form id="createUserForm">
                  @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div><br>
                    <button type="submit" class="btn btn-primary">Save User</button>
                </form>
            </div>
          </div>

          <div id="editUserModal" class="modal">
              <div class="modal-content">
                  <span style="text-align:right" class="close">&times;</span>
                  <h2>Edit User</h2>
                  <form id="editUserForm">
                      @csrf
                      @method('PUT') <!-- Menandai bahwa ini adalah request PUT -->
                      <input type="hidden" id="editUserId" name="id">
                      <div class="form-group">
                          <label for="editName">Name</label>
                          <input type="text" class="form-control" id="editName" name="name" required>
                      </div>
                      <div class="form-group">
                          <label for="editEmail">Email</label>
                          <input type="email" class="form-control" id="editEmail" name="email" required>
                      </div>
                      <div class="form-group">
                          <label for="editPassword">Password</label>
                          <input type="password" class="form-control" id="editPassword" name="password">
                      </div><br>
                      <button type="submit" class="btn btn-primary">Update User</button>
                  </form>
              </div>
          </div>

        </div>
    </div>
</div>
@endsection
@push('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>

    var token = $('meta[name="csrf-token"]').attr('content');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });

    $(document).ready(function() {
        // Initialize DataTable
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url('/api/users') }}',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                {
                  data: null,
                  render: function(data, type, row) {
                      return `
                          <button class="btn btn-info btn-edit" data-id="${row.id}" data-name="${row.name}" data-email="${row.email}">Edit</button>
                          <button class="btn btn-delete btn-delete" data-id="${row.id}">Delete</button>
                      `;
                  },
                  name: 'action'
                }
            ]
        });

        // Get modal and button
        var modal = document.getElementById("createUserModal");
        var btn = document.getElementById("openModal");
        var span = document.getElementsByClassName("close")[0];

        // Buka modal ketika tombol diklik
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // Tutup modal ketika tombol close diklik
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Tutup modal jika klik di luar modal
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Handle form submission
        $('#createUserForm').on('submit', function(e) {
          e.preventDefault();

          // Prepare data to be sent to the server
          var formData = $(this).serialize();

          $.ajax({
              url: '{{ url('/api/add') }}',
              method: 'POST',
              data: formData,
              success: function(response) {
                  modal.style.display = "none"; // Hide the modal
                  $('#users-table').DataTable().ajax.reload(); // Reload the table data
                  Swal.fire({
                      title: 'Success!',
                      text: 'User created successfully!',
                      icon: 'success',
                      confirmButtonText: 'OK'
                  });
              },
              error: function(xhr) {
                  Swal.fire({
                      title: 'Error!',
                      text: 'An error occurred: ' + xhr.responseText,
                      icon: 'error',
                      confirmButtonText: 'OK'
                  });
              }
          });
      });

      // Edit User
      $('#users-table').on('click', '.btn-edit', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var email = $(this).data('email');

            $('#editUserId').val(id);
            $('#editName').val(name);
            $('#editEmail').val(email);

            $('#editUserModal').show();
        });

        // Handle Edit User Form Submission
        $('#editUserForm').on('submit', function(e) {
            e.preventDefault();

            var id = $('#editUserId').val();
            var formData = $(this).serialize();

            $.ajax({
                url: '{{ url('/api/editUser') }}/' + id,
                method: 'PUT',
                data: formData,
                success: function(response) {
                    $('#editUserModal').hide(); // Hide the modal
                    table.ajax.reload(); // Reload the table data
                    Swal.fire({
                        title: 'Success!',
                        text: 'User updated successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred: ' + xhr.responseText,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // Delete User
        $('#users-table').on('click', '.btn-delete', function() {
            var id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url('/api/deleteUser') }}/' + id,
                        method: 'DELETE',
                        success: function(response) {
                            table.ajax.reload(); // Reload the table data
                            Swal.fire(
                                'Deleted!',
                                'User has been deleted.',
                                'success'
                            );
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'An error occurred: ' + xhr.responseText,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });
    });
  </script>
@endpush

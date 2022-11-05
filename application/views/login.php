<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

  <title>JWT Abdul Rohamn</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/cover/">
  <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <!-- Custom styles for this template -->
  <link href="<?= base_url('asset/') ?>cover.css" rel="stylesheet">
</head>

<body class="text-center">

  <div class=" d-flex p-3 mx-auto flex-column" style="width: 1000px;">
    <header class="masthead mb-auto">
      <div class="inner">
        <h3 class="masthead-brand">JWT Abdul Rohman</h3>
        <nav class="nav nav-masthead justify-content-center">
          <a href="#add" class="mr-2 tambah btn btn-sm btn-success" data-toggle="modal">Tambah User Baru</a>
          <a href="#" class="logOut btn btn-sm btn-danger">Log Out</a>
        </nav>
      </div>
    </header>
    <form id="login" style="width: 300px;" class="mx-auto">
      <div class="form-row">
        <div class="form-group col-md-12">
          <input type="email" class="form-control" name="username" placeholder="Email">
          <input type="password" class="mt-3 form-control" name="password" placeholder="Password">
        </div>

      </div>
      <button type="submit" class="btn btn-primary btn-block">Sign in</button>
    </form>

    <div id="notif" class="mb-3"></div>
    <main id="main">

      <h4>Data User</h4>
      <table class="table table-sm table-bordered">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nama Lengkap</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody id="isi">
        </tbody>
      </table>

    </main>

    <!-- Modal -->
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="exampleModalLabel">Tambah User Baru</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="formData">
            <div class="modal-body">
              <div class="form-row">
                <div class="form-group col-md-12">
                  <input type="text" class="form-control name" name="name" placeholder="Nama Lengkap">
                  <input type="email" class="mt-3 form-control email" name="email" placeholder="Email">
                  <input type="password" class="mt-3 form-control password" name="password" placeholder="Password">
                  <select name="role" class="mt-3 form-control role">
                    <option>Hak Akses</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <footer class="mastfoot mt-auto">
      <div class="inner">
        <p>Cover template for <a href="https://getbootstrap.com/">Bootstrap</a>, by <a href="https://twitter.com/mdo">@mdo</a>.</p>
      </div>
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script>
    $('.tambah').click(function(e) {
      e.preventDefault()
      $('input').val('')
    })
    
    $('.logOut').click(function(e) {
      e.preventDefault()
      if (confirm('Yakin ingin keluar dari sesi ini ?') == true) {
        document.cookie = 'token='
        $('#login').show()
        $('#main').hide()
        $('nav').hide()
      }
    })

    $('nav').hide()
    $('#login').show()
    $('#main').hide()
    $('#isi').html('')

    $('#login').submit(function(e) {
      e.preventDefault()
      $.ajax({
        url: 'http://siswa.test/api/get/',
        dataType: 'json',
        data: $(this).serialize(),
        type: 'post',
        success: function(res) {
          console.log(res);

          if (res.kode == 200) {
            $('#main').show()
            $('nav').show()
            $('#login').hide()
            $('#notif').html('<span class="alert alert-success d-block">Login Berhasil !</span>')
            document.cookie = "token=" + res.token;
            setTimeout(() => {
              $('#notif').hide()
            }, 1000);
          } else {
            $('#notif').html('<span class="alert alert-danger">Login Gagal !</span>')
          }


        }
      })
    })

    $('#formData').submit(function(e) {
      e.preventDefault()

      var cookie = document.cookie
      cookie = cookie.split(';')
      for (let i = 0; i < cookie.length; i++) {
        index = cookie[i].indexOf('token=')
        if (cookie[i].indexOf('token=') == 1) {
          var token = cookie[i]
        }
      }

      if (confirm('Yakin ingin menyimpan data ini ?') == true) {
        $.ajax({
          url: 'http://siswa.test/home/insert/',
          dataType: 'json',
          data: {
            'email': $('.email').val(),
            'name': $('.name').val(),
            'password': $('.password').val(),
            'role': $('.role').val(),
            'token': token,
          },
          type: 'post',
          success: function(res) {
            console.log(res);

            if (res.kode == 200) {
              setCookie()
              $('#add').modal('hide')
              $('#notif').show()
              $('#notif').html('<span class="alert alert-success">' + res.pesan + '</span>')
              setTimeout(() => {
                setCookie()
                $('#notif').hide()
              }, 2000);
            } else {
              $('#notif').html('<span class="alert alert-danger">' + res.pesan + '</span>')
            }
            setTimeout(() => {
              $('#notif').hide()
            }, 1000);

          }
        })
      }
    })

    function getUser(token, type) {
      $.ajax({
        url: 'http://siswa.test/home/api_post/',
        dataType: 'json',
        data: {
          'token': token
        },
        type: type,
        success: function(res) {
          if (res != null) {
            var el = res.data
            $('#login').hide()
            $('#main').show()
            $('nav').show()
            var html = ''
            for (let i = 0; i < el.length; i++) {
              html += '<tr>' +
                '<td>' + (i + 1) + '</td>' +
                '<td>' + el[i].name + '</td>' +
                '<td>' + el[i].email + '</td>' +
                '<td>' + el[i].role + '</td>' +
                '<td><a href="#add" data-toggle="modal" data-id="' + el[i].id_user + '" class="detail badge badge-sm badge-primary mr-2">Detail</a><a href="#" class="delete badge badge-sm badge-danger" data-id="' + el[i].id_user + '">Delete</a></td>' +
                '</tr>'
            }
            $('#isi').html(html)
          }


        }
      })
    }

    setCookie()

    function setCookie() {
      var cookie = document.cookie
      cookie = cookie.split(';')
      for (let i = 0; i < cookie.length; i++) {
        index = cookie[i].indexOf('token=')
        if (cookie[i].indexOf('token=') == 1) {
          getUser(cookie[i], 'POST')
        }
      }
    }

    $('#isi').on('click', '.detail', function(e) {
      e.preventDefault()
      var cookie = document.cookie
      cookie = cookie.split(';')
      for (let i = 0; i < cookie.length; i++) {
        index = cookie[i].indexOf('token=')
        if (cookie[i].indexOf('token=') == 1) {
          var token = cookie[i]
        }
      }
      var id = $(this).data('id')
      $.ajax({
        url: 'http://siswa.test/home/api_post/' + id,
        dataType: 'json',
        data: {
          'token': token
        },
        type: 'post',
        success: function(res) {
          console.log(res);
          if (res != null) {
            $('.name').val(res.name)
            $('.email').val(res.email)
            $('.password').val(res.password)
            $('.role').val(res.role)
          } else {
            alert('Data tidak ditemukan!')
          }
        }
      })
    })

    $('#isi').on('click', '.delete', function(e) {
      e.preventDefault()
      var cookie = document.cookie
      cookie = cookie.split(';')
      for (let i = 0; i < cookie.length; i++) {
        index = cookie[i].indexOf('token=')
        if (cookie[i].indexOf('token=') == 1) {
          var token = cookie[i]
        }
      }
      var id = $(this).data('id')
      console.log(id);
      if (confirm('Yakin ingin menghapus data ini ?') == true) {
        $.ajax({
          url: 'http://siswa.test/home/delete/' + id,
          dataType: 'json',
          data: {
            'token': token
          },
          type: 'post',
          success: function(res) {
            if (res != null) {
              setCookie()
              $('#notif').show()
              $('#notif').html('<span class="alert alert-success">' + res.pesan + '</span>')
              setTimeout(() => {
                $('#notif').hide()
              }, 2000);
            } else {
              $('#notif').html('<span class="alert alert-danger">Gagal Menghapus data!</span>')
            }
          }
        })
      }
    })
  </script>
</body>

</html>
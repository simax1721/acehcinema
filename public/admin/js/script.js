function sweetAlertNorm(title, text, icon) {
  Swal.fire({
    icon: icon,
    title: title,
    timer: 3000,
    text: text,
    // showConfirmButton: false,
  });
}


const Movie = {
  movies(token) {
    $('#dataTable').DataTable({
      processing : true,
      serverSide : true,
      ajax : {
        url: "/api/movies/datatable",
        type: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token
        },
      },
      columns: [
        {data:'title',name:'title'},
        {data:'category',name:'category'},
        {data:'poster',name:'poster'},
        {data:'views',name:'views'},
        {data:'release_date',name:'release_date'},
        {data:'created_at',name:'created_at'},
        {data:'action',name:'action', orderable: false, searchable: false},
      ],
      order: [[5, 'asc']]
    });

    $('body').on('click', '#btn-create', function () {

        //open modal
        $('#modal-create').modal('show');
    });

    $('#store').click(function (e) { 
      e.preventDefault();

      let title = $('#title').val();
      let category = $('#category').val();

      $.ajax({
        type: "POST",
        url: "/api/movies/store",
        headers: {
            'Authorization': 'Bearer ' + token
        },
        data: { title, category },
        beforeSend: () => {
        $('#store')
          .addClass('disabled')
          .html('<i class="fa-solid fa-spinner fa-spin"></i>');
          // $(selector).addClass(className);
          // $(selector).removeClass(className);
        },
        complete: () => {
          $('#store')
            .removeClass('disabled')
            .html('<i class="fa fa-send"></i>');
        },
        success: (res) => {
          console.log(res);
          sweetAlertNorm(res.message.title, res.message.text, res.message.icon);
          setTimeout(() => (window.location.href = `/admin/movie/detail/${res.data.id}`), 1000);
        },
        
        error: (xhr) => {
          console.log(xhr);
          const msg =
              xhr.responseJSON?.message ||
              xhr.responseJSON?.title?.[0] ||
              xhr.responseJSON?.category?.[0] ||
              'Gagal.';
            toastr.error(msg);
        }
      });
    });

  },

  movieUpdate(token) {
    const movieId = window.location.pathname.split("/").pop();
    this.movieShow(token, movieId);

    $('#fileThumbnail').on('change', function() {
        // ambil nama file yang dipilih
        let fileName = $(this).val().split('\\').pop(); 
        // ganti teks label di sebelah input
        $(this).next('.custom-file-label').text(fileName || 'New Thumbnail');
    });

    $('#filePoster').on('change', function() {
        // ambil nama file yang dipilih
        let fileName = $(this).val().split('\\').pop(); 
        // ganti teks label di sebelah input
        $(this).next('.custom-file-label').text(fileName || 'New Poster');
    });

    
    $('#uploadThumbnail').click(function (e) { 
      e.preventDefault();
      let action = $('#uploadThumbnail').data('actionthumb');

      movieUpdate(token, movieId, action);
      
    });
    
    $('#uploadPoster').click(function (e) { 
      e.preventDefault();
      let action = $('#uploadPoster').data('actionposter');

      movieUpdate(token, movieId, action);
      
    });
    
    $('#updateMovie').click(function (e) { 
      e.preventDefault();
      let action = $('#updateMovie').data('actioniupmov');

      movieUpdate(token, movieId, action);
      
    });


  },
  movieShow(token, movieId) {
    $.ajax({
      type: "GET",
      url: `/api/movies/show-admin/${movieId}`,
      headers: {
        'Authorization': 'Bearer ' + token
      },
      success: (res) => {
        $('#thumb-img').attr('src', res.thumbnail);
        $('#poster-img').attr('src', res.poster);

        $('#title').val(res.title);
        $('#category').val(res.category);
        $('#dacast_embed').val(res.dacast_embed);
        $('#trailer_dacast_embed').val(res.trailer_dacast_embed);
        $('#age').val(res.age);
        $('#duration').val(res.duration);
        $('#description').val(res.description);
        $('#release_date').val(res.release_date);
        $('#actor').val(res.actor);
        $('#writter').val(res.writter);
        $('#producer').val(res.producer);
        $('#production').val(res.production);
      },
    });
  },

}

function movieUpdate(token, movieId, action) {

    let title = $('#title').val();
    let category = $('#category').val();
    let dacast_embed = $('#dacast_embed').val();
    let trailer_dacast_embed = $('#trailer_dacast_embed').val();
    let age = $('#age').val();
    let duration = $('#duration').val();
    let description = $('#description').val();
    let release_date = $('#release_date').val();
    let actor = $('#actor').val();
    let writter = $('#writter').val();
    let producer = $('#producer').val();
    let production = $('#production').val();

    let fileThumbnail = $('#fileThumbnail')[0].files[0];
    let filePoster = $('#filePoster')[0].files[0];

    let formData = new FormData();
    formData.append('title', title);
    formData.append('category', category);
    formData.append('dacast_embed', dacast_embed);
    formData.append('trailer_dacast_embed', trailer_dacast_embed);
    formData.append('age', age);
    formData.append('duration', duration);
    formData.append('description', description);
    formData.append('release_date', release_date);
    formData.append('actor', actor);
    formData.append('writter', writter);
    formData.append('producer', producer);
    formData.append('production', production);
    
    formData.append('fileThumbnail', fileThumbnail) == undefined ? '' : formData.append('fileThumbnail', fileThumbnail);
    formData.append('filePoster', filePoster) == undefined ? '' : formData.append('filePoster', filePoster);
    
    formData.append('action', action);
    
    // if (fileThumbnail) {
    //   // formData.append('fileThumbnail', fileThumbnail);
    // }

    // console.log(fileThumbnail);
    

    $.ajax({
      type: "POST",
      url: `/api/movies/update/${movieId}`,
      data: formData,
      processData: false, // penting! biar jQuery tidak ubah ke query string
      contentType: false, // penting! biar browser set Content-Type otomatis
      headers: {
        'Authorization': 'Bearer ' + token
      },
      beforeSend: () => {
      $(`#${action}`)
        .addClass('disabled')
        .html('<i class="fa-solid fa-spinner fa-spin"></i>');
      },
      complete: () => {
        $(`#${action}`)
          .removeClass('disabled')
          .html('Update');
      },
      success: (res) => {
        console.log(res);
        Movie.movieShow(token, movieId);
        sweetAlertNorm(res.message.title, res.message.text, res.message.icon);
      },
      error: (xhr) => {
        console.log(xhr);
        
      }
    });
  }
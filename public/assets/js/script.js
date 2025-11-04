function ucwords(str) {
  return str.replace(/\b\w/g, (char) => char.toUpperCase());
}

function homeGetMovie() {
    $('.movies').each(function () {
      const section = $(this);
      const category = section.data('category');
      const swiperWrapper = section.find('.swiper-wrapper');

      $.ajax({
        url: `/api/movies?category=${category}`,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
          swiperWrapper.empty();

          response.data.forEach(movie => {
            const slide = `
              <div class="swiper-slide">
                <div class="movie-card"
                  data-id="${movie.id}"
                  data-title="${movie.title}"
                  data-category="${movie.category}"
                  data-date="${ new Date(movie.release_date).getFullYear() }"
                  data-poster="${movie.poster}"
                  data-trailer='${movie.trailer_dacast_embed}'>
                  <img src="${movie.poster}" alt="${movie.title}">
                </div>
              </div>`;
            swiperWrapper.append(slide);
          });

          if (response.data.length > 15) {
            swiperWrapper.append(`<a href="/section-movie/${category}" class="swiper-slide more-movie-list">
                <p>More +</p>
              </a>`);
          }

          

          // Inisialisasi swiper setelah isi konten
          new Swiper(section.find('.swiper')[0], {
            slidesPerView: 'auto',
            spaceBetween: 20,
            navigation: {
              nextEl: section.find('.swiper-button-next')[0],
              prevEl: section.find('.swiper-button-prev')[0],
            },
          });

          $('.swipper-button-costume').addClass('show');
        },
        error: function () {
          swiperWrapper.html('<p style="color:#aaa;">Gagal memuat data.</p>');
        }
      });
    });

    // === Tooltip Logic ===
    let tooltipTimeout;
    $(document).on('mouseenter', '.movie-card', function () {
      clearTimeout(tooltipTimeout);
      const card = $(this);
      mouseEnterMovieCard(card);
      
    });

    $(document).on('mouseleave', '.movie-card', function () {
      tooltipTimeout = setTimeout(() => {
        mouseLeaveMovieCard();
      }, 200);
    });

    $('#movie-tooltip').hover(
      function () {
        clearTimeout(tooltipTimeout);
      },
      function () {
        $(this).removeClass('show');
        $(this).find('.tooltip-video').empty(); // hapus iframe saat tooltip hilang
      }
    );
}









function sectionMovie() {
  
  const pathParts = window.location.pathname.split("/");
  const category = pathParts[pathParts.length - 1] || "popular";

  $('#category-title').html(ucwords(category));

  const movieList = $('#movie-list');
  const loadMoreBtn = $('#load-more');
  let currentPage = 1;
  let lastPage = 1;

  let url = `/api/movies?category=${category}&`;

  // 🔹 muat halaman pertama
  loadMovies(currentPage, url, movieList, loadMoreBtn)
      .then(lp => lastPage = lp)
      .catch(console.error);

  // 🔹 load halaman berikutnya
  loadMoreBtn.on('click', function () {
      if (currentPage < lastPage) {
          currentPage++;
          loadMovies(currentPage, url, movieList, loadMoreBtn)
              .then(lp => lastPage = lp)
              .catch(console.error);
      }
  });

  // Tooltip Logic (tetap sama)
  let tooltipTimeout;

  $(document).on('mouseenter', '.movie-card', function () {
      clearTimeout(tooltipTimeout);
      const card = $(this);
      mouseEnterMovieCard(card);
  });

  $(document).on('mouseleave', '.movie-card', function () {
      tooltipTimeout = setTimeout(() => {
         mouseLeaveMovieCard();
      }, 200);
  });

  $('#movie-tooltip').hover(
      function () { clearTimeout(tooltipTimeout); },
      function () {
          $(this).removeClass('show');
          $(this).find('.tooltip-video').empty();
      }
  );
}

function getMovieInfo(movieAbout, movieId) {
  $.ajax({
  type: "get",
  url: `/api/movies/show/${movieId}`,
  dataType: "json",
  success: function (response) {
      movieAbout.empty();

      const durationMinutes = response.duration; // misalnya 182 menit
      const hours = Math.floor(durationMinutes / 60);
      const minutes = durationMinutes % 60;
      const formattedDuration = `${hours > 0 ? hours + ' Jam ' : ''}${minutes} Menit`;
      const year = new Date(response.release_date).getFullYear();

      const content = `<div class="thumbnail">
          <img  src="${response.thumbnail}" alt="">
          <div class="thumbnail-gradiend"></div>
      </div>
      <div class="detail">
          <div class="detail-start">
              <img class="poster" src="${response.poster}" alt="">
              <div class="detail-info">
                  <h3 class="title text-uppercase">${response.title}</h3>
                  <ul class="">
                      <li class="category">${response.category}</li>
                      <li class="age">${response.age}</li>
                      <li class="duration">${formattedDuration}</li>
                  </ul>
                  <div class="btn-detail">
                      <a href="/watch/${response.id}" class="active need-login"><i class="fa-solid fa-play"></i> Tonton</a>
                      <a href="#" class="need-login"><i class="fa-solid fa-plus"></i> Favorit</a>
                      <a href="#" class="need-login"><i class="fa-solid fa-thumbs-up"></i> Suka</a>
                  </div>
              </div>
          </div>
          <div class="detail-end">
              <p class="description">${response.description}</p>
              <p class="desc-title">Pemeran</p>
              <p class="desc-content actor">${response.actor}</p>
              <p class="desc-title">Rilis</p>
              <p class="desc-content year">${year}</p>
              <p class="desc-title">Penulis</p>
              <p class="desc-content writter">${response.writter}</p>
              <p class="desc-title">Sutradara</p>
              <p class="desc-content producer">${response.producer}</p>
              <p class="desc-title">Produksi</p>
              <p class="desc-content production">${response.production}</p>
          </div>
      </div>`;
      
      movieAbout.append(content);
      
    }
  });
}

function movieWatch(token) {
  const movieId = window.location.pathname.split("/").pop();

  $.ajax({
      type: "get",
      url: `/api/movies/watch-movie/${movieId}`,
      dataType: "json",
      headers: {
          'Authorization': 'Bearer ' + token
      },
      success: function (response) {
          $('.play-movie').html(response.dacast_embed);
      }
  });
            
    const movieAbout = $('.description-movie');
    $.ajax({
        type: "get",
        url: `/api/movies/show/${movieId}`,
        dataType: "json",
        headers: {
            'Authorization': 'Bearer ' + token
        },
        success: function (response) {
            movieAbout.empty();

            const durationMinutes = response.duration; // misalnya 182 menit
            const hours = Math.floor(durationMinutes / 60);
            const minutes = durationMinutes % 60;
            const formattedDuration = `${hours > 0 ? hours + ' Jam ' : ''}${minutes} Menit`;
            const year = new Date(response.release_date).getFullYear();

            // $('.play-movie').html(response.dacast_embed);

            const content = `<div class="detail">
                <div class="detail-start">
                    <img class="poster" src="${response.poster}" alt="">
                    <div class="detail-info">
                        <h3 class="title text-uppercase">${response.title}</h3>
                        <ul class="">
                            <li class="category">${response.category}</li>
                            <li class="age">${response.age}</li>
                            <li class="duration">${formattedDuration}</li>
                        </ul>
                        <div class="btn-detail">
                            <a href="#"><i class="fa-solid fa-plus"></i> Favorit</a>
                            <a href="#" class="active"><i class="fa-solid fa-thumbs-up"></i> Suka</a>
                        </div>
                    </div>
                </div>
                <div class="detail-end">
                    <p class="description">${response.description}</p>
                    <p class="desc-title">Pemeran</p>
                    <p class="desc-content actor">${response.actor}</p>
                    <p class="desc-title">Rilis</p>
                    <p class="desc-content year">${year}</p>
                    <p class="desc-title">Penulis</p>
                    <p class="desc-content writter">${response.writter}</p>
                    <p class="desc-title">Sutradara</p>
                    <p class="desc-content producer">${response.producer}</p>
                    <p class="desc-title">Produksi</p>
                    <p class="desc-content production">${response.production}</p>
                </div>
            </div>`;
            movieAbout.append(content);
        }
    });
    
    const movieList = $('#movie-list');
    const loadMoreBtn = $('#load-more');
    let currentPage = 1; // halaman awal
    let lastPage = 1; // akan diupdate dari response

    let url = `/api/movies?`;

    // 🔹 muat halaman pertama
    loadMovies(currentPage, url, movieList, loadMoreBtn)
        .then(lp => lastPage = lp)
        .catch(console.error);

    // 🔹 load halaman berikutnya
    loadMoreBtn.on('click', function () {
        if (currentPage < lastPage) {
            currentPage++;
            loadMovies(currentPage, url, movieList, loadMoreBtn)
                .then(lp => lastPage = lp)
                .catch(console.error);
        }
    });

    // Tooltip Logic (tetap sama)
    let tooltipTimeout;

    $(document).on('mouseenter', '.movie-card', function () {
        clearTimeout(tooltipTimeout);
        const card = $(this);
        mouseEnterMovieCard(card);
    });

    $(document).on('mouseleave', '.movie-card', function () {
        tooltipTimeout = setTimeout(() => {
            mouseLeaveMovieCard();
        }, 200);
    });

    $('#movie-tooltip').hover(
        function () { clearTimeout(tooltipTimeout); },
        function () {
            $(this).removeClass('show');
            $(this).find('.tooltip-video').empty();
        }
    );
}

function sweetAlertNorm(title, text, icon) {
  Swal.fire({
    icon: icon,
    title: title,
    timer: 3000,
    text: text,
    // showConfirmButton: false,
  });
}

function mouseEnterMovieCard(card) {
  const tooltip = $('#movie-tooltip');
  // ambil iframe embed dari data
  const dacastEmbed = card.data('trailer');

  // ganti isi video container dengan iframe dacast
  tooltip.find('.tooltip-video').html(dacastEmbed);

  tooltip.find('.movie-title').text(card.data('title'));
  tooltip.find('.movie-meta').text(card.data('date'));
  tooltip.find('.movie-genre').text(card.data('category'));
  tooltip.find('.play-btn').attr('href', '/movie/' + card.data('id'));

  const offset = card.offset();
  tooltip.css({
    top: offset.top + card.height() / 2 - tooltip.outerHeight() / 2,
    left: offset.left + card.width() / 2 - tooltip.outerWidth() / 2,
  }).addClass('show');
}

function mouseLeaveMovieCard () {
  $('#movie-tooltip').removeClass('show');
  $('#movie-tooltip .tooltip-video').empty(); // hapus iframe agar tidak tetap main
}

function loadMovies(currentPage, url, movieList, loadMoreBtn) {
    return new Promise((resolve, reject) => {
      console.log(`${url}page=${currentPage}`);
      
        $.ajax({
            type: "GET",
            url: `${url}page=${currentPage}`,
            dataType: "json",
            beforeSend: () => {
              // setting a timeout
              $('#load-more').attr('disabled', '');
              $('#load-more').html('<i class="fa-solid fa-spinner fa-spin"></i>');
            },
            complete:  () => { 
              $('#load-more').removeAttr('disabled', '');
              $('#load-more').html('TAMPILKAN LAINNYA');
            },
            success: function (response) {
                const movies = response.data;
                const lastPage = response.last_page;

                movies.forEach(movie => {
                    const card = `
                        <div class="col-auto mb-3">
                            <div class="movie-card"
                                data-id="${movie.id}"
                                data-title="${movie.title}"
                                data-category="${movie.category}"
                                data-date="${new Date(movie.release_date).getFullYear()}"
                                data-poster="${movie.poster}"
                                data-trailer='${movie.trailer_dacast_embed}'>
                                <img src="${movie.poster}" alt="${movie.title}">
                            </div>
                        </div>`;
                    movieList.append(card);
                });

                $('.load-movie-btn').addClass('show');

                // sembunyikan tombol jika sudah halaman terakhir
                if (currentPage >= lastPage) {
                    loadMoreBtn.hide();
                } else {
                    loadMoreBtn.show();
                }

                resolve(lastPage);
            },
            error: function (xhr) {
                movieList.html('<p style="color:#aaa;">Gagal memuat data.</p>');
                reject(xhr);
            }
        });
    });
}
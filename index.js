const movies = [
        {
          title: "Inception",
          year: 2010,
          category: "sci-fi",
          poster: "https://image.tmdb.org/t/p/original/xlaY2zyzMfkhk0HSC5VUwzoZPU1.jpg",
        },
        {
          title: "Interstellar",
          year: 2014,
          category: "sci-fi",
          poster:"https://m.media-amazon.com/images/I/91kFYg4fX3L._AC_SL1500_.jpg",
        },
        {
          title: "The Dark Knight",
          year: 2008,
          category: "action",
          poster: "https://image.tmdb.org/t/p/original/qJ2tW6WMUDux911r6m7haRef0WH.jpg",
        },
        {
          title: "Avatar",
          year: 2009,
          category: "sci-fi",
          poster: "https://m.media-amazon.com/images/I/41kTVLeW1CL._AC_.jpg",
        },
        {
          title: "Joker",
          year: 2019,
          category: "drama",
          poster:
            "https://image.tmdb.org/t/p/original/udDclJoHjfjb8Ekgsd4FDteOkCU.jpg",
        },
        {
          title: "Dune",
          year: 2021,
          category: "sci-fi",
          poster:
            "https://image.tmdb.org/t/p/original/d5NXSklXo0qyIYkgV94XAgMIckC.jpg",
        },
        {
          title: "Gladiator",
          year: 2000,
          category: "action",
          poster: "https://image.tmdb.org/t/p/original/ty8TGRuvJLPUmAR1H1nRIsgwvim.jpg",
        },
        {
          title: "Titanic",
          year: 1997,
          category: "drama",
          poster: "https://image.tmdb.org/t/p/original/9xjZS2rlVxm8SFx8kPC3aIGCOYQ.jpg",
        },
        {
          title: "The Matrix",
          year: 1999,
          category: "sci-fi",
          poster: "https://m.media-amazon.com/images/I/51vpnbwFHrL._AC_.jpg",
        },
        {
          title: "Mad Max: Fury Road",
          year: 2015,
          category: "action",
          poster:
            "https://cdn11.bigcommerce.com/s-ydriczk/images/stencil/1500x1500/products/87368/88594/Mad_Max_Fury_Road_us_one_sheet_buy_original_movie_posters_at_starstills__22128.1427574502.jpg?c=2&imbypass=on",
        },
        {
          title: "Forrest Gump",
          year: 1994,
          category: "drama",
          poster:
            "https://image.tmdb.org/t/p/original/saHP97rTPS5eLmrLQEcANmKrsFl.jpg",
        },
        {
          title: "Oppenheimer",
          year: 2023,
          category: "upcoming",
          poster:
            "https://image.tmdb.org/t/p/original/8Gxv8gSFCU0XGDykEGv7zR1n2ua.jpg",
        },
      ];

function renderCategory(category, containerId) {
  const container = document.querySelector(`#${containerId} .movies`);
  const filtered = movies.filter((m) => m.category === category);
  container.innerHTML = "";
  filtered.forEach((movie) => {
    const card = document.createElement("div");
    card.className = "movie-card";
    card.innerHTML = `
          <img src="${movie.poster}" alt="${movie.title}">
          <div class="movie-info">
            <h4>${movie.title}</h4>
            <span>${movie.year}</span>
          </div>
        `;
    container.appendChild(card);
  });
}

renderCategory("action", "action");
renderCategory("drama", "drama");
renderCategory("sci-fi", "sci-fi");
renderCategory("action", "popular");
renderCategory("drama", "top-rated");
renderCategory("sci-fi", "trending");

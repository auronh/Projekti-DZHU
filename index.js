const movies = [
  {
    title: "Inception",
    year: 2010,
    category: "sci-fi",
    poster: "https://m.media-amazon.com/images/I/51s+2eG4pFL._AC_.jpg",
  },
  {
    title: "Interstellar",
    year: 2014,
    category: "sci-fi",
    poster: "https://m.media-amazon.com/images/I/91kFYg4fX3L._AC_SL1500_.jpg",
  },
  {
    title: "The Dark Knight",
    year: 2008,
    category: "action",
    poster: "https://m.media-amazon.com/images/I/51EbJjlLgML._AC_.jpg",
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
    poster: "https://m.media-amazon.com/images/I/71K8n4qF5ZL._AC_SL1178_.jpg",
  },
  {
    title: "Dune",
    year: 2021,
    category: "sci-fi",
    poster: "https://m.media-amazon.com/images/I/81YJbFZ3zBL._AC_SL1500_.jpg",
  },
  {
    title: "Gladiator",
    year: 2000,
    category: "action",
    poster: "https://m.media-amazon.com/images/I/51A9Fz7c6JL._AC_.jpg",
  },
  {
    title: "Titanic",
    year: 1997,
    category: "drama",
    poster: "https://m.media-amazon.com/images/I/41g0Jv6Jw9L._AC_.jpg",
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
    poster: "https://m.media-amazon.com/images/I/81nC5B%2B1PGL._AC_SL1500_.jpg",
  },
  {
    title: "Forrest Gump",
    year: 1994,
    category: "drama",
    poster: "https://m.media-amazon.com/images/I/61+9rU8aOEL._AC_SL1024_.jpg",
  },
  {
    title: "Oppenheimer",
    year: 2023,
    category: "upcoming",
    poster: "https://m.media-amazon.com/images/I/71xDtUS2ZRL._AC_SL1500_.jpg",
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

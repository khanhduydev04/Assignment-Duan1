const allStories = [
  {
    id: 0,
    author: "Cục Pepsi",
    imageUrl: "./Public/images/avt.jpg",
  },

  {
    id: 1,
    author: "Cục Nhỏ",
    imageUrl: "./Public/images/avt.jpg",
  },

  {
    id: 2,
    author: "Emma Smith",
    imageUrl: "./Public/images/avt.jpg",
  },

  {
    id: 3,
    author: "Cục Pepsi",
    imageUrl: "./Public/images/avt.jpg",
  },

  {
    id: 4,
    author: "Cục Nhỏ",
    imageUrl: "./Public/images/avt.jpg",
  },

  {
    id: 5,
    author: "Cục Bông",
    imageUrl: "./Public/images/avt.jpg",
  },

  {
    id: 6,
    author: "Cục Pepsi",
    imageUrl: "./Public/images/avt.jpg",
  },

  {
    id: 7,
    author: "Cục Nhỏ",
    imageUrl: "./Public/images/avt.jpg",
  },

  {
    id: 8,
    author: "Cục Bông",
    imageUrl: "./Public/images/avt.jpg",
  },
];

const stories = document.querySelector(".stories");
const storiesFullView = document.querySelector(".stories-full-view");
const closeBtn = document.querySelector(".close-btn");
const storyImageFull = document.querySelector(".stories-full-view .story img");
const storyAuthorFull = document.querySelector(
  ".stories-full-view .story .author"
);
const nextBtn = document.querySelector(".stories-container .next-btn");
const previousBtn = document.querySelector(".stories-container .previous-btn");
const storiesContent = document.querySelector(".stories-container .content");
const nextBtnFull = document.querySelector(".stories-full-view .next-btn");
const previousBtnFull = document.querySelector(
  ".stories-full-view .previous-btn"
);

let currentActive = 0;

const createStories = () => {
  allStories.forEach((s, i) => {
    const story = document.createElement("div");
    story.classList.add("story");
    const img = document.createElement("img");
    img.src = s.imageUrl;
    const author = document.createElement("div");
    author.classList.add("author");
    author.innerHTML = s.author;

    story.appendChild(img);
    story.appendChild(author);

    stories.appendChild(story);

    story.addEventListener("click", () => {
      showFullView(i);
    });
  });
};

createStories();

const showFullView = (index) => {
  currentActive = index;
  updateFullView();
  storiesFullView.classList.add("active");
};

closeBtn.addEventListener("click", () => {
  storiesFullView.classList.remove("active");
});

const updateFullView = () => {
  storyImageFull.src = allStories[currentActive].imageUrl;
  storyAuthorFull.innerHTML = allStories[currentActive].author;
};

nextBtn.addEventListener("click", () => {
  storiesContent.scrollLeft += 300;
});

previousBtn.addEventListener("click", () => {
  storiesContent.scrollLeft -= 300;
});

storiesContent.addEventListener("scroll", () => {
  if (storiesContent.scrollLeft <= 24) {
    previousBtn.classList.remove("active");
  } else {
    previousBtn.classList.add("active");
  }

  let maxScrollValue =
    storiesContent.scrollWidth - storiesContent.clientWidth - 24;

  if (storiesContent.scrollLeft >= maxScrollValue) {
    nextBtn.classList.remove("active");
  } else {
    nextBtn.classList.add("active");
  }
});

nextBtnFull.addEventListener("click", () => {
  if (currentActive >= allStories.length - 1) {
    return;
  }
  currentActive++;
  updateFullView();
});

previousBtnFull.addEventListener("click", () => {
  if (currentActive <= 0) {
    return;
  }
  currentActive--;
  updateFullView();
});


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


const showFullView = (event) => {
  const selectedStory = event.currentTarget;
  const imageUrl = selectedStory.querySelector('img').src;
  const author = selectedStory.querySelector('.author').textContent;
  const avatarSrc = selectedStory.querySelector('.avatar_story').src;

  storyImageFull.src = imageUrl;
  storyAuthorFull.innerHTML = author;
  storiesFullView.classList.add("active");

  const avatarStoryView = document.querySelector('.avatar_story_view');
  const deleteStory = document.querySelector('.delete_story');

  // Hiển thị avatar_story_view và giá trị của delete_id_story trong stories-full-view
  avatarStoryView.src = avatarSrc;
};


//close view full story
closeBtn.addEventListener("click", () => {
  storiesFullView.classList.remove("active");
});

// chuyển slider story
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


let currentActive = 0;
// Trong phần khai báo biến
const fullViewContent = document.querySelector('.stories-full-view .content .story');

const updateFullView = () => {
  const selectedStory = document.querySelectorAll('.stories .story')[currentActive];
  const imageUrl = selectedStory.querySelector('img').src;
  const author = selectedStory.querySelector('.author').textContent;
  const avatar = selectedStory.querySelector('.avatar_story').src;
  
  storyImageFull.src = imageUrl;
  storyAuthorFull.innerHTML = author;
  avatarStoryView.src = avatar;

  // Cập nhật slider cho chi tiết story
  fullViewContent.scrollTo({
    left: currentActive * fullViewContent.offsetWidth,
    behavior: 'smooth'
  });
}

// Gán sự kiện click cho nút next trong chi tiết story
nextBtnFull.addEventListener('click', () => {
  const totalStories = document.querySelectorAll('.story').length;
  if (currentActive >= totalStories - 1) {
    return;
  }
  currentActive++;
  updateFullView();
});

// Gán sự kiện click cho nút previous trong chi tiết story
previousBtnFull.addEventListener('click', () => {
  if (currentActive <= 0) {
    return;
  }
  currentActive--;
  updateFullView();
});

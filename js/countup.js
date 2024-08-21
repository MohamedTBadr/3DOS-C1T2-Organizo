const counts = document.querySelectorAll(".count");
const speed = 397;
counts.forEach((count) => {
  function upDate() {
    const target = Number(count.getAttribute("data-target"));
    const counter = Number(count.innerText);
    const inc = target / speed;
    if (counter < target) {
      count.innerText = Math.floor(inc + counter);
      setTimeout(upDate, 5);
    } else {
      count.innerText = target;
    }
  }
  upDate();
});

const counts2 = document.querySelectorAll(".count2");
const speed2 = 397;
counts2.forEach((count2) => {
  function upDate() {
    const target = Number(count2.getAttribute("data-target"));
    const counter = Number(count2.innerText);
    const inc = target / speed;
    if (counter < target) {
      count2.innerText = Math.floor(inc + counter);
      setTimeout(upDate, 5);
    } else {
      count2.innerText = target;
    }
  }
  upDate();
});

const counts3 = document.querySelectorAll(".count3");
const speed3 = 397;
counts3.forEach((count3) => {
  function upDate() {
    const target = Number(count3.getAttribute("data-target"));
    const counter = Number(count3.innerText);
    const inc = target / speed;
    if (counter < target) {
      count3.innerText = Math.floor(inc + counter);
      setTimeout(upDate, 5);
    } else {
      count3.innerText = target;
    }
  }
  upDate();
});


let second = 0;

let timer = null;

const wave = document.getElementById("wave");

const timerText = document.getElementById("recordTime");

const dot = document.querySelector(".dot");

function startVoiceUI() {
  second = 0;

  timerText.innerHTML = "00:00";

  wave.classList.add("active");

  dot.classList.add("recording");

  clearInterval(timer);

  timer = setInterval(() => {
    second++;

    const m = String(Math.floor(second / 60)).padStart(2, "0");

    const s = String(second % 60).padStart(2, "0");

    timerText.innerHTML = `${m}:${s}`;
  }, 1000);
}

function stopVoiceUI() {
  clearInterval(timer);

  wave.classList.remove("active");

  dot.classList.remove("recording");
}

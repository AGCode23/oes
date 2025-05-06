const modalContainer = document.getElementById("modal");
const openBtn = document.querySelectorAll(".openModalBtn");
const closeBtn = document.getElementById("closeModalBtn");
const takeExamBtn = document.getElementById("modal-submit-button");
const durationExam = document.getElementById("modal-duration");

openBtn.forEach((open) => {
  open.addEventListener("click", () => {
    const examId = open.dataset.examId;
    const examDuration = open.dataset.examDuration;
    takeExamBtn.setAttribute("value", examId);
    durationExam.textContent = examDuration + " minutes.";
    modalContainer.classList.remove("hiding");
    modalContainer.classList.add("show");
  });
});

closeBtn.addEventListener("click", () => {
  modalContainer.classList.add("hiding");
  modalContainer.addEventListener(
    "animationend",
    () => {
      modalContainer.classList.remove("show");
      modalContainer.classList.remove("hiding");
    },
    { once: true }
  );
});

window.addEventListener("click", (e) => {
  if (e.target === modalContainer) closeBtn.click();
});

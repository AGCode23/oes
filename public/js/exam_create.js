const examType = document.getElementById("exam-type");
const contentDiv = document.querySelectorAll(".exam-create__section .hidden");
const addQuestion = document.querySelector(".exam-create__add-question");
const examForm = document.getElementById("exam-create__exam-form");
let selectedQuestionType = "";

examType.addEventListener("change", handleDivContent);
addQuestion.addEventListener("click", handleAddQuestion);
examForm.addEventListener("submit", handleSubmitExam);

function handleDivContent() {
  const examButtonDiv = document.querySelector(".exam-create__buttons");

  contentDiv.forEach((div) => {
    const questionDivs = div.querySelectorAll("div[class^='exam-create__']");
    questionDivs.forEach((questionDiv, index) => {
      if (index !== 0) questionDiv.remove();
    });

    div.style.display = "none";
  });

  selectedQuestionType = examType.value;

  if (selectedQuestionType) {
    const selectedDiv = document.getElementById(
      `exam-create__${selectedQuestionType}-container`
    );
    const examSubmitButton = document.createElement("button");
    const examSubmitButtonDiv = document.querySelector(
      ".exam-create__submit-exam"
    );

    if (!examSubmitButtonDiv) {
      examSubmitButton.classList.add("exam-create__submit-exam");
      examSubmitButton.name = "submit-exam";
      examSubmitButton.type = "submit";
      examSubmitButton.textContent = "Save Exam";
      examButtonDiv.appendChild(examSubmitButton);
    }

    if (selectedDiv) selectedDiv.style.display = "flex";
  } else {
    const examSubmitButton = document.querySelector(
      ".exam-create__submit-exam"
    );

    examSubmitButton.remove();
  }
}

function handleAddQuestion() {
  if (!selectedQuestionType) {
    console.error("Please select a question type before adding questions!");
    return;
  }

  const questionContainer = document.getElementById(
    `exam-create__${selectedQuestionType}-container`
  );

  const questionCount = questionContainer.children.length + 1;
  const questionDiv = document.createElement("div");
  questionDiv.classList.add(`exam-create__${selectedQuestionType}`);

  const templates = {
    multiple_choice: `
        <p class="exam-create__question-count">${questionCount}</p>
        <input class="mc-question" type="text" name="exam-create__mc-question-${questionCount}" placeholder="Question">
        <input class="mc-option" type="text" name="exam-create__mc-option-a-${questionCount}" placeholder="Option A">
        <input class="mc-option" type="text" name="exam-create__mc-option-b-${questionCount}" placeholder="Option B">
        <input class="mc-option" type="text" name="exam-create__mc-option-c-${questionCount}" placeholder="Option C">
        <input class="mc-option" type="text" name="exam-create__mc-option-d-${questionCount}" placeholder="Option D">
        <input class="mc-answer" type="text" name="exam-create__mc-answer-${questionCount}" placeholder="Answer">
        `,
    true_false: `
        <p class="exam-create__question-count">${questionCount}</p>
        <input class="tf-question" type="text" name="exam-create__tf-question-${questionCount}" placeholder="Question">
        <input class="tf-answer" type="text" name="exam-create__tf-answer-${questionCount}" placeholder="Answer">
        `,
    short_answer: `
        <p class="exam-create__question-count">${questionCount}</p>
        <input type="text" name="exam-create__sa-question-${questionCount}" placeholder="Question">
        `,
    long_answer: `
        <p class="exam-create__question-count">${questionCount}</p>
        <input type="text" name="exam-create__la-question-${questionCount}" placeholder="Question">
        `,
  };

  if (templates[selectedQuestionType]) {
    questionDiv.innerHTML = templates[selectedQuestionType];
    questionContainer.appendChild(questionDiv);
  } else {
    console.error("Error adding questions: Invalid type!");
  }
}

async function handleSubmitExam(e) {
  e.preventDefault();
  const title = document.getElementById("exam-title").value.trim();
  const description = document.getElementById("exam-description").value.trim();
  const duration = parseInt(
    document.getElementById("exam-duration").value.trim(),
    10
  );
  const type = document.getElementById("exam-type").value;

  if (!title || !type || isNaN(duration)) {
    console.error("Please fill in all exam fields.");
    return;
  }

  let questionData = [];
  let activeDiv = Array.from(document.querySelectorAll(".question-divs")).find(
    (div) => {
      const style = window.getComputedStyle(div);
      return style.display !== "none" && div.offsetHeight > 0;
    }
  );

  if (!activeDiv) {
    console.error("No active question type found.");
    return;
  }

  const questionTypeHandlers = {
    "exam-create__multiple_choice-container": () => {
      const questionDivs = activeDiv.querySelectorAll("input.mc-question");
      const optionDivs = activeDiv.querySelectorAll("input.mc-option");
      const answerDivs = activeDiv.querySelectorAll("input.mc-answer");

      questionDivs.forEach((mcQuestion, index) => {
        const question = mcQuestion.value.trim();
        const options = Array.from({ length: 4 }, (_, i) =>
          optionDivs[index * 4 + i].value.trim()
        );
        const answer = answerDivs[index].value.trim();

        questionData.push({ question, options, answer });
      });
    },
    "exam-create__true_false-container": () => {
      const questionDivs = activeDiv.querySelectorAll("input.tf-question");
      const answerDivs = activeDiv.querySelectorAll("input.tf-answer");

      questionDivs.forEach((tfQuestion, index) => {
        questionData.push({
          question: tfQuestion.value.trim(),
          answer: answerDivs[index].value.trim(),
        });
      });
    },

    "exam-create__short_answer-container": () => {
      const questionDivs = activeDiv.querySelectorAll("input[type=text]");
      questionDivs.forEach((saQuestion) => {
        questionData.push({
          question: saQuestion.value.trim(),
        });
      });
    },

    "exam-create__long_answer-container": () => {
      const questionDivs = activeDiv.querySelectorAll("input[type=text]");
      questionDivs.forEach((laQuestion) => {
        questionData.push({
          question: laQuestion.value.trim(),
        });
      });
    },
  };

  const handler = questionTypeHandlers[activeDiv.id];
  if (handler) {
    handler();
  } else {
    console.error("Invalid question type.");
  }

  const examData = JSON.stringify({
    title,
    description,
    duration,
    type,
    questions: questionData,
  });

  try {
    const response = await fetch("/exam/create", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: examData,
    });

    const result = await response.json();
    console.log(result.message);
    // if (response.ok) window.location.reload();
  } catch (error) {
    console.error("Error submitting the exam:", error);
  }
}

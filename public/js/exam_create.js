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
  selectedQuestionType = examType.value;

  contentDiv.forEach((div) => {
    const questionDivs = div.querySelectorAll("div[class^='exam-create__']");
    questionDivs.forEach((questionDiv, index) => {
      if (index !== 0) questionDiv.remove();
    });

    div.style.display = "none";
    const divInput = div.querySelectorAll(".exam-create__question");
    divInput.forEach((input) => {
      input.disabled = true;
    });

    if (
      div.getAttribute("id") ===
      `exam-create__${selectedQuestionType}-container`
    ) {
      div.querySelector(".exam-create__question").disabled = false;
    }
  });

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
        <input class="mc-question exam-create__question" type="text" name="exam-create__mc-question-${questionCount}" placeholder="Question">
        <input class="mc-option" type="text" name="exam-create__mc-option-a-${questionCount}" placeholder="Option A">
        <input class="mc-option" type="text" name="exam-create__mc-option-b-${questionCount}" placeholder="Option B">
        <input class="mc-option" type="text" name="exam-create__mc-option-c-${questionCount}" placeholder="Option C">
        <input class="mc-option" type="text" name="exam-create__mc-option-d-${questionCount}" placeholder="Option D">
        <input class="mc-answer" type="text" name="exam-create__mc-answer-${questionCount}" placeholder="Answer">
        `,
    true_false: `
        <p class="exam-create__question-count">${questionCount}</p>
        <input class="tf-question exam-create__question" type="text" name="exam-create__tf-question-${questionCount}" placeholder="Question">
        <input class="tf-answer" type="text" name="exam-create__tf-answer-${questionCount}" placeholder="Answer">
        `,
    short_answer: `
        <p class="exam-create__question-count">${questionCount}</p>
        <input class="exam-create__question" type="text" name="exam-create__sa-question-${questionCount}" placeholder="Question">
        `,
    long_answer: `
        <p class="exam-create__question-count">${questionCount}</p>
        <input class="exam-create__question" type="text" name="exam-create__la-question-${questionCount}" placeholder="Question">
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
  const type = document.getElementById("exam-type").value;
  const duration = parseInt(
    document.getElementById("exam-duration").value.trim(),
    10
  );

  if (!title || !type || isNaN(duration)) {
    console.error("Please fill in all exam fields.");
    return;
  }

  // Check if question input have value
  for (let i = 0; i < contentDiv.length; i++) {
    let questions = [];
    const div = contentDiv[i];

    if (div.style.display !== "none") {
      const questionInputs = div.querySelectorAll(".exam-create__question");

      questionInputs.forEach((input) => {
        questions.push(input.value);
      });
      const isValidQuestion = checkChunks(questions, 1);
      if (!isValidQuestion) {
        console.error("Question field is required!");
        return;
      }
    }
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

  // Check if the options have at least 1 option
  if (selectedQuestionType === "multiple_choice") {
    const mcOptionInputs = document.querySelectorAll(".mc-option");
    let options = [];

    mcOptionInputs.forEach((input) => {
      options.push(input.value);
    });
    const isValidOption = checkChunks(options, 4);

    if (!isValidOption) {
      console.error("Must have at least 1 option!");
      return;
    }
  }

  // Handlers for every question type
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

  // Send data to backend (PHP)
  try {
    const response = await fetch("/exam/create", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: examData,
    });

    const result = await response.json();
    if (response.ok) window.location.reload();
  } catch (error) {
    console.error("Error submitting the exam:", error);
  }
}

// Helper functions

function checkChunks(arr, count = 4) {
  for (let i = 0; i < arr.length; i += count) {
    const chunk = arr.slice(i, i + count);
    const hasTruthy = chunk.some((item) => item); // `some` returns true if at least one item is truthy

    if (!hasTruthy) {
      return false;
    }
  }
  return true;
}

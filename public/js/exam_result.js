document.addEventListener("DOMContentLoaded", handleResultPage);

function handleResultPage() {
  const subjectDropdown = document.getElementById("exam_result__subject-code");
  const yearCheckboxes = document.querySelectorAll(".year-checkbox");

  function getSelectedFilters() {
    const selectedSubject = subjectDropdown.value;
    const selectedYears = Array.from(yearCheckboxes)
      .filter((checkbox) => checkbox.checked)
      .map((checkbox) => checkbox.value);

    return { subject: selectedSubject, years: selectedYears };
  }

  function fetchFilteredResults() {
    const filter = getSelectedFilters();

    fetch(
      `/exam/result?subject=${filter.subject}&years=${filter.years.join(",")}`
    )
      .then((response) => response.json())
      .then((data) => {
        updateResults(data);
      })
      .catch((error) =>
        console.error("Error fetching filtered results:", error)
      );
  }

  function updateResults(data) {
    const titleContainer = document.querySelector(
      ".exam_result__title-container ul"
    );
    const descriptionContainer = document.querySelector(
      ".exam_result__description-container div"
    );
    const subjectCodeContainer = document.querySelector(
      ".exam_result__subject-code-container div"
    );
    const completionDateContainer = document.querySelector(
      ".exam_result__completion-date-container div"
    );
    const percentageContainer = document.querySelector(
      ".exam_result__percentage-container div"
    );
    const remarksContainer = document.querySelector(
      ".exam_result__remarks-container div"
    );

    titleContainer.innerHTML = "";
    descriptionContainer.innerHTML = "";
    subjectCodeContainer.innerHTML = "";
    completionDateContainer.innerHTML = "";
    percentageContainer.innerHTML = "";
    remarksContainer.innerHTML = "";

    data.forEach((result) => {
      titleContainer.innerHTML += `<li>${result.title}</li>`;
      descriptionContainer.innerHTML += `<p>${result.description}</p>`;
      subjectCodeContainer.innerHTML += `<p>${result.class_code}</p>`;
      completionDateContainer.innerHTML += `<p>${
        result.status === "pending" ? "-" : result.submitted_at
      }
      </p>`;
      percentageContainer.innerHTML += `<p>${result.score}</p>`;
      remarksContainer.innerHTML += `<p>${result.status}</p>`;
    });
  }

  subjectDropdown.addEventListener("change", fetchFilteredResults);
  yearCheckboxes.forEach((checkbox) =>
    checkbox.addEventListener("change", fetchFilteredResults)
  );
}

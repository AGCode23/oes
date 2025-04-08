document.addEventListener("DOMContentLoaded", handleResultPage);

function handleResultPage() {
  const subjectDropdown = document.getElementById("exam_result__subject-code");
  const yearCheckboxes = document.querySelectorAll(".year-checkbox");

  function getSelectedYears() {
    return Array.from(yearCheckboxes)
      .filter((checkbox) => checkbox.checked)
      .map((checkbox) => checkbox.value);
  }

  function getSelectedSubject() {
    return subjectDropdown.value;
  }

  function fetchDropdownAndResults() {
    const selectedYears = getSelectedYears();

    fetch(`/exam/result?subject=&years=${selectedYears.join(",")}`)
      .then((response) => response.json())
      .then((data) => {
        updateDropdown(data);

        let subject = getSelectedSubject();
        const validSubjects = Array.from(subjectDropdown.options).map(
          (option) => option.value
        );

        if (!validSubjects.includes(subject)) {
          subject = "";
          subjectDropdown.value = "";
        }

        fetch(
          `/exam/result?subject=${subject}&years=${selectedYears.join(",")}`
        )
          .then((res) => res.json())
          .then((data) => updateResults(data))
          .catch((err) => console.error("Error fetching final results:", err));
      })
      .catch((error) =>
        console.error("Error fetching filtered years and dropdown:", error)
      );
  }

  function fetchFilteredResults() {
    const filter = {
      subject: getSelectedSubject(),
      years: getSelectedYears(),
    };

    fetch(
      `/exam/result?subject=${filter.subject}&years=${filter.years.join(",")}`
    )
      .then((response) => response.json())
      .then((data) => {
        updateResults(data);
        updateDropdown(data);
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

    data.filteredResult.forEach((result) => {
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

  function updateDropdown(data) {
    const currentSelectedValue = subjectDropdown.value;

    subjectDropdown.innerHTML = '<option value="">Subject Code</option>';

    const subjectDropdownOptions = [];
    data.filteredYear.forEach((result) => {
      subjectDropdownOptions.push(result.class_code);
    });

    const uniqueSubjectOptions = [...new Set(subjectDropdownOptions)];

    uniqueSubjectOptions.forEach((subject) => {
      subjectDropdown.insertAdjacentHTML(
        "beforeend",
        `<option value="${subject}">${subject}</option>`
      );
    });

    if (uniqueSubjectOptions.includes(currentSelectedValue)) {
      subjectDropdown.value = currentSelectedValue;
    } else {
      subjectDropdown.value = "";
    }
  }

  subjectDropdown.addEventListener("change", fetchFilteredResults);
  yearCheckboxes.forEach((checkbox) =>
    checkbox.addEventListener("change", fetchDropdownAndResults)
  );
}

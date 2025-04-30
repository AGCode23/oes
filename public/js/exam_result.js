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
    const tableContent = document.getElementById(
      "exam_result__table-content-container"
    );

    tableContent.innerHTML = "";

    data.filteredResult.forEach((result, index) => {
      let resultDetails = "";
      let capitalizedStatus =
        result.status.charAt(0).toUpperCase() + result.status.slice(1);

      // Use if-else to handle the conditional logic
      if (result.status === "pending") {
        resultDetails =
          '<p style="width: 150px;">-</p><p style="width: 85px;">-</p><p style="width: 65px;">' +
          capitalizedStatus +
          "</p>";
      } else {
        if (result.status === "passed") {
          resultDetails =
            '<p style="width: 150px;">' +
            result.submitted_at +
            '</p><p class="exam_result__passed" style="width: 85px;">' +
            result.score +
            '</p><p class="exam_result__passed" style="width: 65px;">' +
            capitalizedStatus +
            "</p>";
        } else {
          resultDetails =
            '<p style="width: 150px;">' +
            result.submitted_at +
            '</p><p class="exam_result__failed" style="width: 85px;">' +
            result.score +
            '</p><p class="exam_result__failed" style="width: 65px;">' +
            capitalizedStatus +
            "</p>";
        }
      }

      // Add the content to tableContent
      tableContent.innerHTML += `<div class="exam_result__table-content">
    <p style="width: 180px;">${index + 1}. ${result.title}</p>
    <p style="width: 110px;">${result.class_code}</p>
    ${resultDetails}
  </div>`;
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

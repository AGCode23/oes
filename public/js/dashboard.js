document.addEventListener("DOMContentLoaded", async () => {
  try {
    const greetingsElement = document.getElementById("dashboard__greetings");
    const dashboardPieChart = document.querySelector(".dashboard__pie-chart");
    const pendingExamContainer = document.querySelector(
      ".dashboard__table-content"
    );

    const greeting = getGreeting();
    const data = await fetchDashboardData();
    const firstName = extractFirstName(data.firstName);
    const { passedPercentage, failedPercentage } = calculateExamPercentages(
      data.examStatus
    );
    const pendingExams = data.pendingExams;

    updateGreeting(greetingsElement, greeting, firstName);
    renderExamResultsChart(
      dashboardPieChart,
      passedPercentage,
      failedPercentage
    );
    renderPendingExams(pendingExamContainer, pendingExams);
  } catch (error) {
    console.error("Error loading dashboard:", error);
  }
});

// Get greeting based on current hour
function getGreeting() {
  const hour = new Date().getHours();
  if (hour >= 5 && hour < 12) return "Good Morning";
  if (hour >= 12 && hour < 18) return "Good Afternoon";
  return "Good Evening";
}

// Fetch data from the backend
async function fetchDashboardData() {
  const response = await fetch("/user/dashboard_data");
  if (!response.ok) throw new Error("Failed to fetch dashboard data");
  return await response.json();
}

// Extract the first name from a full name
function extractFirstName(fullName) {
  return fullName?.split(" ")[0] || "Guest";
}

// Calculate passed/failed percentages
function calculateExamPercentages(examStatus = []) {
  let passed = 0;
  let failed = 0;

  examStatus.forEach((exam) => {
    if (exam.status === "passed") passed++;
    if (exam.status === "failed") failed++;
  });

  const total = passed + failed || 1; // avoid division by zero
  return {
    passedPercentage: (passed / total) * 100,
    failedPercentage: (failed / total) * 100,
  };
}

// Update greeting message
function updateGreeting(element, greeting, firstName) {
  element.textContent = `${greeting}, ${firstName}!`;
}

// Render the Chart.js doughnut chart
function renderExamResultsChart(container, passed, failed) {
  container.innerHTML = '<canvas id="examResultsChart"></canvas>';
  const ctx = document.getElementById("examResultsChart").getContext("2d");

  new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: ["Passed", "Failed"],
      datasets: [
        {
          data: [passed, failed],
          backgroundColor: ["#333333", "#FFFFFF"],
          hoverBackgroundColor: ["#4D4D4D", "#F2F2F2"],
          borderWidth: 1,
          hoverOffset: 20,
        },
      ],
    },
    options: {
      cutout: "60%",
      layout: { padding: 30 },
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: "left",
          align: "start",
          labels: {
            boxWidth: 30,
            font: { size: 14 },
          },
        },
        tooltip: {
          callbacks: {
            label: (tooltipItem) => {
              const label = tooltipItem.label;
              const value = tooltipItem.raw;
              return `${label}: ${value.toFixed(2)}%`;
            },
          },
        },
      },
    },
  });
}

function renderPendingExams(container, exams) {
  container.innerHTML = "";
  exams.forEach((exam) => {
    container.innerHTML += `<div class="dashboard__table-content-data">
        <p style="width: 270px;">${exam.title}</p>
        <p style="width: 400px;">${exam.description}</p>
        <p style="width: 200px;">${formatDateTo12Hour(exam.due_date, 8)}</p>
      </div>`;
  });
}

function formatDateTo12Hour(inputDateTime, timezoneOffsetHours = 0) {
  const date = new Date(inputDateTime.replace(" ", "T")); // ISO-safe

  // Apply timezone offset (e.g., +8 for GMT+8)
  date.setHours(date.getHours() + timezoneOffsetHours);

  const padZero = (num) => String(num).padStart(2, "0");

  const year = date.getFullYear();
  const month = padZero(date.getMonth() + 1);
  const day = padZero(date.getDate());

  let hour = date.getHours();
  const minute = padZero(date.getMinutes());
  const ampm = hour >= 12 ? "PM" : "AM";

  hour = hour % 12;
  hour = hour === 0 ? 12 : hour;
  hour = padZero(hour);

  return `${month}-${day}-${year} ${hour}:${minute} ${ampm}`;
}

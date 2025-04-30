const greetingsElement = document.getElementById("dashboard__greetings");

document.addEventListener("DOMContentLoaded", async () => {
  let greeting = "Good Morning";
  const getCurrentHour = new Date().getHours();

  if (getCurrentHour >= 5 && getCurrentHour < 12) {
    greeting = "Good Morning";
  } else if (getCurrentHour >= 12 && getCurrentHour < 18) {
    greeting = "Good Afternoon";
  } else {
    greeting = "Good Evening";
  }

  await fetch("/user/first_name")
    .then((response) => response.json())
    .then((data) => {
      const firstName = data.firstName.split(" ")[0];
      greetingsElement.textContent = data.firstName
        ? `${greeting}, ${firstName}!`
        : `${greeting}, Guest!`;
    })
    .catch((error) => console.error(error));
});

document.addEventListener("DOMContentLoaded", () => {
  const passedPercentage = 75; // Placeholder
  const failedPercentage = 100 - passedPercentage; // Placeholder

  const ctx = document.getElementById("examResultsChart").getContext("2d");

  // Create the doughnut chart using Chart.js
  const examResultsChart = new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: ["Passed", "Failed"], // Labels for each segment
      datasets: [
        {
          data: [passedPercentage, failedPercentage], // Data array
          backgroundColor: ["#333333", "#FFFFFF"],
          hoverBackgroundColor: ["#4D4D4D", "#F2F2F2"],
          borderWidth: 1,
          hoverOffset: 20,
        },
      ],
    },
    options: {
      cutout: "60%",
      layout: {
        padding: 30,
      },
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: "left",
          align: "start",
          labels: {
            boxWidth: 30,
            font: {
              size: 14,
            },
          },
        },
        tooltip: {
          callbacks: {
            label: function (tooltipItem) {
              const label = tooltipItem.label;
              const value = tooltipItem.raw;
              return label + ": " + value.toFixed(2) + "%"; // Display percentage in tooltips
            },
          },
        },
      },
    },
  });
});

// Set default font family and color to mimic Bootstrap's styling
Chart.defaults.font.family = '-apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
Chart.defaults.color = '#292b2c';

const barBackgroundColor = "rgba(2, 117, 216, 1)";
const barBorderColor = "rgba(2, 117, 216, 1)";

const ctx = document.getElementById("myBarChart").getContext("2d");
const myBarChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ["January", "February", "March", "April", "May", "June"],
    datasets: [{
      label: "Revenue",
      backgroundColor: barBackgroundColor,
      borderColor: barBorderColor,
      borderWidth: 1,
      data: [4215, 5312, 6251, 7841, 9821, 14984]
    }]
  },
  options: {
    responsive: true, 
    maintainAspectRatio: false, 
    scales: {
      x: {
        grid: {
          display: false 
        },
        ticks: {
          maxTicksLimit: 6 
        }
      },
      y: {
        ticks: {
          min: 0,
          max: 15000,
          stepSize: 3000, 
          maxTicksLimit: 5
        },
        grid: {
          display: true
        }
      }
    },
    plugins: {
      legend: {
        display: false 
      }
    }
  }
});

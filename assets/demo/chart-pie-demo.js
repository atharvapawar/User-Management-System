// Set default font family and color to mimic Bootstrap's styling
Chart.defaults.font.family = '-apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
Chart.defaults.color = '#292b2c';

// Pie Chart Configuration
const ctx = document.getElementById("myPieChart").getContext("2d");
const myPieChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: ["Blue", "Red", "Yellow", "Green"],
    datasets: [{
      data: [12.21, 15.58, 11.25, 8.32],
      backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745'],
      hoverBackgroundColor: ['#0056b3', '#b02a37', '#e0a800', '#1e7e34']
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: true,
        position: 'top', 
        labels: {
          boxWidth: 20,
          padding: 15
        }
      },
      tooltip: {
        callbacks: {
          label: function(tooltipItem) {
            const value = tooltipItem.raw;
            return `${tooltipItem.label}: ${value}%`; 
          }
        }
      }
    }
  }
});

Chart.defaults.font.family =
  '-apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
Chart.defaults.color = "#292b2c";

const chartBackgroundColor = "rgba(2, 117, 216, 0.2)";
const chartBorderColor = "rgba(2, 117, 216, 1)";
const pointColor = "rgba(2, 117, 216, 1)";
const pointBorderColor = "rgba(255, 255, 255, 0.8)";

const ctx = document.getElementById("myAreaChart");
const myLineChart = new Chart(ctx, {
  type: "line",
  data: {
    labels: [
      "Mar 1",
      "Mar 2",
      "Mar 3",
      "Mar 4",
      "Mar 5",
      "Mar 6",
      "Mar 7",
      "Mar 8",
      "Mar 9",
      "Mar 10",
      "Mar 11",
      "Mar 12",
      "Mar 13",
    ],
    datasets: [
      {
        label: "Sessions",
        tension: 0.3, 
        backgroundColor: chartBackgroundColor,
        borderColor: chartBorderColor,
        pointRadius: 5,
        pointBackgroundColor: pointColor,
        pointBorderColor: pointBorderColor,
        pointHoverRadius: 7,
        pointHoverBackgroundColor: chartBorderColor,
        pointHitRadius: 30,
        pointBorderWidth: 2,
        data: [
          10000, 30162, 26263, 18394, 18287, 28682, 31274, 33259, 25849, 24159,
          32651, 31984, 38451,
        ],
      },
    ],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false, 
    scales: {
      x: {

        type: "time",
        time: {
          unit: "day",
        },
        grid: {
          display: false,
        },
        ticks: {
          maxTicksLimit: 7,
        },
      },
      y: {
        // Updated from 'yAxes'
        ticks: {
          min: 0,
          max: 40000,
          stepSize: 10000,
          maxTicksLimit: 5,
        },
        grid: {
          color: "rgba(0, 0, 0, .125)",
        },
      },
    },
    plugins: {
      legend: {
        display: false,
      },
    },
  },
});

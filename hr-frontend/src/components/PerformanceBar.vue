<template>
  <div>
    <Bar :data="chartData" :options="chartOptions" />
  </div>
</template>

<script>
import { Bar } from 'vue-chartjs'
import {
  Chart,
  BarElement,
  CategoryScale,
  LinearScale,
  Tooltip,
  Legend
} from 'chart.js'

Chart.register(BarElement, CategoryScale, LinearScale, Tooltip, Legend)

export default {
  name: 'PerformanceBar',
  components: { Bar },
  props: {
    reviews: Array
  },
  computed: {
    chartData() {
      return {
        labels: this.reviews.map(r => r.name),
        datasets: [
          {
            label: 'Punctuality',
            data: this.reviews.map(r => r.punctuality),
            backgroundColor: this.reviews.map(r => this.getBarColor(r.punctuality)),
            borderColor: '#333',
            borderWidth: 1
          },
          {
            label: 'Task Completion',
            data: this.reviews.map(r => r.taskCompletion),
            backgroundColor: this.reviews.map(r => this.getBarColor(r.taskCompletion)),
            borderColor: '#333',
            borderWidth: 1
          },
          {
            label: 'Teamwork',
            data: this.reviews.map(r => r.teamwork),
            backgroundColor: this.reviews.map(r => this.getBarColor(r.teamwork)),
            borderColor: '#333',
            borderWidth: 1
          }
        ]
      }
    },
    chartOptions() {
      return {
        responsive: true,
        plugins: {
          legend: { position: 'top' },
          title: { display: true, text: 'Employee Performance Bar Chart' }
        },
        scales: {
          y: {
            min: 0,
            max: 10,
            ticks: { stepSize: 1 }
          }
        }
      }
    }
  },
  methods: {
    getBarColor(score) {
      if (score < 6) return '#ff4d4d';      // red
      if (score < 7) return '#ffa500';      // orange
      if (score < 8) return '#ffe066';      // yellow
      return '#4caf50';                     // green
    }
  }
}
</script>
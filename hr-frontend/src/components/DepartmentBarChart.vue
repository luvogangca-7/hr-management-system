<template>
  <div style="width:100%;max-width:400px;">
    <Bar :data="chartData" :options="chartOptions" />
  </div>
</template>

<script>
import { Bar } from 'vue-chartjs'
import { Chart, BarElement, CategoryScale, LinearScale, Tooltip, Legend } from 'chart.js'

Chart.register(BarElement, CategoryScale, LinearScale, Tooltip, Legend)

export default {
  name: 'DepartmentBarChart',
  components: { Bar },
  props: {
    departments: Array
  },
  computed: {
    chartData() {
      return {
        labels: this.departments.map(d => d.name),
        datasets: [
          {
            label: 'Employees',
            data: this.departments.map(d => d.count),
            backgroundColor: '#af2727'
          }
        ]
      }
    },
    chartOptions() {
      return {
        responsive: true,
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: { beginAtZero: true, ticks: { stepSize: 1 } }
        }
      }
    }
  }
}
</script>
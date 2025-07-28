<template>
  <div class="page-wrapper">
    <h1>Employee Performance Reviews</h1>
    <p>Check how are your employees performing and identify their abilities.</p>
    <div class="main-page">
      <button @click="showChart = !showChart" class="tabChart" style="margin-bottom: 1rem;">
        {{ showChart ? 'Show Table' : 'Show Chart' }}
      </button>

      <performance-bar v-if="showChart" :reviews="reviews" />

      <div v-else class="table-responsive">
        <table class="table table-striped-columns">
          <thead>
            <tr>
              <th>Employee</th>
              <th>Punctuality</th>
              <th>Task Completion</th>
              <th>Teamwork</th>
              <th>Comments</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="review in reviews" :key="review.id">
              <td>{{ review.name }}</td>
              <td :style="{ color: getScoreColor(review.punctuality), backgroundColor: getBackgroundColor(review.punctuality)}">{{ review.punctuality }}/10</td>
              <td :style="{ color: getScoreColor(review.taskCompletion), backgroundColor: getBackgroundColor(review.taskCompletion)}">{{ review.taskCompletion }}/10</td>
              <td :style="{ color: getScoreColor(review.teamwork), backgroundColor: getBackgroundColor(review.teamwork)}">{{ review.teamwork }}/10</td>
              <td>{{ review.comments }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import PerformanceBar from '@/components/PerformanceBar.vue';
import axios from 'axios';

export default {
  name: "PerformanceReview",
  components: { PerformanceBar },
  data() {
  return {
    showChart: false,
    reviews: []
  }
},
mounted() {
  this.fetchPerformanceReviews();
},
methods: {
  fetchPerformanceReviews() {
    axios.get('http://localhost/hr-management-system/hr-backend/performanceReview.php')
      .then(response => {
        this.reviews = response.data;
      })
      .catch(error => {
        console.error("Error fetching reviews:", error);
      });
  },
  getScoreColor(score) {
    if (score < 6) return 'red';
    if (score < 7) return 'orange';
    if (score < 8) return 'gold';
    return 'green';
  },
  getBackgroundColor(score) {
    if (score < 6) return '#ffcccc';
    if (score < 7) return '#ffe5b4';
    if (score < 8) return '#fff9cc';
    return '#ccffcc';
  }
}

}
</script>

<style scoped>
.container {
  margin: auto;
}
table {
  font-size: 0.95rem;
}

.tabChart {
  background-color: #af2727;
  color: white;
  padding: 8px;
  border: none;
  border-radius: 6px;
  width: fit-content;
}
</style>
<template>
  <div class="page-wrapper">
    <h1>Employee Performance Reviews</h1>
    <p>Check how are your employees performing and identify their abilities.</p>
    <div class="main-page">
      <div class="buttons">
        <button @click="showChart = !showChart" class="tabChart" style="margin-bottom: 1rem;">
        {{ showChart ? 'Show Table' : 'Show Chart' }}
      </button>
      <button @click="addPerf = !addPerf" class="tabChart" style="margin-bottom: 1rem;">
        {{ addPerf ? 'Cancel' : 'Add Review' }}
      </button>
      </div>
      

      <!-- Add Review Form -->
<form @submit.prevent="submitReview" class="review-form" v-if="addPerf">
  <h3>Add Performance Review</h3>

  <label>Employee:</label>
  <select v-model="newReview.employeeId" required>
    <option disabled value="">Select Employee</option>
    <option v-for="emp in employees" :key="emp.employee_id" :value="emp.employee_id">
      {{ emp.employee_name }}
    </option>
  </select>

  <label>Punctuality (1–10):</label>
  <input type="number" v-model.number="newReview.punctuality" min="1" max="10" required />

  <label>Task Completion (1–10):</label>
  <input type="number" v-model.number="newReview.taskCompletion" min="1" max="10" required />

  <label>Teamwork (1–10):</label>
  <input type="number" v-model.number="newReview.teamwork" min="1" max="10" required />

  <label>Comments:</label>
  <textarea v-model="newReview.comments" placeholder="Write a comment..."></textarea>

  <button type="submit">Submit Review</button>
</form>


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
    reviews: [],
    employees: [],
    newReview: {
      employeeId: '',
      punctuality: 5,
      taskCompletion: 5,
      teamwork: 5,
      comments: ''
    },
    addPerf: false
  }
},
mounted() {
  this.fetchPerformanceReviews();
  this.fetchEmployees();
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
  fetchEmployees() {
    axios.get('http://localhost/hr-management-system/hr-backend/getEmployees.php')
      .then(response => {
        this.employees = response.data;
      })
      .catch(error => {
        console.error("Error fetching employees:", error);
      });
  },
  submitReview() {
    axios.post('http://localhost/hr-management-system/hr-backend/addPerformanceReview.php', this.newReview)
      .then(response => {
        if (response.data.success) {
          alert('Review added successfully!');
          this.fetchPerformanceReviews(); // reload the updated reviews
          // reset form
          this.newReview = {
            employeeId: '',
            punctuality: 5,
            taskCompletion: 5,
            teamwork: 5,
            comments: ''
          };

          this.addPerf = false;
        } else {
          alert('Failed to add review: ' + response.data.message);
        }
      })
      .catch(error => {
        console.error('Error submitting review:', error);
        alert('Something went wrong.');
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
.buttons {
  width: 200px;
  display: flex;
  justify-content: space-between;
}
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

.review-form {
  border: 1px solid #ccc;
  padding: 1rem;
  margin-bottom: 1.5rem;
  border-radius: 8px;
  background-color: #f9f9f9;
}
.review-form label {
  display: block;
  margin-top: 0.5rem;
}
.review-form input,
.review-form select,
.review-form textarea {
  width: 100%;
  padding: 0.4rem;
  margin-top: 0.2rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.review-form button {
  margin-top: 1rem;
  background-color: #4caf50;
  color: white;
  padding: 8px 12px;
  border: none;
  border-radius: 4px;
}

</style>
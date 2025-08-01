<template>
  <div class="page-wrapper">
    <h1>Performance Review</h1>
    <div class="main-page" v-if="performance">
      <div :class="['score', getColor(performance.punctuality)]">
        Punctuality: {{ performance.punctuality }}/10
      </div>
      <div :class="['score', getColor(performance.taskCompletion)]">
        Task Completion: {{ performance.taskCompletion }}/10
      </div>
      <div :class="['score', getColor(performance.teamwork)]">
        Teamwork: {{ performance.teamwork }}/10
      </div>

      <div class="comment-box">
        Manager’s Comment: “{{ performance.comments }}”
      </div>

      <div v-if="submitted" class="thankyou">
        ✅ Thank you for your feedback!
      </div>
    </div>

    <div v-else>
      <p style="color:red">{{ error || 'Loading...' }}</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { mapGetters } from 'vuex';

export default {
  name: "MyPerformancePage",
  data() {
    return {
      performance: null,
      loading: true,
      error: null
    };
  },
  computed: {
    ...mapGetters(['employee'])
  },
  methods: {
    async fetchPerformance() {
      const employeeId = this.employee?.employee_id;
      console.log("Current Employee ID:", employeeId);

      if (!employeeId) {
        this.error = "Employee not logged in.";
        this.loading = false;
        return;
      }

      try {
        const response = await axios.get(
          'http://localhost/hr-management-system/hr-backend/getEmployeePerformance.php',
          {
            params: { id: employeeId }
          }
        );

        if (response.data.success) {
          this.performance = response.data.review;
        } else {
          this.error = response.data.message || "No performance data found.";
        }
      } catch (err) {
        console.error("Error fetching performance:", err);
        this.error = "Failed to fetch performance data.";
      } finally {
        this.loading = false;
      }
    },

    getColor(score) {
      if (score >= 8) return "green";
      if (score >= 5) return "orange";
      return "red";
    },
    getFeedback(score) {
      if (score >= 8) return "Excellent";
      if (score >= 5) return "Satisfactory";
      return "Needs Improvement";
    }
  },
  mounted() {
    this.fetchPerformance();
  }
};
</script>
<style scoped>

.container {
  max-width: 700px;
  margin: auto;
  background: white;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
.score {
  padding: 10px;
  margin: 10px 0;
  border-radius: 5px;
  font-weight: bold;
}
.green {
  background-color: #d4f7d4;
  color: #006600;
}
.orange {
  background-color: #fff5cc;
  color: #b36b00;
}
.red {
  background-color: #ffd6d6;
  color: #cc0000;
}
.comment-box {
  background: #f4f4f4;
  padding: 15px;
  border-radius: 5px;
  margin-top: 20px;
  font-style: italic;
}
.feedback-input {
  margin-top: 30px;
}
textarea {
  width: 100%;
  padding: 10px;
  border-radius: 5px;
  border: 1px solid #ccc;
}
button {
  margin-top: 10px;
  padding: 10px 20px;
  background: #af2727;
  color: white;
  border: none;
  border-radius: 5px;
  font-weight: bold;
  cursor: pointer;
}
button:hover {
  background: #990000;
}
.thankyou {
  margin-top: 20px;
  color: green;
}
</style>

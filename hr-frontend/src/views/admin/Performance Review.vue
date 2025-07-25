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

export default {
  name: "PerformanceReview",
  components: { PerformanceBar },
  data() {
    return {
      showChart: false,
      reviews: [
        {
          id: 1,
          name: "Sibongile Nkosi",
          punctuality: 9,
          taskCompletion: 8,
          teamwork: 7,
          comments: "Consistently meets expectations and works well under pressure."
        },
        {
          id: 2,
          name: "Lungile Moyo",
          punctuality: 10,
          taskCompletion: 9,
          teamwork: 9,
          comments: "Outstanding contributor with great team spirit."
        },
        {
          id: 3,
          name: "Thabo Molefe",
          punctuality: 6,
          taskCompletion: 7,
          teamwork: 8,
          comments: "Needs improvement in time management."
        },
        {
          id: 4,
          name: "Keshav Naidoo ",
          punctuality: 8,
          taskCompletion: 7,
          teamwork: 6,
          comments: "Occasionally works in isolation; encouraged to engage more with the team."
        },
        {
          id: 5,
          name: "Zanele Khumalo",
          punctuality: 6,
          taskCompletion: 7,
          teamwork: 9,
          comments: "A reliable team player who supports colleagues and contributes positively to group efforts."
        },
        {
          id: 6,
          name: "Sipho Zulu",
          punctuality: 5,
          taskCompletion: 7,
          teamwork: 7,
          comments:"Lacks initiative; should work on being more self-driven."
        },
        {
          id: 7,
          name: "Naledi Moeketsi",
          punctuality: 5,
          taskCompletion: 7,
          teamwork: 6,
          comments: "Needs to be more proactive in sharing updates and seeking clarification when needed."
        },
        {
          id: 8,
          name: "Farai Gumbo ",
          punctuality: 7,
          taskCompletion: 8,
          teamwork: 9,
          comments: "Communicates clearly and effectively with team members and clients."
        },
        {
          id: 9,
          name: "Karabo Dlamini",
          punctuality: 8,
          taskCompletion: 7,
          teamwork: 8,
          comments: "Meets expectations but occasionally requires supervision to maintain quality."
        },
        {
          id: 10,
          name: "Fatima Patel",
          punctuality: 6,
          taskCompletion: 7,
          teamwork: 9,
          comments: "Consistently delivers high-quality work with attention to detail."
        }
      ]
    }
  },
  methods: {
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
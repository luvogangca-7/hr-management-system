<template>
  <div class="page-wrapper">
    <h1>Performance Review</h1>
      <div class="main-page">


    <div :class="['score', getColor(employee.punctuality)]">
      Punctuality: {{ employee.punctuality }}/10
    </div>
    <div :class="['score', getColor(employee.taskCompletion)]">
      Task Completion: {{ employee.taskCompletion }}/10
    </div>
    <div :class="['score', getColor(employee.teamwork)]">
      Teamwork: {{ employee.teamwork }}/10
    </div>

    <div class="comment-box">
      Manager’s Comment: “{{ employee.comments }}”
    </div>


    <div class="feedback-input">
      <h3>Leave Your Feedback:</h3>
      <textarea v-model="feedback" rows="4" placeholder="Write your feedback..."></textarea>
      <br />
      <button @click="submitFeedback">Submit</button>
    </div>

    <div v-if="submitted" class="thankyou">
      ✅ Thank you for your feedback!
    </div>
  </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      employee: {
        name: "Sibongile Nkosi", 
        punctuality: 9,
        taskCompletion: 8,
        teamwork: 7,
        comments: "Consistently meets expectations and works well under pressure."
      },
      feedback: '',
      submitted: false
    };
  },
  methods: {
    getColor(score) {
      if (score >= 9) return 'green';
      if (score >= 7) return 'yellow';
      return 'red';
    },
    submitFeedback() {
      if (this.feedback.trim() !== '') {
        this.submitted = true;
        console.log("Feedback submitted:", this.feedback);
      }
    }
  }
};
</script>

<style scoped>
h1 {
  color: #af2727 ;
  font-size: 1.8rem;
  margin-bottom: 2rem;
  font-weight: 700;
}
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
.yellow {
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

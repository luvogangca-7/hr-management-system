<template>
  <span class="count-up">{{ currentValue.toLocaleString() }}</span>
</template>

<script>
export default {
  props: {
    value: {
      type: Number,
      required: true
    },
    duration: {
      type: Number,
      default: 2000
    },
    decimals: {
      type: Number,
      default: 0
    }
  },
  data() {
    return {
      currentValue: 0
    }
  },
  mounted() {
    this.animateValue();
  },
  methods: {
    animateValue() {
      const start = 0;
      const end = this.value;
      const duration = this.duration;
      const startTime = performance.now();
      
      const animate = (currentTime) => {
        const elapsedTime = currentTime - startTime;
        const progress = Math.min(elapsedTime / duration, 1);
        this.currentValue = parseFloat((start + progress * (end - start)).toFixed(this.decimals));
        
        if (progress < 1) {
          requestAnimationFrame(animate);
        } else {
          this.currentValue = end;
        }
      };
      
      requestAnimationFrame(animate);
    }
  },
  watch: {
    value(newVal) {
      this.animateValue();
    }
  }
}
</script>
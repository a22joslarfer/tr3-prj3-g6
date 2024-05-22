<template>
  <div>
    <span
      v-for="star in 5"
      :key="star"
      @click="rate(star)"
      :class="{ selected: star <= ratingValue }"
    >
      ★
    </span>
  </div>
</template>

<script>
export default {
  props: {
    ratingValue: {
      type: Number,
      default: 1
    }
  },
  methods: {
    rate(star) {
      this.$emit('input', star);
    }
  }
}
</script>

<style scoped>
span {
  cursor: pointer;
  font-size: 2em;
  color: gray;
}
span.selected {
  color: gold;
}
</style>

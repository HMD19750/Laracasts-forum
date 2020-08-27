<template>
  <button type="submit" :class="classes" @click="toggle">
    <span class="fas fa-heart"></span>
    <span v-text="favoritesCount"></span>
  </button>
</template>

<script>
export default {
  props: ["reply"],

  data() {
    return {
      favoritesCount: this.reply.favoritesCount,
      isFavorited: this.reply.isFavorited
    }
  },

  computed: {
      classes() {
          return ['btn', this.isFavorited ? 'btn-primary' : 'btn-outline-primary'];
      },

      endpoint() {
          return "/forum/public/replies/" + this.reply.id + "/favorites";
      }
  },

  methods: {
    toggle() {
      if (this.isFavorited) {
          this.destroy();
      } else {
          this.create();
      }
    },

    create() {
        axios.post(this.endpoint);
        this.isFavorited=true;
        this.favoritesCount++;
    },

    destroy() {
        axios.delete(this.endpoint);
        this.isFavorited=false;
        this.favoritesCount--;
    }
  },
};
</script>

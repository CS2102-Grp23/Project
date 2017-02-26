<template>
  <div class="alerts">
    <div v-for="alert in alerts" v-bind:class="alert.type" transition="expand">
      <p>
        {{alert.message}}
      </p>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['alerts'],
  };
</script>
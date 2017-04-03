<template>
  <div id="project-card" class="card project">
    <div class="card-image">
      <img :src="project.imageUrl">
    </div>
    <div>
      <a v-bind:href="'/project/' + project.projectID"><i class="material-icons">view_module</i></a>
    </div>
    <div class="card-content">
      <div class="card-title">{{ project.title }}</div>
      <div>
        <span class="info-name">Category: </span>
        <span class="project-info">{{ project.category }}</span>
      </div>
      <div>
        <span class="info-name">Start Date: </span>
        <span class="project-info">{{ project.startDate }}</span>
      </div>
      <div>
        <span class="info-name">End Date: </span>
        <span class="project-info">{{ project.endDate }}</span>
      </div>
      <div>
        <span class="info-name">Target Amount: </span>
        <span class="project-info">{{ project.targetAmount }}</span>
      </div>
    </div>
  </div>
</template>

<script>
  import projectRepository from '../../data/ProjectRepository';
  export default {
    props: ['project'],
    data() {
      return {
        id: '',
        title: '',
        description: '',
        category: '',
        startDate: '',
        endDate: '',
        targetAmount: 0,
        currentAmount: 0,
        imageUrl: '',
      };
    },
    methods: {
      contribute() {

      },
      favorite() {

      },
      displayProject() {
        this.$eventHub.$emit('displayProject', this.project);
      },
    },
  };
</script>

<template>
  <div id="project-card" class="card project">
    <div class="card-image">
      <img :src="project.imageUrl">
    </div>
    <div class="card-content" @click.prevent="displayProject">
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
    <div id="profile-card-action" class="card-action">
      <a class="btn-floating btn red" @click.stop="contribute"><i class="tiny material-icons">monetization_on</i></a>
      <a class="btn-floating btn red" @click.stop="favorite"><i class="tiny material-icons">favorite</i></a>
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

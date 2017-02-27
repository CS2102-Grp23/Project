<template>
  <div id="project-card" class="card project" @click.prevent="displayProject">
    <div class="card-image">
      <img :src="project.imageUrl">
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
    <div id="profile-card-action" class="card-action">
      <a class="btn-floating btn red" @click.stop="contribute"><i class="tiny material-icons">monetization_on</i></a>
      <span class="project-info"><input type="number" id="contribution" placeholder="Contribute"></span>
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
        console.log()
      },
      displayProject() {
        this.$eventHub.$emit('displayProject', this.project);
      },
    },
  };
</script>

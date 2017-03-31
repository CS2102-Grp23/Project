<template>
  <div id="contribute-body">
    <div id="project-info">
      <h4>{{ project.title }}</h4>
      <div>
        <p class="info-name">Short Blurb: </p>
        <p class="project-info">{{ project.description }}</p>
      </div>
      <div>
        <p class="info-name">Category: </p>
        <p class="project-info">{{ project.category }}</p>
      </div>
      <div>
        <p class="info-name">Start Date: </p>
        <p class="project-info">{{ project.startDate }}</p>
      </div>
      <div>
        <p class="info-name">End Date: </p>
        <p class="project-info">{{ project.endDate }}</p>
      </div>
      <div>
        <p class="info-name">Target Amount: </p>
        <p class="project-info">{{ project.targetAmount }}</p>
      </div>
    </div>
    <hr />
    <div class="contribute-info" v-show="!user">
      <h5>Want to contribute? <a href="/register">Register </a> here.</h5>
    </div>
		<div class="contribute-info" v-show="user">
      <h5 id="contribute-title">Contribute</h5>
      <div class="row">
        <div class="input-field col s6">
          <i class="material-icons prefix">account_circle</i>
          <input id="card-name" type="text" class="validate">
          <label for="card-name">Card Name</label>
        </div>
        <div class="input-field col s6">
          <i class="material-icons prefix">credit_card</i>
          <input id="card-number" type="number" class="validate">
          <label for="card-number">Card Number</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">credit_card</i>
          <input id="card-cvc" type="number" class="validate">
          <label for="card-cvc">CVC</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">email</i>
          <input id="bill-address" type="text" class="validate">
          <label for="bill-address">Billing Address</label>
        </div>
      </div>
      <button type="submit" class="waves-effect waves-light btn" id="contribute-btn">Contribute</button>
    <div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        project: {},
        user: {},
      };
    },
    methods: {
      contribute() {

      },
      getProject() {
        this.$http.get(`/project/${this.title}`).then(response => {
          this.project = response.data;
        });
      },
      processUser() {
        this.$http.get('/user/getUser').then(response => {
          if(response.data[0]) {
            this.user = response.data;
          } else {
            this.user = null;
          }
        });
      },
    },
    mounted() {
      this.getProject();
      this.processUser();
    },
  };
</script>

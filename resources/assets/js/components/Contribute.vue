<template>
  <div id="contribute-body">
    <div id="project-info">
      <h4>{{ project.title }}</h4>
      <div>
        <span class="info-name">Short Blurb: </span>
        <span class="project-info">{{ project.description }}</span>
      </div>
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
      <div class="row">
        <div class="col s4" v-show="user">
          <span class="info-name">My Contribution: </span>
          <span class="project-info">{{ project.coalesce }}</span>
        </div>
        <div class="col s4">
          <span class="info-name">Current Amount: </span>
          <span class="project-info">{{ project.sum }}</span>
        </div>
        <div class="col s4">
          <span class="info-name">Target Amount: </span>
          <span class="project-info">{{ project.targetAmount }}</span>
        </div>
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
        <div class="input-field col s6">
          <i class="material-icons prefix">credit_card</i>
          <input id="card-cvc" type="number" class="validate">
          <label for="card-cvc">CVC</label>
        </div>
        <div class="input-field col s6">
          <i class="material-icons prefix">payment</i>
          <input id="user-contribution" type="number" class="validate" v-model="contribution">
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">email</i>
          <input id="bill-address" type="text" class="validate">
          <label for="bill-address">Billing Address</label>
        </div>
      </div>
      <button type="submit" class="waves-effect waves-light btn" id="contribute-btn" @click.prevent="contribute">Contribute</button>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        project: {},
        user: {},
        contribution: 0,
        currentAmount: 0,
      };
    },
    methods: {
      contribute() {
        const postData = {
          projectID: this.$route.params.id,
          contribution: this.contribution,
        };
        this.$http.post('/project/contribute', postData).then(response => {
          if(response.data == 'SUCCESS') {
            this.$eventHub.$emit('alert', { type: 'success', message: `Contribution to ${this.$route.params.id} successful` });
            this.getProject();
          } else {
            this.$eventHub.$emit('alert', { type: 'error', message: response.data })
          }
        });
      },
      getProject() {
        this.$http.get(`/projects/oneProject/${this.$route.params.id}`).then(response => {
          this.project = response.data[0];
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

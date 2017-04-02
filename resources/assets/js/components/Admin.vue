<template>
  <div id="admin-body" v-show="admin">
    <h2>Welcome, {{ admin.username }}</h2>
    <div id="management-buttons">
      <a class="waves-effect waves-light btn" v-on:click="manageUsers">
        <i class="material-icons left">cloud</i>Manage Users
      </a>
      <a class="waves-effect waves-light btn" v-on:click="manageProjects">
        <i class="material-icons left">cloud</i>Manage Projects
      </a>
    </div>
    <div id="project-list" v-show="isManageProjects">
      <div class="collection" v-for="project in projects">
        <div class="collection-item" :project="project">
          {{ project.title }}
          <div>
            <a class="waves-effect waves-light btn">
              <i class="material-icons left">cloud</i>Delete
            </a>
            <a class="waves-effect waves-light btn" v-bind:href="'/project/' + project.projectID">
              <i class="material-icons left">cloud</i>Visit
            </a>
          </div>
        </div>
      </div>
    </div>
    <div id="user-list" v-show="isManageUsers">
      <div class="collection" v-for="user in users">
        <div class="collection-item" :user="user">
          {{ user.username }}
          <div>
            <a class="waves-effect waves-light btn">
              <i class="material-icons left">cloud</i>Delete
            </a>
            <a class="waves-effect waves-light btn" v-bind:href="'/profile/' + user.username">
              <i class="material-icons left">cloud</i>Visit
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        admin: [],
        users: [],
        projects: [],
        isManageUsers: false,
        isManageProjects: false,
      };
    },
    methods: {
      manageUsers() {
        this.isManageUsers = !this.isManageUsers;
        this.isManageProjects = false;
      },
      manageProjects() {
        this.isManageUsers = false;
        this.isManageProjects = !this.isManageProjects;
      },
      getProjects() {
        this.$http.get('/projects/all').then(response => {
          this.projects = response.data;
        });
      },
      getUsers() {
        this.$http.get('/profiles/all').then(response => {
          this.users = response.data;
        });
      },
      processUser() {
        this.$http.get('/user/getUser').then(response => {
          if(response.data[0].accesslevel) {
            this.admin = response.data[0];
          } else {
            this.admin = null;
          }
        });
      },
    },
    created: function () {
    },
    mounted() {
      this.getProjects();
      this.getUsers();
      this.processUser();
    },
  };
</script>

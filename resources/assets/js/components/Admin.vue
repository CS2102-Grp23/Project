<template>
  <div id="admin-body" v-show="(Object.keys(admin).length > 0)">
    <h2>Welcome, {{ admin.username }}</h2>
    <div id="management-buttons">
      <a class="waves-effect waves-light btn" v-on:click="manageUsers">
        <i class="material-icons left">supervisor_account</i>Manage Users
      </a>
      <a class="waves-effect waves-light btn" v-on:click="manageProjects">
        <i class="material-icons left">assignment</i>Manage Projects
      </a>
    </div>
    <div id="project-list" v-show="isManageProjects">
      <div class="collection" v-for="project in projects">
        <div class="collection-item" :project="project">
          {{ project.title }}
          <div>
            <a class="waves-effect waves-light btn" v-bind:href="'/project/' + project.projectID">
              <i class="material-icons left">pageview</i>View
            </a>
          </div>
        </div>
      </div>
    </div>
    <div id="user-list" v-show="isManageUsers">
      <form action="#" class="admin-filter">
        <span class="filter">
          <label>Filter</label>
          <select v-model="filterChoice" @change="filterUser">
             <option v-for="filterChoice in adminFilter" v-bind:value="filterChoice">{{ filterChoice }}</option>
          </select>
        </span>
        <span v-show="isTopNoneRadio">
          <span class="filter" v-show="(filterChoice !== 'All')">
            <input type="radio" id="top" value="Top" v-model="radioFilter" @change="filterUser"/>
            <label for="top">Top</label>
          </span>
          <span class="filter" v-show="(filterChoice !== 'All')">
            <input type="radio" id="none" value="None" v-model="radioFilter" @change="filterUser"/>
            <label for="none">None</label>
          </span>
        </span>
        <span v-show="isLimitOn" class="filter">
          <span class="switch">
            <label>
              Off Limit
              <input type="checkbox" v-model="toggleFilter" @change="filterUser" />
              <span class="lever"></span>
              Limit 10
            </label>
          </span>
        </span>
      </form>
      <div class="collection" v-for="user in users">
        <div class="collection-item" :user="user">
          {{ user.username }}
          <div>
            <a class="waves-effect waves-light btn" v-bind:href="'/profile/' + user.username">
              <i class="material-icons left">pageview</i>View
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import adminFilter from '../data/admin.js';

  export default {
    data() {
      return {
        admin: [],
        users: [],
        projects: [],
        adminFilter,
        filterChoice: "All",
        isTopNoneRadio: false,
        isLimitOn: false,
        isManageUsers: false,
        isManageProjects: false,
        toggleFilter: false,
        radioFilter: 'Top',
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
      filterUser() {
        if (this.filterChoice === adminFilter[0]) {   // No Activity
          this.isTopNoneRadio = false;
          this.isLimitOn = true;

          if (!this.toggleFilter) {
            this.$http.get('/admin/noAct').then(response => {
              if(response.data) {
                this.users = response.data;
              } else {
                this.users = null;
                this.isTopNoneRadio = false;
                this.isLimitOn = false;
              }
            });
          } else if (this.toggleFilter) {
            this.$http.get('/admin/noActSum').then(response => {
              if(response.data) {
                this.users = response.data;
              } else {
                this.users = null;
                this.isTopNoneRadio = false;
                this.isLimitOn = false;
              }
            });
          }
        } else if (this.filterChoice === adminFilter[1]) {  // Contributions
          this.isTopNoneRadio = true;
          this.isLimitOn = true;

          if (this.radioFilter === 'Top') {
            if (!this.toggleFilter) {
              this.$http.get('/admin/topCon').then(response => {
                if(response.data) {
                  this.users = response.data;
                } else {
                  this.users = null;
                  this.isTopNoneRadio = false;
                  this.isLimitOn = false;
                }
              });
            } else if (this.toggleFilter) {
              this.$http.get('/admin/topConSum').then(response => {
                if(response.data) {
                  this.users = response.data;
                } else {
                  this.users = null;
                  this.isTopNoneRadio = false;
                  this.isLimitOn = false;
                }
              });
            }
          } else if (this.radioFilter === 'None') {
            if (!this.toggleFilter) {
              this.$http.get('/admin/noCon').then(response => {
                if(response.data) {
                  this.users = response.data;
                } else {
                  this.users = null;
                  this.isTopNoneRadio = false;
                  this.isLimitOn = false;
                }
              });
            } else if (this.toggleFilter) {
              this.$http.get('/admin/noConSum').then(response => {
                if(response.data) {
                  this.users = response.data;
                } else {
                  this.users = null;
                  this.isTopNoneRadio = false;
                  this.isLimitOn = false;
                }
              });
            }
          }
        } else if (this.filterChoice === adminFilter[2]) {  // No Projects
          this.isTopNoneRadio = false;
          this.isLimitOn = true;

          if (!this.toggleFilter) {
            this.$http.get('/admin/noProj').then(response => {
              if(response.data) {
                this.users = response.data;
              } else {
                this.users = null;
                this.isTopNoneRadio = false;
                this.isLimitOn = false;
              }
            });
          } else if (this.toggleFilter) {
            this.$http.get('/admin/noProjSum').then(response => {
              if(response.data) {
                this.users = response.data;
              } else {
                this.users = null;
                this.isTopNoneRadio = false;
                this.isLimitOn = false;
              }
            });
          }
        } else if (this.filterChoice === adminFilter[3]) {  // Fulfilled Projects
          this.isTopNoneRadio = false;
          this.isLimitOn = true;

          if (!this.toggleFilter) {
            this.$http.get('/admin/TopFull').then(response => {
              if(response.data) {
                this.users = response.data;
              } else {
                this.users = null;
                this.isTopNoneRadio = false;
                this.isLimitOn = false;
              }
            });
          } else if (this.toggleFilter) {
            this.$http.get('/admin/TopFullSum').then(response => {
              if(response.data) {
                this.users = response.data;
              } else {
                this.users = null;
                this.isTopNoneRadio = false;
                this.isLimitOn = false;
              }
            });
          }
        } else if (this.filterChoice === adminFilter[4]) {  // Similar Users
          this.isTopNoneRadio = false;
          this.isLimitOn = true;

          if (!this.toggleFilter) {
            this.$http.get('/admin/TopSimilar').then(response => {
              if(response.data) {
                this.users = response.data;
              } else {
                this.users = null;
                this.isTopNoneRadio = false;
                this.isLimitOn = false;
              }
            });
          } else if (this.toggleFilter) {
            this.$http.get('/admin/TopSimilarSum').then(response => {
              if(response.data) {
                this.users = response.data;
              } else {
                this.users = null;
                this.isTopNoneRadio = false;
                this.isLimitOn = false;
              }
            });
          }
        } else if (this.filterChoice === adminFilter[5]) {  // Nation
          this.isTopNoneRadio = false;
          this.isLimitOn = false;

          if (!this.toggleFilter) {
            this.$http.get('/admin/TopNationCon').then(response => {
              if(response.data) {
                this.users = response.data;
              } else {
                this.users = null;
                this.isTopNoneRadio = false;
                this.isLimitOn = false;
              }
            });
          } else if (this.toggleFilter) {
            this.$http.get('/admin/TopNationConSum').then(response => {
              if(response.data) {
                this.users = response.data;
              } else {
                this.users = null;
                this.isTopNoneRadio = false;
                this.isLimitOn = false;
              }
            });
          }
        } else {
          this.isTopNoneRadio = false;
          this.isLimitOn = false;
          this.getUsers();
        }
      }
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

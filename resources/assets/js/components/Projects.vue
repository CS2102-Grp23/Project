<template>
  <div>
    <div id="projects-dashboard">
      <div id="projects-buttons">
        <a class="waves-effect waves-light btn" v-on:click="manageSearch" :disabled="isSearch">
          <i class="material-icons left">cloud</i>Search Projects
        </a>
        <a class="waves-effect waves-light btn" v-on:click="manageFilter" :disabled="isFilter">
          <i class="material-icons left">cloud</i>Filter Projects
        </a>
        <a class="waves-effect waves-light btn" v-on:click="manageCreate" :disabled="isCreate">
          <i class="material-icons left">assignment</i>Create Projects
        </a>
      </div>
      <div v-show="isSearch" id="search-projects">
        <input id="search" type="search" v-model="searchQuery">
        <label class="label-icon" for="search"><i class="material-icons search-icon">search</i></label>
      </div>
      <div v-show="isFilter" id="filter-projects">
        <select id="filter-categories" v-model="filterCategory" @change="filterProjects">
          <option v-for="filterCategory in categoryList" v-bind:value="filterCategory">{{ filterCategory }}</option>
        </select>
      </div>
      <create-project-form v-show="isCreate"></create-project-form>
    </div>
    <projects :projects="projects"></projects>
	</div>
</template>

<script>
	import Projects from './projects/Index';
	import CreateProjectForm from './projects/Create';
  import categoryList from '../data/category';

	export default {
		components: {
			Projects,
			CreateProjectForm,
		},
		data() {
			return {
        projects: [],
        projectInfo: {},
        isModalShown: false,
        isCreate: false,
        isFilter: false,
        isSearch: true,
        searchQuery: '',
        filterCategory: 'All',
        categoryList,
			};
		},
		methods: {
      getProjects() {
        this.$http.get('/projects/all').then(response => {
          if (response.data) {
            console.log('hello');
            this.projects = response.data;
          }
        });
      },
      manageFilter() {
        this.isFilter = true;
        this.isSearch = false;
        this.isCreate = false;
        this.filterCategory = 'All';
        this.filterProjects();
      },
      manageSearch() {
        this.isFilter = false;
        this.isSearch = true;
        this.isCreate = false;
        this.getProjects();
      },
      manageCreate() {
        this.isFilter = false;
        this.isSearch = false;
        this.isCreate = true;
        this.getProjects();
      },
      filterProjects() {
        this.$http.get(`/search/category/${this.filterCategory}`).then(response => {
          if (response.data) {
            this.projects = response.data;
          } else {
            this.projects = null;
          }
        });
      },
		},
    created: function () {
    },
    mounted() {
      this.getProjects();
    },
	};
</script>

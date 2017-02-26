<template>
  <div>
    <create-project-form></create-project-form>
    <projects :projects="projects"></projects>
		 <update-modal :project="selectedProject"></update-modal>
	</div>
</template>

<script>
	import Projects from './projects/Index';
	import CreateProjectForm from './projects/Create';
	import UpdateModal from './projects/Update';
	
	export default {
		components: {
			Projects,
			CreateProjectForm,
			UpdateModal,
		},
		data() {
			return {
				selectedProject: null,
        projects: [],
			};
		},
		methods: {
      getProjects() {
        this.$http.get('/projects/all').then(response => {
          this.projects = response.data;
          //console.log(this.projects);
        });
      },
			selectProject(project) {
				this.selectedProject = project;
			},
		},
    mounted() {
      this.getProjects();
    },
	};
</script>
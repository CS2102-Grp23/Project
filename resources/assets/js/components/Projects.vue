<template>
  <div>
    <!--
    <div v-show="isModalShown" id="modal-container" @click.prevent="isModalShown = false">
      <div class="modal" id="project-modal">
        <div class="modal-content">
          <h4>{{ projectInfo.title }}</h4>
          <div>
            <span class="info-name"Short Blurb: </span>
            <p class="project-info">{{ projectInfo.description }}</p>
          </div>
          <div>
            <span class="info-name">Category: </span>
            <span class="project-info">{{ projectInfo.category }}</span>
          </div>
          <div>
            <span class="info-name">Start Date: </span>
            <span class="project-info">{{ projectInfo.startDate }}</span>
          </div>
          <div>
            <span class="info-name">End Date: </span>
            <span class="project-info">{{ projectInfo.endDate }}</span>
          </div>
          <div>
            <span class="info-name">Target Amount: </span>
            <span class="project-info">{{ projectInfo.targetAmount }}</span>
          </div>
        </div>
        <div class="modal-footer">
          <a href="/contribute" class="modal-action waves-effect waves-green btn-flat">Contribute</a>
          <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" @click.prevent="isModalShown = false">Close</a>
        </div>
      </div>
    </div> -->
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
        isModalShown: false,
        projectInfo: {},
			};
		},
		methods: {
      getProjects() {
        this.$http.get('/projects/all').then(response => {
          this.projects = response.data;
        });
      },
			selectProject(project) {
				this.selectedProject = project;
			},
      createModal(project) {
        this.projectInfo = project;
        this.isModalShown = true;
      }
		},
    created: function () {
      this.$eventHub.$on('displayProject', this.createModal)
    },
    mounted() {
      this.getProjects();
    },
	};
</script>
<template>
	<div id="projects-body" ref="projects">
    <div v-for="project in projects">
    	<project :project="project"></project>
    </div>
	</div>
</template>

<script>
	import Masonry from 'masonry-layout';
	import Project from './Project';
	import projectRepository from '../../data/ProjectRepository';

	export default {
    props: ['projects'],
		components: {
			Project,
		},
		data() {
			return {
				searchQuery: '',
			};
		},
		watch: {
			'filteredProjects': {
				handler() {
          this.$nextTick(() => {
            this.masonry.reloadItems();
            this.masonry.layout();
          });
				},
				deep: true,
			},
		},
    computed: {
      filteredProjects() {
        return this.projects.filter((project) => {
          if (this.searchQuery) {
            return (project.title.indexOf(this.searchQuery) !== -1 ||
              project.content.indexOf(this.searchQuery) !== -1);
          }
          return true;
        });
      },
    },
		methods: {
			selectProject: function({ key, title, content }) {
				this.$eventHub.$emit('selectProject', { key, title, content });
			},
      search: function(query) {
        this.searchQuery = query;
      },
			changeLayout: function(project) {
				this.projects.unshift(project);
			},
		},
    created: function () {
      this.$eventHub.$on('queryProjects', this.search);
			this.$eventHub.$on('projectAdded', this.changeLayout);
    },
		mounted() {
			this.masonry = new Masonry(this.$refs.projects, {
				itemSelector: '.project',
				columnWidth: 40,
				gutter: 2,
				fitWidth: true,
			});
			projectRepository.on('added', (project) => {
				this.projects.unshift(project);
			});
			projectRepository.on('changed', ({ key, title, content }) => {
				const outdatedProject = projectRepository.find(this.projects, key);
				outdatedProject.title = title;
				outdatedProject.content = content;
			});
			projectRepository.on('removed', ({ key }) => {
				const projectToRemove = projectRepository.findIndex(this.projects, key)
      	this.projects.splice(projectToRemove, 1)
			});
		},
	};
</script>

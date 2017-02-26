<template>
	<form class="create-project" action="/projects/create" method="POST" @submit.prevent="createProject">
		<div class="row">
			<div class="col s12">
				<div class="input-field">
					<input id="title" name="title" v-model="title" placeholder="Project Title">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col s12">
				<div class="input-field">
					<input id="description" ame="description" v-model="description" placeholder="Project Description">
				</div>
			</div>
		</div>
		<div class="row">
        <div class="col s6">
          <div class="input-field">
            <input placeholder="Start Date" id="startDate" v-model="startDate" type="date" class="datepicker">
          </div>
        </div>
				<div class="col s6">
          <div class="input-field">
            <input placeholder="End Date" id="endDate" v-model="endDate" type="date" class="datepicker">
          </div>
        </div>
      </div>
		</div>
		<div class="row">
      <div class="col s3">
        <div class="input-field">
          <input placeholder="Category" id="category" v-model="category" type="text" class="validate">
        </div>
      </div>
			<div class="col s3">
        <div class="input-field">
          <input placeholder="Target Amount" id="targetAmount" v-model="targetAmount" type="text" class="validate">
        </div>
      </div>
			<div class="col s6">
				<div class="file-field input-field">
					<div class="btn">
		        <span>File</span>
		        <input type="file">
		      </div>
		      <div class="file-path-wrapper">
		        <input placeholder="Uploade Your Image" class="file-path validate" type="text"  v-model="imageUrl">
		      </div>
				</div>
			</div>
    </div>
		<button type="submit">
			<a class="btn-floating btn red"><i class="small material-icons add">add</i></a>
		</button>
	</form>
</template>

<script>
	import projectRepository from '../../data/ProjectRepository';

	export default {
		data() {
			return {
				title: '',
				description: '',
				startDate: '',
				endDate: '',
				imageUrl: '',
				category: '',
				targetAmount: '',
			};
		},
		methods: {
			createProject() {
				const postData = {
          title: this.title,
          description: this.description,
          startDate: this.startDate,
          endDate: this.endDate,
          imageUrl: this.imageUrl,
					targetAmount: this.targetAmount,
					category: this.category,
        }
				//console.log(postData);
        this.$http.post('/projects/create', postData).then(response => {
          console.log(response.data);
          if(response.data == 'SUCCESS') {
						this.$eventHub.$emit('projectAdded', postData);
            this.$eventHub.$emit('alert', { type: 'success', message: 'project successfully created' })
          } else {
            return this.$eventHub.$emit('alert', { type: 'error', message: 'Failed to create project' });
          }
        });
				/**
				if (this.title.trim() || this.content.trim()) {
					projectRepository.create({
						title: this.title,
						content: this.content,
					}, (err) => {
						if (err) {
							return this.$eventHub.$emit('alert', { type: 'error', message: 'Failed to create project' });
						}
						this.title = '';
						this.content = '';
						return this.$eventHub.$emit('alert', { type: 'success', message: 'project successfully created' });
					});
				}**/
			},
		},
	};
</script>

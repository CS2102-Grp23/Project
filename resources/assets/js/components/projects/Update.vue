<template>
  <div v-if="project" transition="modal" class="backdrop" @click="dismissModal">
    <form class="edit-project" @submit.prevent="update" @click.stop="">
      <input name="title" v-model="project.title" placeholder="Title" />
      <textarea name="content" v-model="project.content" placeholder="Your project here" rows="8"></textarea>
      <button type="button" @on:click="remove"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
    	<button type="submit">Done</button>
    </form>
  </div>
</template>

<script>
  import projectRepository from '../../data/ProjectRepository';
  export default {
    props: ['project'],
    methods: {
      remove() {
        projectRepository.remove(this.project, (err) => {
          if (err) {
            return this.$eventHub.$emit('alert', { type: 'error', message: 'Failed to delete project' });
          }
          this.dismissModal();
          return this.$eventHub.$emit('alert', { type: 'success', message: 'project successfully deleted' });
        });
      },
      update() {
        projectRepository.update(this.project, (err) => {
          if (err) {
            return this.$eventHub.$emit('alert', { type: 'error', message: 'Failed to update project' });
          }
          this.dismissModal();
          return this.$eventHub.$emit('alert', { type: 'success', message: 'project successfully updated' });
        });
      },
      dismissModal() {
        this.project = null;
      },
    },
  };
</script>
<style>
  .backdrop {
    position: fixed;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    background: rgba(50, 50, 50, 0.8);
  }
  form.edit-project {
    position: relative;
    width: 480px;
    max-width: 100%;
    margin: 25vh auto 0;
    background: #fff;
    padding: 15px;
    border-radius: 2px;
    box-shadow: 0 1px 50px #555;
  }
  form.edit-project input, form.edit-project textarea {
    width: 100%;
    max-width: 100%;
    border: none;
    padding: 4px;
    outline: none;
    font-size: 18px;
  }
  form.edit-project button[type=submit] {
    font-size: 18px;
    float: right;
    background: #41b883;
    color: #fff;
    border: none;
    border-radius: 3px;
    opacity: 1;
    cursor: pointer;
    padding: 4px 6px;
    margin: 0;
  }
  form.edit-project button {
    background: none;
    border: none;
    font-size: 20px;
    opacity: 0.6;
    cursor: pointer;
    transition: opacity .5s;
    margin: 0 4px 0 0;
  }
  form.edit-project button:hover, form.edit-project button:focus {
    opacity: 1;
  }
  .modal-transition {
    transition: opacity .3s ease;
    opacity: 1;
  }
  .modal-transition form {
    transition: transform .3s ease;
  }
  .modal-enter, .modal-leave {
    opacity: 0;
  }
  .modal-enter form, .modal-leave form {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
  }
</style>
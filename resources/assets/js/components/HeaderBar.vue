<template>
	<div class="navbar-fixed">
		<nav id="header-bar">
			<div id="header-nav-wrapper" class="nav-wrapper">
				<div>
					<a href="/" class="brand-logo hide-on-med-and-down">CS2102</a>
					<input type="checkbox" id="drawer-toggle" class="hide-on-large-only" /><i id="drawer-toggle-label" for="drawer-toggle" class="material-icons hide-on-large-only">menu</i>
				</div>
				<ul class="right hide-on-med-and-down">
					<li v-show="isAdmin"><a href="/admin">Admin</a></li>
					<li><a href="/projects">Projects</a></li>
					<li><a href="/user">Profile</a></li>
					<li v-if="!user"><a href="/register">Login</a></li>
					<li v-if="user"><a href="#" @click.prevent="signOut">Logout</a></li>
				</ul>
				<ul class="side-nav" id="drawer">
					<li><a href="/projects">Projects</a></li>
					<li><a href="/profile">Profile</a></li>
					<li v-if="!user"><a href="/register">Login</a></li>
					<li v-if="user"><a href="#" @click.prevent="signOut">Logout</a></li>
				</ul>
			</div>
		</nav>
	</div>
</template>

<script>
  export default {
    data() {
      return {
				user: null,
        searchQuery: '',
				filterCategory: 'All',
				sortCategory: 'Most Recent',
				isAdmin: false,
      };
    },
    watch: {
      searchQuery: function search() {
        this.$eventHub.$emit('search', this.searchQuery);
      },
    },
    methods: {
      processUser() {
        this.$http.get('/user/getUser').then(response => {
          if(response.data[0]) {
            this.user = response.data[0];
						if (this.user.accesslevel) {

							this.isAdmin = true;
						}
          } else {
            this.user = null;
						this.isAdmin = false;
          }
        });
      },
      signOut() {
        this.user = null;
				this.isAdmin = false;
        this.$http.get('/user/logout');
        this.$eventHub.$emit('alert', { type: 'success', message: 'Logout successfully' });
        this.$router.push('/register');
      },
    },
    created: function () {
      this.$eventHub.$on('login', this.processUser);
    },
    mounted() {
      this.processUser();
    },
  };
</script>

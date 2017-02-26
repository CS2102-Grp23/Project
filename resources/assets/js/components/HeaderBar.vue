<template>
	<div class="navbar-fixed">
		<nav id="header-bar">
			<div id="header-nav-wrapper" class="nav-wrapper">
				<a href="#!" class="brand-logo hide-on-med-and-down">CS2102</a>
				<a href="#" class="button-collapse" data-activates="mobile-demo"><i class="material-icons">menu</i></a>
				<div id="search-filter-form">
					<div id="search-filter-bar" class="input-field">
						<input id="search" type="search" placeholder="Search" v-model="searchQuery" debounce="500">
						<label class="label-icon" for="search"><i class="material-icons">search</i></label>
						<a id="filter" class='dropdown-button btn' href='#' data-activates='dropdown-filter'>Filter</a>
						<ul id='dropdown-flter' class='dropdown-content'>
							<li><a href="#">one</a></li>
							<li><a href="#">two</a></li>
							<li><a href="#">three</a></li>
						</ul>
					</div>
				</div>
				<ul class="right hide-on-med-and-down">
					<li><a href="/#/projects">Projects</a></li>
					<li><a href="/#/profile">Profile</a></li>
					<li v-if="!user"><a href="/#/register">Login</a></li>
					<li v-if="user"><a href="#" @click.prevent="signOut">Logout</a></li>
				</ul>
				<ul class="side-nav" id="mobile-demo">
					<li><a href="/#/projects">Projects</a></li>
					<li><a href="/#/profile">Profile</a></li>
					<li v-if="!user"><a href="/#/register">Login</a></li>
					<li v-if="user"><a href="#" @click.prevent="signOut">Logout</a></li>
				</ul>
			</div>
		</nav>
	</div>
</template>

<script>
  import Auth from '../data/Auth';

  export default {
    data() {
      return {
				user: null,
        searchQuery: '',
      };
    },
    watch: {
      searchQuery: function search() {
        this.$eventHub.$emit('search', this.searchQuery);
      },
    },
    methods: {
			processUser(authed) {
        if (authed === '') {
          this.user = null;
          return;
        }
        this.user = {
          userTitle: authed.displayName || authed || '',
          //imageUrl: authed.profileImageURL || '',
        };
			},
      signOut() {
        Auth.logout();
        this.$router.go('/register');
      },
    },
    mounted() {
      this.processUser(Auth.getEmail());
    },
  };
</script>

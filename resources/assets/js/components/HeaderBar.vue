<template>
	<div class="navbar-fixed">
		<nav id="header-bar">
			<div id="header-nav-wrapper" class="nav-wrapper">
				<a href="#!" class="brand-logo hide-on-med-and-down">CS2102</a>
				
        <input type="checkbox" id="drawer-toggle" class="hide-on-large-only" /><i id="drawer-toggle-label" for="drawer-toggle" class="material-icons hide-on-large-only">menu</i>
				
        <div id="search-filter-form">
					<div id="search-filter-bar" class="input-field">
						<input id="search" type="search" placeholder="Search" v-model="searchQuery" debounce="500">
						<label class="label-icon" for="search"><i class="material-icons">search</i></label>
						
            <input type="checkbox" id="filter-toggle" />
            <button id="filter" class="btn">Filter</button>
            <ul id="filter-content">
                <li class="filter-title">Filter by:</li>
                <li class="filter-category">
                  <input type="checkbox" id="your-projects" />
                  <label for="your-projects">Your Projects</label>
                </li>
                <li class="filter-category">
                  <input type="checkbox" id="contributed-projects" />
                  <label for="contributed-projects">Contributed Projects</label>
                </li>
                <li class="filter-category">
                  <input type="checkbox" id="starred-progress" />
                  <label for="starred-projects">Starred Projects</label>
                </li>
                <li class="sort-title">Sort by:</li>
                <select id="sort-categories">
                  <option value="start-date">Start Date</option>
                  <option value="end-date">End Date</option>
                  <option value="most-contributed">Most Contributed</option>
                  <option value="least-contributed">Least Contributed</option>
                </select>
            </ul>
					</div>
				</div>
				<ul class="right hide-on-med-and-down">
					<li><a href="/projects">Projects</a></li>
					<li><a href="/profile">Profile</a></li>
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
            this.user = response.data;
          } else {
            this.user = null;
          }
        });
      },
      signOut() {
        this.user = null;
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

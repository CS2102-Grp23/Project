<template>
	<div>
		<div class="row">
			<div class="col s12 m6 offset-m3">
				<img />
			</div>
		</div>
		<div class="row">
			<div class="col s12 m8 offset-m2">
				<div id="profile-card" class="card">
					<div id="profile-name" class="card-title">
						<h2>{{ user.username }}</h2>
					</div>
					<div class="card-action flow-text">
            <div>
              <span class="user-info-type">Email:  </span>
              <span class="user-info">{{ user.email }}</span>
            </div>
						<div>
              <span class="user-info-type">Name:  </span>
              <span class="user-info">{{ user.name }}</span>
            </div>
					</div>
				</div>
			</div>
		</div>
		<div class="row" id="profile-view-others-btn">
			<form class="card-content" action="/profiles/all" method="POST" @submit.prevent="getAllUsers">
				<button id="view-other-users-btn" class="btn waves-effect waves-light" type="submit" name="viewAllUsers" @click="isOtherProfileShown = (!isOtherProfileShown)">View all other users</button>
			</form>
		</div>
		<div v-show="isOtherProfileShown" class="row">
			<div class="col s12 m8 offset-m2">
				<ul class="collection">
			    <li class="collection-item avatar" v-for="profile in profiles">
			      <img src="" alt="" class="circle">
			      <div class="title">{{ profile.name }}</div>
			      <div class="name">{{ profile.userName }}</div>
						<div class="email">{{ profile.email }}</div>
			      <a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>
			    </li>
				</ul>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				user: {
          name: '',
          email: '',
          username: '',
        },
				profiles: [],
				isOtherProfileShown: false,
			};
		},
		methods: {
			getAllUsers() {
        this.$http.get('/profiles/all').then(response => {
          this.profiles = response.data;
					//this.$router.push('/profiles/allUsers');
        });
			},
			processUser() {
        this.$http.get('/user/getUser').then(response => {
          if(response.data[0]) {
            this.user = response.data[0];
            console.log(this.user.name);
          } else {
            this.user = null;
          }
        });
      },
		},
		mounted() {
      this.processUser();
    },
	};
</script>

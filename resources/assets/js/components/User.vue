<template>
	<div id="user-body">
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
						<div>
              <span class="user-info-type">Nationality:  </span>
              <span class="user-info">{{ user.nationality }}</span>
            </div>
						<div>
              <span class="user-info-type">Credit Card:  </span>
              <span class="user-info">{{ user.creditCard }}</span>
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
			<div class="col s12 m10 offset-m1">
				<ul class="collection">
			    <a v-bind:href="'/profile/' + profile.username" class="collection-item avatar" v-for="profile in profiles">
			      <div class="title">{{ profile.name }}</div>
			      <div class="name">{{ profile.username }}</div>
						<div class="email">{{ profile.email }}</div>
			    </a>
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
        });
			},
			processUser() {
        this.$http.get('/user/getUser').then(response => {
          if(response.data[0]) {
            this.user = response.data[0];
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

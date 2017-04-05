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
						<h2>{{ profile.username }}</h2>
					</div>
					<div class="card-action flow-text">
            <div>
              <span class="user-info-type">Email:  </span>
              <span class="user-info">{{ profile.email }}</span>
            </div>
						<div>
              <span class="user-info-type">Name:  </span>
              <span class="user-info">{{ profile.name }}</span>
            </div>
						<div>
              <span class="user-info-type">Nationality:  </span>
              <span class="user-info">{{ profile.nationality }}</span>
            </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				profile: {
          name: '',
          email: '',
          username: '',
        },
				profiles: [],
				isOtherProfileShown: false,
			};
		},
		methods: {
			getProfile() {
        this.$http.get(`/profiles/oneProfile/${this.$route.params.name}`).then(response => {
          if(response.data[0]) {
            this.profile = response.data[0];
          } else {
            this.profile = null;
          }
        });
      },
		},
		mounted() {
      this.getProfile();
    },
	};
</script>

<template>
	<div id="registration-page" class="row">
    <div class="col s12 m6 offset-m3">
      <div class="card">
        <form v-show="!wantsToSignUp" class="card-content" action="/login" method="POST" @submit.prevent="loginUser">
					<span class="card-title">Login</span>
					<div class="input-field">
						<label for="email">Email</label>
						<input type="email" name="email" id="email" placeholder="Email" required v-model="email" class="validate">
					</div>
					<div class="input-field">
						<label for="password">Password</label>
						<input type="password" name="password" id="password" placeholder="Password" required v-model="password">
					</div>
          <div class="clearfix btn-group">
						<button class="btn waves-effect waves-light" type="submit" name="login" @click="wantsToSignUp = false">Login</button>
            <span>Create an account <a @click="wantsToSignUp = true">here</a></span>
					</div>
        </form>
        <form v-show="wantsToSignUp" class="card-content" action="/signup" method="POST" @submit.prevent="registerUser">
          <span class="card-title">Sign up</span>
          <div class="input-field">
						<label for="email">Full Name</label>
						<input type="text" name="name" id="name" placeholder="Full Name" required v-model="name" class="validate">
					</div>
          <div class="input-field">
						<label for="email">Username</label>
						<input type="text" name="user-name" id="username" placeholder="Username" required v-model="userName" class="validate">
					</div>
          <div class="input-field">
						<label for="email">Email</label>
						<input type="email" name="email" id="email" placeholder="Email" required v-model="email" class="validate">
					</div>
					<div class="input-field">
						<label for="password">Password</label>
						<input type="password" name="password" id="password" placeholder="Password" required v-model="password">
					</div>
					<div class="input-field">
						<label for="confirm-password">Confirm Password</label>
						<input type="password" name="confirm-password" id="confirm-password" placeholder="Confirm Password" v-model="confirmPassword">
					</div>
          <div class="clearfix btn-group">
						<button class="btn waves-effect waves-light" type="submit" name="signup" @click="wantsToSignUp = true">Sign Up</button>
            <span>Already have an account? Login <a @click="wantsToSignUp = false">here</a></span>
					</div>
				</form>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        name: '',
        userName: '',
        email: '',
        password: '',
        confirmPassword: '',
        wantsToSignUp: false,
      };
    },
    methods: {
      loginUser: function (e) {
        const postData = {
          email: this.email,
          password: this.password,
        }
        this.$http.post('/user/login', postData).then(response => {
          if(response.data == 'SUCCESS') {
            this.$eventHub.$emit('alert', { type: 'success', message: 'Login successfully' });
            this.$eventHub.$emit('login');
            this.$router.push('/projects');
          } else {
            this.$eventHub.$emit('alert', { type: 'error', message: response.data });
          }
        });
      },
      registerUser: function (e) {
        const postData = {
          name: this.name,
          userName: this.userName,
          email: this.email,
          password: this.password,
          confirmPassword: this.confirmPassword,
        }
        this.$http.post('/user/signup', postData).then(response => {
          if(response.data == 'SUCCESS') {
            this.$eventHub.$emit('alert', { type: 'success', message: 'Signed up successfully' });
            this.$eventHub.$emit('login');
            this.$router.push('/projects');
          } else {
            this.$eventHub.$emit('alert', { type: 'error', message: response.data })
          }
        });
      },
    },
  };
</script>

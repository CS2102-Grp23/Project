class UserStorage {
  constructor() {
    this.userName = '';
    this.email = '';
    this.name = '';
    this.isLogin = false;
  }
  initializeUser(email) {
    //this.userName = userName;
    this.email = email;
    //this.name = name;
    this.isLogin = true;
  }
  getName() {
    return this.name;
  }
  getEmail() {
    return this.email;
  }
  getUserName() {
    return this.userName;
  }
  isUserLogin() {
    return this.isLogin;
  }
  logout() {
    this.userName = '';
    this.email = '';
    this.name = '';
    this.isLogin = false;
  }
}

export default new UserStorage;